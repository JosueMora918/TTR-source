<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

/**
 * Regla: el administrador gestiona todo el contenido; el editor
 * solo puede modificar, publicar o eliminar el contenido que él creó.
 */
class ContenidoPolicy
{
    public function update(User $usuario, Model $contenido): bool
    {
        return $usuario->esAdmin() || $contenido->user_id === $usuario->id;
    }

    public function delete(User $usuario, Model $contenido): bool
    {
        return $this->update($usuario, $contenido);
    }
}
