@extends('layouts.app')

@section('titulo', 'Recuperar contraseña')

@section('content')
    <div class="contenedor contenedor--estrecho pagina">
        @include('partials.migas', ['items' => [['Acceso', route('login')], ['Recuperar contraseña', null]]])
        <header class="pagina__cab">
            <h1>Recuperar contraseña</h1>
            <p class="lede">Escribe tu correo y te enviaremos un enlace para crear una contraseña nueva.</p>
        </header>

        <form method="POST" action="{{ route('password.email') }}" class="formulario" novalidate>
            @csrf
            <x-campo nombre="email" etiqueta="Correo electrónico" tipo="email" autocomplete="email" :requerido="true" autofocus />
            <button type="submit" class="btn">Enviar enlace</button>
        </form>
    </div>
@endsection
