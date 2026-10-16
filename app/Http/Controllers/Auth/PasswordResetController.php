<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules\Password as ReglaPassword;

/**
 * Recuperación de contraseña (RS / Act. 7). El enlace se envía con el servicio
 * Mail + Notifications de Laravel; con MAIL_MAILER=log queda en storage/logs/laravel.log.
 */
class PasswordResetController extends Controller
{
    public function solicitar()
    {
        return view('auth.forgot');
    }

    public function enviar(Request $request)
    {
        $request->validate(['email' => ['required', 'email']]);

        Password::sendResetLink($request->only('email'));

        Log::info('Solicitud de recuperación de contraseña.', [
            'email' => $request->input('email'),
            'ip' => $request->ip(),
        ]);

        // Mensaje neutro: no revela si el correo existe (evita enumeración de usuarios).
        return back()->with('exito', __('ttr.auth.enlace_enviado'));
    }

    public function formulario(Request $request, string $token)
    {
        return view('auth.reset', ['token' => $token, 'email' => $request->query('email')]);
    }

    public function restablecer(Request $request)
    {
        $datos = $request->validate([
            'token' => ['required'],
            'email' => ['required', 'email'],
            'password' => ['required', 'confirmed', ReglaPassword::min(8)->letters()->numbers()],
        ]);

        $estado = Password::reset($datos, function ($usuario, $password) {
            $usuario->forceFill([
                'password' => $password, // se cifra con Bcrypt por el cast 'hashed'
                'remember_token' => Str::random(60),
            ])->save();

            event(new PasswordReset($usuario));
            Log::info('Contraseña restablecida.', ['user_id' => $usuario->id]);
        });

        if ($estado === Password::PASSWORD_RESET) {
            return redirect()->route('login')->with('exito', __('ttr.auth.password_restablecida'));
        }

        return back()->withErrors(['email' => __($estado)])->onlyInput('email');
    }
}
