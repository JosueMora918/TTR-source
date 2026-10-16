<footer class="sitio-pie">
    <div class="contenedor pie__grid">
        <div>
            <p class="pie__marca">TTR</p>
            <p class="pie__texto">Trailers, Teasers and Reviews. Un medio independiente de videojuegos: rápido, sin banners y con notas del 1.0 al 10.0.</p>
        </div>
        <nav aria-label="Secciones">
            <p class="pie__titulo">Secciones</p>
            <ul>
                <li><a href="{{ route('noticias.index') }}">{{ __('ttr.nav.noticias') }}</a></li>
                <li><a href="{{ route('trailers.index') }}">{{ __('ttr.nav.trailers') }}</a></li>
                <li><a href="{{ route('resenas.index') }}">{{ __('ttr.nav.resenas') }}</a></li>
                <li><a href="{{ route('sugerencias.create') }}">{{ __('ttr.nav.sugerir') }}</a></li>
            </ul>
        </nav>
        <nav aria-label="Plataformas">
            <p class="pie__titulo">Plataformas</p>
            <ul>
                @foreach (\App\Support\Ttr::PLATAFORMAS as $p)
                    <li><a href="{{ route('plataformas.show', strtolower($p)) }}">{{ $p }}</a></li>
                @endforeach
            </ul>
        </nav>
        <div>
            <p class="pie__titulo">Proyecto</p>
            <p class="pie__texto">Proyecto de titulación, Centro Universitario de los Valles, Universidad de Guadalajara.</p>
            <p class="pie__texto"><a href="{{ route('login') }}">Acceso para editores</a></p>
        </div>
    </div>
    <div class="contenedor pie__legal">© {{ date('Y') }} TTR. Los videos se reproducen desde plataformas externas.</div>
</footer>
