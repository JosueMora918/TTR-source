@extends('layouts.app')

@section('titulo', $buscando ? 'Resultados para «'.$q.'»' : 'Buscar')

@section('content')
    <div class="contenedor pagina">
        @include('partials.migas', ['items' => [['Búsqueda', null]]])
        <header class="pagina__cab">
            <h1>{{ $buscando ? 'Resultados para «'.$q.'»' : 'Buscar en TTR' }}</h1>
            @if ($buscando)<p class="lede">{{ $total }} {{ $total === 1 ? 'resultado' : 'resultados' }}{{ $plataforma ? ' en '.$plataforma : '' }}.</p>@endif
        </header>

        @include('partials.filtros', ['ruta' => route('busqueda'), 'q' => $q, 'plataforma' => $plataforma, 'placeholder' => 'Busca juegos, noticias o tráilers'])

        @if (! $buscando)
            <p class="vacio">Escribe al menos 2 letras para buscar en noticias, tráilers y reseñas.</p>
        @elseif ($total === 0)
            <p class="vacio">No encontramos nada para «{{ $q }}». Revisa la ortografía o prueba con menos palabras.</p>
        @else
            @if ($resultados['resenas']->isNotEmpty())
                <section class="seccion seccion--primera">
                    <div class="seccion__cab"><h2>Reseñas</h2></div>
                    <div class="rejilla rejilla--3">@foreach ($resultados['resenas'] as $r)<x-tarjeta-resena :resena="$r" />@endforeach</div>
                </section>
            @endif
            @if ($resultados['trailers']->isNotEmpty())
                <section class="seccion">
                    <div class="seccion__cab"><h2>Tráilers</h2></div>
                    <div class="rejilla rejilla--3">@foreach ($resultados['trailers'] as $t)<x-tarjeta-trailer :trailer="$t" />@endforeach</div>
                </section>
            @endif
            @if ($resultados['noticias']->isNotEmpty())
                <section class="seccion">
                    <div class="seccion__cab"><h2>Noticias</h2></div>
                    <div class="rejilla rejilla--3">@foreach ($resultados['noticias'] as $n)<x-tarjeta-noticia :noticia="$n" />@endforeach</div>
                </section>
            @endif
        @endif
    </div>
@endsection
