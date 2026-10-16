@extends('layouts.app')
@section('titulo', 'Página no encontrada')
@section('content')
    <div class="contenedor contenedor--estrecho pagina error-pagina">
        <p class="error-pagina__codigo">404</p>
        <h1>No encontramos esa página</h1>
        <p class="lede">Es posible que el enlace haya cambiado o que el contenido todavía no esté publicado.</p>
        <div class="hero__acciones">
            <a class="btn" href="{{ route('home') }}">Ir al inicio</a>
            <a class="btn btn--sec" href="{{ route('busqueda') }}">Buscar en TTR</a>
        </div>
    </div>
@endsection
