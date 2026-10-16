@extends('layouts.app')

@section('titulo', $trailer->titulo)

@section('content')
    <div class="contenedor contenedor--lectura pagina">
        @include('partials.migas', ['items' => [['Tráilers', route('trailers.index')], [\Illuminate\Support\Str::limit($trailer->titulo, 40), null]]])

        <header class="articulo__cab">
            <p class="tarjeta__meta">
                <x-plataforma :nombre="$trailer->plataforma" />
                @unless ($trailer->estaPublicado())<x-estado valor="borrador" />@endunless
            </p>
            <h1>{{ $trailer->titulo }}</h1>
            <p class="articulo__firma">{{ $trailer->videojuego }} · publicado el {{ $trailer->created_at->translatedFormat('j \d\e F, Y') }}</p>
        </header>

        @if ($trailer->iframe_url)
            <div class="video-marco">
                <iframe src="{{ $trailer->iframe_url }}" title="{{ $trailer->titulo }}" loading="lazy"
                        allow="accelerometer; encrypted-media; gyroscope; picture-in-picture; fullscreen"
                        referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
            </div>
        @else
            <p class="vacio">El enlace de este video no es válido.</p>
        @endif

        @if ($trailer->descripcion)
            <div class="prosa"><p>{{ $trailer->descripcion }}</p></div>
        @endif
    </div>

    @if ($otros->isNotEmpty())
        <section class="contenedor seccion">
            <div class="seccion__cab"><h2>Más tráilers</h2><a href="{{ route('trailers.index') }}">Ver todos</a></div>
            <div class="rejilla rejilla--3">
                @foreach ($otros as $t)
                    <x-tarjeta-trailer :trailer="$t" />
                @endforeach
            </div>
        </section>
    @endif
@endsection
