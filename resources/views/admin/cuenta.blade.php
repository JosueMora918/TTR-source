@extends('layouts.admin')

@section('titulo', 'Mi cuenta · Panel')

@section('admin')
    <header class="pagina__cab pagina__cab--panel">
        <h1>Mi cuenta</h1>
        <p class="lede">{{ $usuario->name }} · {{ $usuario->email }} · rol <strong>{{ $usuario->rol }}</strong></p>
    </header>

    <form method="POST" action="{{ route('admin.cuenta.password') }}" class="formulario" novalidate>
        @csrf
        @method('PUT')
        <h2>Cambiar contraseña</h2>
        <x-campo nombre="password_actual" etiqueta="Contraseña actual" tipo="password" autocomplete="current-password" :requerido="true" />
        <div class="form-grid">
            <x-campo nombre="password" etiqueta="Contraseña nueva" tipo="password" autocomplete="new-password" ayuda="Mínimo 8 caracteres, con letras y números." :requerido="true" />
            <x-campo nombre="password_confirmation" etiqueta="Repite la contraseña nueva" tipo="password" autocomplete="new-password" :requerido="true" />
        </div>
        <div class="formulario__acciones"><button type="submit" class="btn">Actualizar contraseña</button></div>
    </form>
@endsection
