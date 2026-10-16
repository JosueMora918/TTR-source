<?php

namespace App\Events;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

/**
 * Se dispara cuando el equipo editorial crea, actualiza, publica o elimina contenido.
 * $accion: creado | actualizado | publicado | despublicado | eliminado
 */
class ContenidoModificado
{
    use Dispatchable, SerializesModels;

    public function __construct(
        public Model $contenido,
        public string $accion,
        public ?User $usuario = null,
    ) {
    }
}
