@extends('layouts.app')

@section('titulo', 'Plataformas')

@section('content')
    <div class="contenedor pagina">
        @include('partials.migas', ['items' => [['Plataformas', null]]])
        <header class="pagina__cab">
            <h1>Plataformas</h1>
            <p class="lede">Elige dónde juegas y te mostramos todo lo publicado para esa plataforma.</p>
        </header>

        <div class="rejilla rejilla--4">
            @foreach ($conteos as $nombre => $total)
                <a class="plat-bloque {{ \App\Support\Ttr::claseDePlataforma($nombre) }}" href="{{ route('plataformas.show', strtolower($nombre)) }}">
                    <span class="plat-bloque__nombre">{{ $nombre }}</span>
                    <span class="plat-bloque__total">{{ $total }} {{ $total === 1 ? 'contenido' : 'contenidos' }}</span>
                </a>
            @endforeach
        </div>
    </div>
@endsection
