@extends('layouts.app')

@section('titulo', 'Reseñas')

@section('content')
    <div class="contenedor pagina">
        @include('partials.migas', ['items' => [['Reseñas', null]]])
        <header class="pagina__cab">
            <h1>Reseñas</h1>
            <p class="lede">Ficha técnica, pros, contras y una nota con un decimal. Misma vara para todos los juegos.</p>
        </header>

        @include('partials.filtros', [
            'ruta' => route('resenas.index'), 'q' => $q, 'plataforma' => $plataforma,
            'placeholder' => 'Juego o desarrollador',
            'extras' => [[
                'name' => 'orden', 'label' => 'Ordenar por', 'valor' => $orden === 'nota' ? 'nota' : '',
                'opciones' => ['' => 'Más recientes', 'nota' => 'Mejor nota'],
            ]],
        ])

        @forelse ($resenas as $resena)
            @if ($loop->first)<div class="rejilla rejilla--3">@endif
            <x-tarjeta-resena :resena="$resena" />
            @if ($loop->last)</div>@endif
        @empty
            <p class="vacio">No encontramos reseñas con esos filtros.</p>
        @endforelse

        {{ $resenas->links() }}
    </div>
@endsection
