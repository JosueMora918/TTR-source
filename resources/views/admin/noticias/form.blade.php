@extends('layouts.admin')

@php($editando = $noticia->exists)
@section('titulo', ($editando ? 'Editar noticia' : 'Nueva noticia').' · Panel')

@section('admin')
    <header class="pagina__cab pagina__cab--panel">
        <h1>{{ $editando ? 'Editar noticia' : 'Nueva noticia' }}</h1>
    </header>

    <form method="POST" enctype="multipart/form-data" class="formulario" novalidate
          action="{{ $editando ? route('admin.noticias.update', $noticia) : route('admin.noticias.store') }}">
        @csrf
        @if ($editando) @method('PUT') @endif

        <x-campo nombre="titulo" etiqueta="Título" :valor="$noticia->titulo" maxlength="200" :requerido="true" />
        <x-campo nombre="resumen" etiqueta="Resumen (opcional)" tipo="textarea" :valor="$noticia->resumen" rows="2" maxlength="300" ayuda="Aparece en las tarjetas. Si lo dejas vacío se genera del contenido." />
        <x-campo nombre="contenido" etiqueta="Contenido" tipo="textarea" :valor="$noticia->contenido" rows="12" ayuda="Separa los párrafos con una línea en blanco. Mínimo 50 caracteres." :requerido="true" />

        <div class="form-grid form-grid--3">
            <x-campo nombre="categoria" etiqueta="Categoría" tipo="select" :opciones="\App\Support\Ttr::CATEGORIAS" :valor="$noticia->categoria" vacio="Selecciona una" :requerido="true" />
            <x-campo nombre="plataforma" etiqueta="Plataforma" tipo="select" :opciones="\App\Support\Ttr::PLATAFORMAS" :valor="$noticia->plataforma" vacio="Sin plataforma específica" />
            <x-campo nombre="estado" etiqueta="Estado" tipo="select" :opciones="['borrador' => 'Borrador', 'publicado' => 'Publicado']" :valor="$noticia->estado" :requerido="true" ayuda="Los borradores no son visibles para el público." />
        </div>

        <x-campo nombre="imagen" etiqueta="Imagen de portada (opcional)" tipo="file" accept="image/jpeg,image/png,image/webp" ayuda="JPG, PNG o WebP de hasta 5 MB. Se optimiza automáticamente." />
        @if ($editando && $noticia->imagen_url)
            <p class="formulario__nota">Imagen actual: <a href="{{ $noticia->imagen_url }}" target="_blank" rel="noopener">ver portada</a>. Sube otra para reemplazarla.</p>
        @endif

        <div class="formulario__acciones">
            <button type="submit" class="btn">{{ $editando ? 'Guardar cambios' : 'Crear noticia' }}</button>
            <a class="btn btn--sec" href="{{ route('admin.noticias.index') }}">Cancelar</a>
        </div>
    </form>
@endsection
