<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

/**
 * Gestión de cuentas del equipo editorial. Solo rol admin (middleware rol:admin).
 * Es también el "registro de usuarios" del proyecto: los lectores no tienen cuenta.
 */
class UsuarioController extends Controller
{
    public function index()
    {
        $usuarios = User::withCount(['noticias', 'trailers', 'resenas'])->orderBy('name')->paginate(10);

        return view('admin.usuarios.index', compact('usuarios'));
    }

    public function create()
    {
        return view('admin.usuarios.form', ['usuario' => new User(['rol' => 'editor'])]);
    }

    public function store(Request $request)
    {
        $datos = $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'email' => ['required', 'email', 'max:150', 'unique:users,email'],
            'rol' => ['required', Rule::in(User::ROLES)],
            'password' => ['required', 'confirmed', Password::min(8)->letters()->numbers()],
        ]);

        $usuario = User::create($datos);

        Log::info('Cuenta creada por un administrador.', [
            'nuevo_user_id' => $usuario->id,
            'rol' => $usuario->rol,
            'admin_id' => $request->user()->id,
            'ip' => $request->ip(),
        ]);

        return redirect()->route('admin.usuarios.index')
            ->with('exito', __('ttr.flash.creado', ['tipo' => __('ttr.tipos.usuario')]));
    }

    public function edit(User $usuario)
    {
        return view('admin.usuarios.form', compact('usuario'));
    }

    public function update(Request $request, User $usuario)
    {
        $datos = $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'email' => ['required', 'email', 'max:150', Rule::unique('users', 'email')->ignore($usuario->id)],
            'rol' => ['required', Rule::in(User::ROLES)],
            'password' => ['nullable', 'confirmed', Password::min(8)->letters()->numbers()],
        ]);

        // Un administrador no puede quitarse a sí mismo el rol (evita quedarse sin admin).
        if ($usuario->id === $request->user()->id && $datos['rol'] !== 'admin') {
            return back()->withInput()->with('error', __('ttr.errores.auto_degradar'));
        }

        if (empty($datos['password'])) {
            unset($datos['password']);
        }

        $usuario->update($datos);

        Log::info('Cuenta actualizada por un administrador.', [
            'user_id' => $usuario->id,
            'rol' => $usuario->rol,
            'admin_id' => $request->user()->id,
        ]);

        return redirect()->route('admin.usuarios.index')
            ->with('exito', __('ttr.flash.actualizado', ['tipo' => __('ttr.tipos.usuario')]));
    }

    public function destroy(Request $request, User $usuario)
    {
        if ($usuario->id === $request->user()->id) {
            return back()->with('error', __('ttr.errores.auto_eliminar'));
        }

        // Integridad referencial: no se elimina quien tenga contenido publicado o en borrador.
        if ($usuario->tieneContenido()) {
            return back()->with('error', __('ttr.errores.usuario_con_contenido', ['nombre' => $usuario->name]));
        }

        $usuario->delete();

        Log::warning('Cuenta eliminada.', ['user_id' => $usuario->id, 'admin_id' => $request->user()->id]);

        return redirect()->route('admin.usuarios.index')
            ->with('exito', __('ttr.flash.eliminado', ['tipo' => __('ttr.tipos.usuario')]));
    }
}
