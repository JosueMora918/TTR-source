<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class LoginController extends Controller
{
    public function create()
    {
        return view('auth.login');
    }

    public function store(Request $request)
    {
        $credenciales = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        if (Auth::attempt($credenciales, $request->boolean('recordar'))) {
            $request->session()->regenerate(); // evita fijación de sesión

            Log::info('Inicio de sesión correcto.', [
                'user_id' => Auth::id(),
                'ip' => $request->ip(),
            ]);

            return redirect()->intended(route('admin.dashboard'))
                ->with('exito', __('ttr.auth.bienvenida', ['nombre' => Auth::user()->name]));
        }

        Log::warning('Intento de inicio de sesión fallido.', [
            'email' => $request->input('email'),
            'ip' => $request->ip(),
        ]);

        return back()
            ->withErrors(['email' => __('auth.failed')])
            ->onlyInput('email');
    }

    public function destroy(Request $request)
    {
        Log::info('Cierre de sesión.', ['user_id' => Auth::id(), 'ip' => $request->ip()]);

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home')->with('exito', __('ttr.auth.despedida'));
    }
}
