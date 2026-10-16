@extends('layouts.app')

@section('titulo', 'Acceso para editores')

@section('content')
    <div class="contenedor contenedor--estrecho pagina">
        <header class="pagina__cab">
            <h1>Acceso para editores</h1>
            <p class="lede">Inicia sesión para administrar noticias, tráilers y reseñas.</p>
        </header>

        <form method="POST" action="{{ route('login.store') }}" class="formulario" novalidate>
            @csrf
            <x-campo nombre="email" etiqueta="Correo electrónico" tipo="email" autocomplete="username" :requerido="true" autofocus />
            <x-campo nombre="password" etiqueta="Contraseña" tipo="password" autocomplete="current-password" :requerido="true" />

            <label class="casilla">
                <input type="checkbox" name="recordar" value="1" @checked(old('recordar'))>
                <span>Mantener la sesión iniciada</span>
            </label>

            <button type="submit" class="btn">Iniciar sesión</button>
            <p class="formulario__pie"><a href="{{ route('password.request') }}">¿Olvidaste tu contraseña?</a></p>
        </form>
    </div>
@endsection
