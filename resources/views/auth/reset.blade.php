@extends('layouts.app')

@section('titulo', 'Crear contraseña nueva')

@section('content')
    <div class="contenedor contenedor--estrecho pagina">
        <header class="pagina__cab">
            <h1>Crear contraseña nueva</h1>
        </header>

        <form method="POST" action="{{ route('password.update') }}" class="formulario" novalidate>
            @csrf
            <input type="hidden" name="token" value="{{ $token }}">
            <x-campo nombre="email" etiqueta="Correo electrónico" tipo="email" :valor="$email" autocomplete="username" :requerido="true" />
            <x-campo nombre="password" etiqueta="Contraseña nueva" tipo="password" autocomplete="new-password" ayuda="Mínimo 8 caracteres, con letras y números." :requerido="true" />
            <x-campo nombre="password_confirmation" etiqueta="Repite la contraseña" tipo="password" autocomplete="new-password" :requerido="true" />
            <button type="submit" class="btn">Guardar contraseña</button>
        </form>
    </div>
@endsection
