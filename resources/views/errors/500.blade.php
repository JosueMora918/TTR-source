@extends('layouts.app')
@section('titulo', 'Error del servidor')
@section('content')
    <div class="contenedor contenedor--estrecho pagina error-pagina">
        <p class="error-pagina__codigo">500</p>
        <h1>Algo salió mal de nuestro lado</h1>
        <p class="lede">El error quedó registrado. Inténtalo de nuevo en unos minutos.</p>
        <div class="hero__acciones"><a class="btn" href="{{ route('home') }}">Ir al inicio</a></div>
    </div>
@endsection
