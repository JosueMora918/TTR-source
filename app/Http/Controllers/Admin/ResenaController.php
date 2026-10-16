<?php

namespace App\Http\Controllers\Admin;

use App\Events\ContenidoModificado;
use App\Http\Controllers\Controller;
use App\Http\Requests\ResenaRequest;
use App\Models\Resena;
use App\Services\ImagenService;
use App\Support\Ttr;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class ResenaController extends Controller
{
    public function __construct(private ImagenService $imagenes)
    {
    }

    public function index(Request $request)
    {
        $q = trim((string) $request->query('q'));
        $estado = in_array($request->query('estado'), Ttr::ESTADOS, true) ? $request->query('estado') : null;
        $plataforma = in_array($request->query('plataforma'), Ttr::PLATAFORMAS, true) ? $request->query('plataforma') : null;

        $resenas = Resena::with('autor')
            ->buscar($q)
            ->conEstado($estado)
            ->dePlataforma($plataforma)
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('admin.resenas.index', compact('resenas', 'q', 'estado', 'plataforma'));
    }

    public function create()
    {
        return view('admin.resenas.form', ['resena' => new Resena(['estado' => 'borrador'])]);
    }

    public function store(ResenaRequest $request)
    {
        $datos = Arr::except($request->validated(), ['imagen']);
        $datos['user_id'] = $request->user()->id;

        if ($request->hasFile('imagen')) {
            $datos['imagen_portada'] = $this->imagenes->guardar($request->file('imagen'), 'resenas');
        }

        $resena = Resena::create($datos);

        ContenidoModificado::dispatch($resena, $resena->estaPublicado() ? 'publicado' : 'creado', $request->user());

        return redirect()->route('admin.resenas.index')
            ->with('exito', __('ttr.flash.creado', ['tipo' => __('ttr.tipos.resena')]));
    }

    public function edit(Resena $resena)
    {
        $this->authorize('update', $resena);

        return view('admin.resenas.form', compact('resena'));
    }

    public function update(ResenaRequest $request, Resena $resena)
    {
        $this->authorize('update', $resena);

        $datos = Arr::except($request->validated(), ['imagen']);

        if ($request->hasFile('imagen')) {
            $this->imagenes->eliminar($resena->imagen_portada);
            $datos['imagen_portada'] = $this->imagenes->guardar($request->file('imagen'), 'resenas');
        }

        $resena->update($datos);

        $accion = ($resena->wasChanged('estado') && $resena->estaPublicado()) ? 'publicado' : 'actualizado';
        ContenidoModificado::dispatch($resena, $accion, $request->user());

        return redirect()->route('admin.resenas.index')
            ->with('exito', __('ttr.flash.actualizado', ['tipo' => __('ttr.tipos.resena')]));
    }

    /** Conmutador Borrador ⇄ Publicado (RF-10). */
    public function cambiarEstado(Request $request, Resena $resena)
    {
        $this->authorize('update', $resena);

        $resena->update(['estado' => $resena->estaPublicado() ? 'borrador' : 'publicado']);

        ContenidoModificado::dispatch($resena, $resena->estaPublicado() ? 'publicado' : 'despublicado', $request->user());

        return back()->with('exito', __('ttr.flash.estado_cambiado', ['estado' => __('ttr.estado.'.$resena->estado)]));
    }

    public function destroy(Request $request, Resena $resena)
    {
        $this->authorize('delete', $resena);

        $this->imagenes->eliminar($resena->imagen_portada);
        ContenidoModificado::dispatch($resena, 'eliminado', $request->user());
        $resena->delete();

        return redirect()->route('admin.resenas.index')
            ->with('exito', __('ttr.flash.eliminado', ['tipo' => __('ttr.tipos.resena')]));
    }
}
