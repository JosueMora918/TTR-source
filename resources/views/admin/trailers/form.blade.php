@extends('layouts.admin')

@php($editando = $trailer->exists)
@section('titulo', ($editando ? 'Editar tráiler' : 'Nuevo tráiler').' · Panel')

@section('admin')
    <header class="pagina__cab pagina__cab--panel">
        <h1>{{ $editando ? 'Editar tráiler' : 'Nuevo tráiler' }}</h1>
    </header>

    <form method="POST" class="formulario" novalidate
          action="{{ $editando ? route('admin.trailers.update', $trailer) : route('admin.trailers.store') }}">
        @csrf
        @if ($editando) @method('PUT') @endif

        <x-campo nombre="titulo" etiqueta="Título" :valor="$trailer->titulo" maxlength="200" :requerido="true" />

        <div class="form-grid">
            <x-campo nombre="videojuego" etiqueta="Videojuego" :valor="$trailer->videojuego" maxlength="150" :requerido="true" />
            <x-campo nombre="plataforma" etiqueta="Plataforma" tipo="select" :opciones="\App\Models\Trailer::PLATAFORMAS" :valor="$trailer->plataforma" vacio="Selecciona una" :requerido="true" />
        </div>

        <x-campo nombre="url_embebida" etiqueta="Enlace del video" tipo="url" :valor="$trailer->url_embebida" maxlength="255" placeholder="https://www.youtube.com/watch?v=…" ayuda="Pega el enlace de YouTube o Vimeo. TTR no aloja video propio." :requerido="true" />
        <x-campo nombre="descripcion" etiqueta="Descripción (opcional)" tipo="textarea" :valor="$trailer->descripcion" rows="3" maxlength="1000" />
        <x-campo nombre="estado" etiqueta="Estado" tipo="select" :opciones="['borrador' => 'Borrador', 'publicado' => 'Publicado']" :valor="$trailer->estado" :requerido="true" />

        <div class="formulario__acciones">
            <button type="submit" class="btn">{{ $editando ? 'Guardar cambios' : 'Crear tráiler' }}</button>
            <a class="btn btn--sec" href="{{ route('admin.trailers.index') }}">Cancelar</a>
        </div>
    </form>
@endsection
