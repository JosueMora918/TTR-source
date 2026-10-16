<?php

namespace App\Http\Controllers;

use App\Http\Requests\SugerenciaRequest;
use App\Models\Sugerencia;
use Illuminate\Support\Facades\Log;

class SugerenciaController extends Controller
{
    /** Formulario público: el lector sugiere un videojuego para reseñar. */
    public function create()
    {
        return view('sugerencias.create');
    }

    /**
     * Valida (SugerenciaRequest), guarda en BD, registra en el log y
     * redirige con mensaje flash en sesión.
     */
    public function store(SugerenciaRequest $request)
    {
        $sugerencia = Sugerencia::create($request->validated());

        Log::info('Nueva sugerencia de reseña recibida.', [
            'id' => $sugerencia->id,
            'juego' => $sugerencia->titulo_juego,
            'plataforma' => $sugerencia->plataforma,
            'ip' => $request->ip(),
        ]);

        return redirect()
            ->route('sugerencias.create')
            ->with('exito', __('ttr.flash.sugerencia_enviada', ['juego' => $sugerencia->titulo_juego]));
    }
}
