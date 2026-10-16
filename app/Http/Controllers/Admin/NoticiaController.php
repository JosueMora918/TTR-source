<?php

namespace App\Http\Controllers\Admin;

use App\Events\ContenidoModificado;
use App\Http\Controllers\Controller;
use App\Http\Requests\NoticiaRequest;
use App\Models\Noticia;
use App\Services\ImagenService;
use App\Support\Ttr;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class NoticiaController extends Controller
{
    public function __construct(private ImagenService $imagenes)
    {
    }

    public function index(Request $request)
    {
        $q = trim((string) $request->query('q'));
        $estado = in_array($request->query('estado'), Ttr::ESTADOS, true) ? $request->query('estado') : null;
        $plataforma = in_array($request->query('plataforma'), Ttr::PLATAFORMAS, true) ? $request->query('plataforma') : null;

        $noticias = Noticia::with('autor')
            ->buscar($q)
            ->conEstado($estado)
            ->dePlataforma($plataforma)
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('admin.noticias.index', compact('noticias', 'q', 'estado', 'plataforma'));
    }

    public function create()
    {
        return view('admin.noticias.form', ['noticia' => new Noticia(['estado' => 'borrador'])]);
    }

    public function store(NoticiaRequest $request)
    {
        $datos = Arr::except($request->validated(), ['imagen']);
        $datos['user_id'] = $request->user()->id;

        if ($request->hasFile('imagen')) {
            $datos['imagen_portada'] = $this->imagenes->guardar($request->file('imagen'), 'noticias');
        }

        $noticia = Noticia::create($datos);

        ContenidoModificado::dispatch($noticia, $noticia->estaPublicado() ? 'publicado' : 'creado', $request->user());

        return redirect()->route('admin.noticias.index')
            ->with('exito', __('ttr.flash.creado', ['tipo' => __('ttr.tipos.noticia')]));
    }

    public function edit(Noticia $noticia)
    {
        $this->authorize('update', $noticia);

        return view('admin.noticias.form', compact('noticia'));
    }

    public function update(NoticiaRequest $request, Noticia $noticia)
    {
        $this->authorize('update', $noticia);

        $datos = Arr::except($request->validated(), ['imagen']);

        if ($request->hasFile('imagen')) {
            $this->imagenes->eliminar($noticia->imagen_portada);
            $datos['imagen_portada'] = $this->imagenes->guardar($request->file('imagen'), 'noticias');
        }

        $noticia->update($datos);

        $accion = ($noticia->wasChanged('estado') && $noticia->estaPublicado()) ? 'publicado' : 'actualizado';
        ContenidoModificado::dispatch($noticia, $accion, $request->user());

        return redirect()->route('admin.noticias.index')
            ->with('exito', __('ttr.flash.actualizado', ['tipo' => __('ttr.tipos.noticia')]));
    }

    public function cambiarEstado(Request $request, Noticia $noticia)
    {
        $this->authorize('update', $noticia);

        $noticia->update(['estado' => $noticia->estaPublicado() ? 'borrador' : 'publicado']);

        ContenidoModificado::dispatch($noticia, $noticia->estaPublicado() ? 'publicado' : 'despublicado', $request->user());

        return back()->with('exito', __('ttr.flash.estado_cambiado', ['estado' => __('ttr.estado.'.$noticia->estado)]));
    }

    public function destroy(Request $request, Noticia $noticia)
    {
        $this->authorize('delete', $noticia);

        $this->imagenes->eliminar($noticia->imagen_portada);
        ContenidoModificado::dispatch($noticia, 'eliminado', $request->user());
        $noticia->delete();

        return redirect()->route('admin.noticias.index')
            ->with('exito', __('ttr.flash.eliminado', ['tipo' => __('ttr.tipos.noticia')]));
    }
}
