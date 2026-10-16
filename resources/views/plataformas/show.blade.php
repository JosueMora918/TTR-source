@extends('layouts.app')

@section('titulo', $plataforma)

@section('content')
    <div class="contenedor pagina">
        @include('partials.migas', ['items' => [['Plataformas', route('plataformas.show')], [$plataforma, null]]])
        <header class="pagina__cab">
            <h1>Todo para {{ $plataforma }}</h1>
        </header>

        <section class="seccion seccion--primera">
            <div class="seccion__cab"><h2>Reseñas</h2><a href="{{ route('resenas.index', ['plataforma' => $plataforma]) }}">Ver todas</a></div>
            @if ($resenas->isNotEmpty())
                <div class="rejilla rejilla--3">@foreach ($resenas as $r)<x-tarjeta-resena :resena="$r" />@endforeach</div>
            @else
                <p class="vacio">Aún no hay reseñas para {{ $plataforma }}.</p>
            @endif
        </section>

        <section class="seccion">
            <div class="seccion__cab"><h2>Tráilers</h2><a href="{{ route('trailers.index', ['plataforma' => $plataforma]) }}">Ver todos</a></div>
            @if ($trailers->isNotEmpty())
                <div class="rejilla rejilla--3">@foreach ($trailers as $t)<x-tarjeta-trailer :trailer="$t" />@endforeach</div>
            @else
                <p class="vacio">Aún no hay tráilers para {{ $plataforma }}.</p>
            @endif
        </section>

        <section class="seccion">
            <div class="seccion__cab"><h2>Noticias</h2><a href="{{ route('noticias.index', ['plataforma' => $plataforma]) }}">Ver todas</a></div>
            @if ($noticias->isNotEmpty())
                <div class="rejilla rejilla--3">@foreach ($noticias as $n)<x-tarjeta-noticia :noticia="$n" />@endforeach</div>
            @else
                <p class="vacio">Aún no hay noticias para {{ $plataforma }}.</p>
            @endif
        </section>
    </div>
@endsection
