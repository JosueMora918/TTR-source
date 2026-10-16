@extends('layouts.admin')

@section('titulo', 'Panel')

@section('admin')
    <header class="pagina__cab pagina__cab--panel">
        <h1>Hola, {{ auth()->user()->name }}</h1>
        <p class="lede">Resumen del contenido de TTR.</p>
    </header>

    <div class="rejilla rejilla--3 stats">
        @foreach ($contenidos as $nombre => $datos)
            <section class="stat">
                <h2>{{ $nombre }}</h2>
                <p class="stat__num">{{ $datos['total'] }}</p>
                <p class="stat__detalle">{{ $datos['publicados'] }} publicados · {{ $datos['borradores'] }} en borrador</p>
            </section>
        @endforeach
    </div>

    <div class="admin__dos">
        <section class="panel-caja">
            <h2>Reseñas por plataforma</h2>
            @php($maximo = max(1, $porPlataforma->max()))
            <ul class="barras">
                @foreach ($porPlataforma as $plataforma => $total)
                    <li class="{{ \App\Support\Ttr::claseDePlataforma($plataforma) }}">
                        <span>{{ $plataforma }}</span>
                        <span class="barras__pista"><span class="barras__valor" style="width: {{ ($total / $maximo) * 100 }}%"></span></span>
                        <span>{{ $total }}</span>
                    </li>
                @endforeach
            </ul>
            <p class="panel-caja__pie">Nota promedio: <strong>{{ $notaPromedio ? number_format($notaPromedio, 1) : '—' }}</strong></p>
        </section>

        <section class="panel-caja">
            <h2>Tus borradores</h2>
            @forelse ($misBorradores as [$tipo, $titulo, $url])
                @if ($loop->first)<ul class="lista-simple">@endif
                <li><span class="categoria">{{ $tipo }}</span> <a href="{{ $url }}">{{ $titulo }}</a></li>
                @if ($loop->last)</ul>@endif
            @empty
                <p class="vacio vacio--chico">No tienes borradores pendientes.</p>
            @endforelse
        </section>
    </div>

    <section class="panel-caja">
        <h2>Acciones rápidas</h2>
        <div class="hero__acciones">
            <a class="btn" href="{{ route('admin.resenas.create') }}">Nueva reseña</a>
            <a class="btn btn--sec" href="{{ route('admin.noticias.create') }}">Nueva noticia</a>
            <a class="btn btn--sec" href="{{ route('admin.trailers.create') }}">Nuevo tráiler</a>
            <a class="btn btn--sec" href="{{ route('admin.sugerencias.index', ['estado' => 'pendiente']) }}">{{ $sugerenciasPendientes }} sugerencias pendientes</a>
        </div>
    </section>
@endsection
