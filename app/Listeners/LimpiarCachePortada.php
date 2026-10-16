<?php

namespace App\Listeners;

use App\Events\ContenidoModificado;
use Illuminate\Support\Facades\Cache;

/** La portada se guarda en caché; cualquier cambio editorial la invalida. */
class LimpiarCachePortada
{
    public const CLAVE = 'portada.v1';

    public function handle(ContenidoModificado $evento): void
    {
        Cache::forget(self::CLAVE);
    }
}
