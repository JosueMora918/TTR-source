<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

/**
 * Middleware de autorización por rol (Act. 5 y 7).
 *
 * Uso en rutas:  ->middleware('rol:admin')  o  ->middleware('rol:admin,editor')
 * Regla real del sistema: solo los roles indicados entran a la ruta; el
 * intento no autorizado se registra en laravel.log con IP (RNF-08).
 */
class VerificarRol
{
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        $usuario = $request->user();

        if (! $usuario) {
            return redirect()->route('login');
        }

        if (! in_array($usuario->rol, $roles, true)) {
            Log::warning('Acceso denegado por rol insuficiente.', [
                'user_id' => $usuario->id,
                'rol' => $usuario->rol,
                'roles_requeridos' => $roles,
                'ruta' => $request->path(),
                'ip' => $request->ip(),
            ]);

            abort(403, __('ttr.errores.sin_permiso'));
        }

        return $next($request);
    }
}
