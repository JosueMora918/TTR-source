@extends('layouts.app')
@section('titulo', 'La página expiró')
@section('content')
    <div class="contenedor contenedor--estrecho pagina error-pagina">
        <p class="error-pagina__codigo">419</p>
        <h1>La página expiró</h1>
        <p class="lede">Tu sesión o el formulario caducó por seguridad (token CSRF). Vuelve atrás, recarga la página e inténtalo otra vez.</p>
        <div class="hero__acciones">
            <a class="btn" href="{{ url()->previous() }}">Volver</a>
            <a class="btn btn--sec" href="{{ route('home') }}">Ir al inicio</a>
        </div>
    </div>
@endsection
