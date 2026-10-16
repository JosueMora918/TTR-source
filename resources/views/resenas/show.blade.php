@extends('layouts.app')

@section('titulo', $resena->titulo)
@section('descripcion', \Illuminate\Support\Str::limit(strip_tags($resena->veredicto), 155))

@section('content')
    <div class="contenedor pagina">
        @include('partials.migas', ['items' => [['Reseñas', route('resenas.index')], [$resena->videojuego, null]]])

        <header class="articulo__cab">
            <p class="tarjeta__meta">
                <x-plataforma :nombre="$resena->plataforma" />
                @unless ($resena->estaPublicado())<x-estado valor="borrador" />@endunless
            </p>
            <h1>{{ $resena->titulo }}</h1>
            <p class="articulo__firma">
                Por {{ $resena->autor->name }} ·
                <time datetime="{{ $resena->created_at->toDateString() }}">{{ $resena->created_at->translatedFormat('j \d\e F, Y') }}</time>
            </p>
        </header>

        <div class="resena">
            <aside class="resena__lateral">
                <div class="resena__nota {{ \App\Support\Ttr::claseDePlataforma($resena->plataforma) }}">
                    <x-nota :valor="$resena->puntuacion" :grande="true" />
                    <p>Nota de la redacción</p>
                </div>

                <dl class="ficha">
                    <div><dt>Videojuego</dt><dd>{{ $resena->videojuego }}</dd></div>
                    <div><dt>Desarrollador</dt><dd>{{ $resena->desarrollador }}</dd></div>
                    <div><dt>Género</dt><dd>{{ $resena->genero }}</dd></div>
                    <div><dt>Plataforma</dt><dd><x-plataforma :nombre="$resena->plataforma" /></dd></div>
                </dl>
            </aside>

            <div class="resena__principal">
                @if ($resena->imagen_url)
                    <x-portada :imagen="$resena->imagen_url" :titulo="$resena->videojuego" :plataforma="$resena->plataforma" class="articulo__portada" />
                @endif

                <div class="balance">
                    <section class="balance__col balance__col--pros" aria-labelledby="pros-t">
                        <h2 id="pros-t">Lo mejor</h2>
                        <ul>@foreach ($resena->pros_lista as $punto)<li>{{ $punto }}</li>@endforeach</ul>
                    </section>
                    <section class="balance__col balance__col--contras" aria-labelledby="contras-t">
                        <h2 id="contras-t">Lo que falla</h2>
                        <ul>@foreach ($resena->contras_lista as $punto)<li>{{ $punto }}</li>@endforeach</ul>
                    </section>
                </div>

                <section class="prosa" aria-labelledby="veredicto-t">
                    <h2 id="veredicto-t">Veredicto</h2>
                    @foreach ($resena->veredicto_parrafos as $parrafo)
                        <p>{!! nl2br(e($parrafo)) !!}</p>
                    @endforeach
                </section>
            </div>
        </div>
    </div>

    @if ($relacionadas->isNotEmpty())
        <section class="contenedor seccion">
            <div class="seccion__cab"><h2>Más reseñas de {{ $resena->plataforma }}</h2><a href="{{ route('plataformas.show', strtolower($resena->plataforma)) }}">Ver plataforma</a></div>
            <div class="rejilla rejilla--3">
                @foreach ($relacionadas as $r)
                    <x-tarjeta-resena :resena="$r" />
                @endforeach
            </div>
        </section>
    @endif
@endsection
