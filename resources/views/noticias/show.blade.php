@extends('layouts.app')

@section('titulo', $noticia->titulo)
@section('descripcion', $noticia->extracto)

@section('content')
    <article class="contenedor contenedor--lectura pagina">
        @include('partials.migas', ['items' => [['Noticias', route('noticias.index')], [\Illuminate\Support\Str::limit($noticia->titulo, 40), null]]])

        <header class="articulo__cab">
            <p class="tarjeta__meta">
                <span class="categoria">{{ $noticia->categoria }}</span>
                @if ($noticia->plataforma)<x-plataforma :nombre="$noticia->plataforma" />@endif
                @unless ($noticia->estaPublicado())<x-estado valor="borrador" />@endunless
            </p>
            <h1>{{ $noticia->titulo }}</h1>
            <p class="articulo__firma">
                Por {{ $noticia->autor->name }} ·
                <time datetime="{{ $noticia->created_at->toDateString() }}">{{ $noticia->created_at->translatedFormat('j \d\e F, Y') }}</time>
            </p>
        </header>

        @if ($noticia->imagen_url)
            <x-portada :imagen="$noticia->imagen_url" :titulo="$noticia->titulo" :plataforma="$noticia->plataforma" class="articulo__portada" />
        @endif

        <div class="prosa">
            @foreach ($noticia->parrafos as $parrafo)
                <p>{!! nl2br(e($parrafo)) !!}</p>
            @endforeach
        </div>
    </article>

    @if ($relacionadas->isNotEmpty())
        <section class="contenedor seccion">
            <div class="seccion__cab"><h2>Más de {{ $noticia->categoria }}</h2></div>
            <div class="rejilla rejilla--3">
                @foreach ($relacionadas as $n)
                    <x-tarjeta-noticia :noticia="$n" />
                @endforeach
            </div>
        </section>
    @endif
@endsection
