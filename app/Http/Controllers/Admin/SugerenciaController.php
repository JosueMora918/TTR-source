<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Sugerencia;
use Illuminate\Http\Request;

class SugerenciaController extends Controller
{
    public function index(Request $request)
    {
        $estado = in_array($request->query('estado'), ['pendiente', 'revisada'], true) ? $request->query('estado') : null;

        $sugerencias = Sugerencia::query()
            ->when($estado, fn ($q) => $q->where('estado', $estado))
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('admin.sugerencias.index', compact('sugerencias', 'estado'));
    }

    public function revisar(Sugerencia $sugerencia)
    {
        $sugerencia->update(['estado' => 'revisada']);

        return back()->with('exito', __('ttr.flash.sugerencia_revisada'));
    }

    public function destroy(Sugerencia $sugerencia)
    {
        $sugerencia->delete();

        return back()->with('exito', __('ttr.flash.eliminado', ['tipo' => __('ttr.tipos.sugerencia')]));
    }
}
