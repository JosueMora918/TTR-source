<?php

namespace App\Http\Controllers\Admin;

use App\Events\ContenidoModificado;
use App\Http\Controllers\Controller;
use App\Http\Requests\TrailerRequest;
use App\Models\Trailer;
use App\Support\Ttr;
use Illuminate\Http\Request;

class TrailerController extends Controller
{
    public function index(Request $request)
    {
        $q = trim((string) $request->query('q'));
        $estado = in_array($request->query('estado'), Ttr::ESTADOS, true) ? $request->query('estado') : null;
        $plataforma = in_array($request->query('plataforma'), Trailer::PLATAFORMAS, true) ? $request->query('plataforma') : null;

        $trailers = Trailer::with('autor')
            ->buscar($q)
            ->conEstado($estado)
            ->dePlataforma($plataforma)
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('admin.trailers.index', compact('trailers', 'q', 'estado', 'plataforma'));
    }

    public function create()
    {
        return view('admin.trailers.form', ['trailer' => new Trailer(['estado' => 'borrador'])]);
    }

    public function store(TrailerRequest $request)
    {
        $trailer = Trailer::create($request->validated() + ['user_id' => $request->user()->id]);

        ContenidoModificado::dispatch($trailer, $trailer->estaPublicado() ? 'publicado' : 'creado', $request->user());

        return redirect()->route('admin.trailers.index')
            ->with('exito', __('ttr.flash.creado', ['tipo' => __('ttr.tipos.trailer')]));
    }

    public function edit(Trailer $trailer)
    {
        $this->authorize('update', $trailer);

        return view('admin.trailers.form', compact('trailer'));
    }

    public function update(TrailerRequest $request, Trailer $trailer)
    {
        $this->authorize('update', $trailer);

        $trailer->update($request->validated());

        $accion = ($trailer->wasChanged('estado') && $trailer->estaPublicado()) ? 'publicado' : 'actualizado';
        ContenidoModificado::dispatch($trailer, $accion, $request->user());

        return redirect()->route('admin.trailers.index')
            ->with('exito', __('ttr.flash.actualizado', ['tipo' => __('ttr.tipos.trailer')]));
    }

    public function cambiarEstado(Request $request, Trailer $trailer)
    {
        $this->authorize('update', $trailer);

        $trailer->update(['estado' => $trailer->estaPublicado() ? 'borrador' : 'publicado']);

        ContenidoModificado::dispatch($trailer, $trailer->estaPublicado() ? 'publicado' : 'despublicado', $request->user());

        return back()->with('exito', __('ttr.flash.estado_cambiado', ['estado' => __('ttr.estado.'.$trailer->estado)]));
    }

    public function destroy(Request $request, Trailer $trailer)
    {
        $this->authorize('delete', $trailer);

        ContenidoModificado::dispatch($trailer, 'eliminado', $request->user());
        $trailer->delete();

        return redirect()->route('admin.trailers.index')
            ->with('exito', __('ttr.flash.eliminado', ['tipo' => __('ttr.tipos.trailer')]));
    }
}
