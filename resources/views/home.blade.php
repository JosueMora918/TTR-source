@extends('layouts.app')

@section('titulo', 'Noticias, tráilers y reseñas de videojuegos')

@section('content')
    <section class="contenedor hero">
        <div class="hero__texto">
            <h1>Reseñas con nota, tráilers sin ruido y noticias sin banners.</h1>
            <p class="lede">TTR reúne lo esencial de los videojuegos en un sitio rápido. Cada reseña trae ficha técnica, pros, contras y una calificación del 1.0 al 10.0.</p>
            <div class="hero__acciones">
                <a class="btn" href="{{ route('resenas.index') }}">Ver reseñas</a>
                <a class="btn btn--sec" href="{{ route('trailers.index') }}">Ver tráilers</a>
            </div>
        </div>

        @if ($destacada)
            <a class="hero__resena {{ \App\Support\Ttr::claseDePlataforma($destacada->plataforma) }}" href="{{ route('resenas.show', $destacada->slug) }}">
                <span class="hero__resena-fondo" aria-hidden="true">{{ mb_strtoupper(mb_substr($destacada->videojuego, 0, 1)) }}</span>
                <span class="hero__resena-cuerpo">
                    <x-nota :valor="$destacada->puntuacion" :grande="true" />
                    <span class="hero__resena-datos">
                        <x-plataforma :nombre="$destacada->plataforma" />
                        <strong class="hero__resena-titulo">{{ $destacada->videojuego }}</strong>
                        <span class="hero__resena-texto">{{ \Illuminate\Support\Str::limit(strip_tags($destacada->veredicto), 120) }}</span>
                        <span class="hero__resena-leer">Leer la reseña completa</span>
                    </span>
                </span>
            </a>
        @endif
    </section>

    <section class="contenedor plataformas-tira" aria-label="Explorar por plataforma">
        @foreach (\App\Support\Ttr::PLATAFORMAS as $p)
            <a class="chip {{ \App\Support\Ttr::claseDePlataforma($p) }}" href="{{ route('plataformas.show', strtolower($p)) }}">{{ $p }}</a>
        @endforeach
    </section>

    @if ($resenas->isNotEmpty() || $destacada)
        <section class="contenedor seccion">
            <div class="seccion__cab">
                <h2>Reseñas recientes</h2>
                <a href="{{ route('resenas.index') }}">Ver todas</a>
            </div>
            <div class="rejilla rejilla--3">
                @foreach ($resenas as $resena)
                    <x-tarjeta-resena :resena="$resena" />
                @endforeach
            </div>
        </section>
    @endif

    <section class="contenedor seccion">
        <div class="seccion__cab">
            <h2>Noticias</h2>
            <a href="{{ route('noticias.index') }}">Ver todas</a>
        </div>
        @if ($noticiaPrincipal)
            <div class="noticias-bloque">
                <x-tarjeta-noticia :noticia="$noticiaPrincipal" />
                <ul class="lista-compacta">
                    @foreach ($noticias as $n)
                        <li>
                            <span class="categoria">{{ $n->categoria }}</span>
                            <a href="{{ route('noticias.show', $n->slug) }}">{{ $n->titulo }}</a>
                            <time datetime="{{ $n->created_at->toDateString() }}">{{ $n->created_at->translatedFormat('j M') }}</time>
                        </li>
                    @endforeach
                </ul>
            </div>
        @else
            <p class="vacio">Todavía no hay noticias publicadas.</p>
        @endif
    </section>

    <section class="contenedor seccion">
        <div class="seccion__cab">
            <h2>Tráilers y teasers</h2>
            <a href="{{ route('trailers.index') }}">Ver todos</a>
        </div>
        @if ($trailers->isNotEmpty())
            <div class="rejilla rejilla--3">
                @foreach ($trailers as $trailer)
                    <x-tarjeta-trailer :trailer="$trailer" />
                @endforeach
            </div>
        @else
            <p class="vacio">Todavía no hay tráilers publicados.</p>
        @endif
    </section>

    <section class="contenedor seccion">
        <div class="llamada">
            <div>
                <h2>¿Qué juego quieres ver reseñado?</h2>
                <p>Cuéntanos qué título falta y lo revisamos para el calendario editorial.</p>
            </div>
            <a class="btn" href="{{ route('sugerencias.create') }}">Sugerir un videojuego</a>
        </div>
    </section>
@endsection
