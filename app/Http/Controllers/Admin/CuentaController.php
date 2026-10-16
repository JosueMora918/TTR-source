<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rules\Password;

/** Cambio de contraseña del usuario autenticado (Act. 7). */
class CuentaController extends Controller
{
    public function edit(Request $request)
    {
        return view('admin.cuenta', ['usuario' => $request->user()]);
    }

    public function actualizarPassword(Request $request)
    {
        $datos = $request->validate([
            'password_actual' => ['required', 'current_password'],
            'password' => ['required', 'confirmed', 'different:password_actual', Password::min(8)->letters()->numbers()],
        ]);

        $request->user()->update(['password' => $datos['password']]); // Bcrypt vía cast

        Log::info('Contraseña cambiada por el usuario.', [
            'user_id' => $request->user()->id,
            'ip' => $request->ip(),
        ]);

        return back()->with('exito', __('ttr.auth.password_cambiada'));
    }
}
