@extends('layouts.app')

@section('titulo', 'Sugerir un videojuego')

@section('content')
    <div class="contenedor contenedor--formulario pagina">
        @include('partials.migas', ['items' => [['Sugerir reseña', null]]])
        <header class="pagina__cab">
            <h1>Sugiere un videojuego para reseñar</h1>
            <p class="lede">Si hay un título que quieres ver analizado en TTR, cuéntanoslo. Lo revisa el equipo editorial.</p>
        </header>

        <form method="POST" action="{{ route('sugerencias.store') }}" class="formulario" novalidate>
            {{-- Protección CSRF obligatoria en todo formulario POST --}}
            @csrf

            <div class="form-grid">
                <x-campo nombre="nombre" etiqueta="Tu nombre" autocomplete="name" maxlength="80" :requerido="true" />
                <x-campo nombre="email" etiqueta="Correo electrónico" tipo="email" autocomplete="email" maxlength="150" :requerido="true" />
                <x-campo nombre="titulo_juego" etiqueta="Título del videojuego" maxlength="120" :requerido="true" />
                <x-campo nombre="plataforma" etiqueta="Plataforma" tipo="select" :opciones="\App\Support\Ttr::PLATAFORMAS" vacio="Selecciona una opción" :requerido="true" />
            </div>
            <x-campo nombre="comentario" etiqueta="¿Por qué te interesa? (opcional)" tipo="textarea" maxlength="500" ayuda="Máximo 500 caracteres." />

            <button type="submit" class="btn">Enviar sugerencia</button>
        </form>
    </div>
@endsection
