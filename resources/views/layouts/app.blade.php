<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@hasSection('titulo')@yield('titulo') · @endif{{ config('app.name', 'TTR') }}</title>
    <meta name="description" content="@yield('descripcion', 'Noticias, tráilers y reseñas de videojuegos con ficha técnica y nota del 1.0 al 10.0, en una plataforma rápida y sin publicidad.')">
    <meta name="color-scheme" content="dark light">

    {{-- Aplica el tema guardado antes de pintar para evitar el parpadeo --}}
    <script>try{var t=localStorage.getItem('ttr-tema');if(t==='dark'||t==='light'){document.documentElement.dataset.tema=t}}catch(e){}</script>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Bricolage+Grotesque:opsz,wght@12..96,500..800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/ttr.css') }}">
    @stack('head')
</head>
<body>
    <a class="saltar" href="#contenido">{{ __('ttr.nav.saltar') }}</a>

    @include('partials.encabezado')

    <main id="contenido">
        @include('partials.mensajes')
        @yield('content')
    </main>

    @include('partials.pie')

    <script src="{{ asset('js/ttr.js') }}" defer></script>
    @stack('scripts')
</body>
</html>
