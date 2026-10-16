@extends('layouts.admin')

@php($editando = $resena->exists)
@section('titulo', ($editando ? 'Editar reseña' : 'Nueva reseña').' · Panel')

@section('admin')
    <header class="pagina__cab pagina__cab--panel">
        <h1>{{ $editando ? 'Editar reseña' : 'Nueva reseña' }}</h1>
    </header>

    <form method="POST" enctype="multipart/form-data" class="formulario" novalidate
          action="{{ $editando ? route('admin.resenas.update', $resena) : route('admin.resenas.store') }}">
        @csrf
        @if ($editando) @method('PUT') @endif

        <x-campo nombre="titulo" etiqueta="Título de la reseña" :valor="$resena->titulo" maxlength="200" placeholder="Análisis de …" :requerido="true" />

        <div class="form-grid form-grid--3">
            <x-campo nombre="videojuego" etiqueta="Videojuego" :valor="$resena->videojuego" maxlength="150" :requerido="true" />
            <x-campo nombre="desarrollador" etiqueta="Desarrollador" :valor="$resena->desarrollador" maxlength="120" :requerido="true" />
            <x-campo nombre="genero" etiqueta="Género" :valor="$resena->genero" maxlength="80" :requerido="true" />
            <x-campo nombre="plataforma" etiqueta="Plataforma" tipo="select" :opciones="\App\Support\Ttr::PLATAFORMAS" :valor="$resena->plataforma" vacio="Selecciona una" :requerido="true" />
            <x-campo nombre="puntuacion" etiqueta="Calificación (1.0 a 10.0)" tipo="number" :valor="$resena->puntuacion" step="0.1" min="1" max="10" inputmode="decimal" ayuda="Un solo decimal, por ejemplo 8.5." :requerido="true" />
            <x-campo nombre="estado" etiqueta="Estado" tipo="select" :opciones="['borrador' => 'Borrador', 'publicado' => 'Publicado']" :valor="$resena->estado" :requerido="true" />
        </div>

        <div class="form-grid">
            <x-campo nombre="pros" etiqueta="Lo mejor (pros)" tipo="textarea" :valor="$resena->pros" rows="5" ayuda="Un punto por línea." :requerido="true" />
            <x-campo nombre="contras" etiqueta="Lo que falla (contras)" tipo="textarea" :valor="$resena->contras" rows="5" ayuda="Un punto por línea." :requerido="true" />
        </div>

        <x-campo nombre="veredicto" etiqueta="Veredicto" tipo="textarea" :valor="$resena->veredicto" rows="8" ayuda="Mínimo 20 caracteres. Separa párrafos con una línea en blanco." :requerido="true" />

        <x-campo nombre="imagen" etiqueta="Imagen de portada (opcional)" tipo="file" accept="image/jpeg,image/png,image/webp" ayuda="JPG, PNG o WebP de hasta 5 MB. Se optimiza automáticamente." />
        @if ($editando && $resena->imagen_url)
            <p class="formulario__nota">Imagen actual: <a href="{{ $resena->imagen_url }}" target="_blank" rel="noopener">ver portada</a>. Sube otra para reemplazarla.</p>
        @endif

        <div class="formulario__acciones">
            <button type="submit" class="btn">{{ $editando ? 'Guardar cambios' : 'Crear reseña' }}</button>
            <a class="btn btn--sec" href="{{ route('admin.resenas.index') }}">Cancelar</a>
        </div>
    </form>
@endsection
