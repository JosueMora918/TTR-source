@extends('layouts.app')

@section('titulo', 'Noticias')

@section('content')
    <div class="contenedor pagina">
        @include('partials.migas', ['items' => [['Noticias', null]]])
        <header class="pagina__cab">
            <h1>Noticias</h1>
            <p class="lede">Lanzamientos, industria y hardware, sin relleno.</p>
        </header>

        @include('partials.filtros', [
            'ruta' => route('noticias.index'), 'q' => $q, 'plataforma' => $plataforma,
            'extras' => [[
                'name' => 'categoria', 'label' => 'Categoría', 'valor' => $categoria,
                'opciones' => ['' => 'Todas'] + array_combine(\App\Support\Ttr::CATEGORIAS, \App\Support\Ttr::CATEGORIAS),
            ]],
        ])

        @forelse ($noticias as $noticia)
            @if ($loop->first)<div class="rejilla rejilla--3">@endif
            <x-tarjeta-noticia :noticia="$noticia" />
            @if ($loop->last)</div>@endif
        @empty
            <p class="vacio">No encontramos noticias con esos filtros. Prueba con otra búsqueda.</p>
        @endforelse

        {{ $noticias->links() }}
    </div>
@endsection
