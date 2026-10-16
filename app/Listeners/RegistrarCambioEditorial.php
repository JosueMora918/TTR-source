<?php

namespace App\Listeners;

use App\Events\ContenidoModificado;
use Illuminate\Support\Facades\Log;

/** Bitácora de auditoría (RNF-08): quién, qué, cuándo y desde qué IP. */
class RegistrarCambioEditorial
{
    public function handle(ContenidoModificado $evento): void
    {
        Log::info('Cambio editorial: contenido '.$evento->accion.'.', [
            'tipo' => class_basename($evento->contenido),
            'id' => $evento->contenido->getKey(),
            'titulo' => $evento->contenido->titulo,
            'user_id' => $evento->usuario?->id,
            'ip' => request()->ip(),
        ]);
    }
}
