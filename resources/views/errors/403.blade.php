@extends('layouts.app')
@section('titulo', 'Acceso no autorizado')
@section('content')
    <div class="contenedor contenedor--estrecho pagina error-pagina">
        <p class="error-pagina__codigo">403</p>
        <h1>No tienes permiso para esto</h1>
        <p class="lede">{{ $exception->getMessage() ?: __('ttr.errores.sin_permiso') }}</p>
        <div class="hero__acciones">
            <a class="btn" href="{{ route('home') }}">Ir al inicio</a>
            @auth<a class="btn btn--sec" href="{{ route('admin.dashboard') }}">Volver al panel</a>@endauth
        </div>
    </div>
@endsection
