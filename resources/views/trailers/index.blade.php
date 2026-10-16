@extends('layouts.app')

@section('titulo', 'Tráilers y teasers')

@section('content')
    <div class="contenedor pagina">
        @include('partials.migas', ['items' => [['Tráilers', null]]])
        <header class="pagina__cab">
            <h1>Tráilers y teasers</h1>
            <p class="lede">Los videos se reproducen desde YouTube o Vimeo al pulsar play; TTR no aloja video propio.</p>
        </header>

        @include('partials.filtros', [
            'ruta' => route('trailers.index'), 'q' => $q, 'plataforma' => $plataforma,
            'plataformas' => \App\Models\Trailer::PLATAFORMAS, 'placeholder' => 'Título o videojuego',
        ])

        @forelse ($trailers as $trailer)
            @if ($loop->first)<div class="rejilla rejilla--3">@endif
            <x-tarjeta-trailer :trailer="$trailer" />
            @if ($loop->last)</div>@endif
        @empty
            <p class="vacio">No encontramos tráilers con esos filtros.</p>
        @endforelse

        {{ $trailers->links() }}
    </div>
@endsection
