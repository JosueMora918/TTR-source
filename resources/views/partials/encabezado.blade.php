<header class="sitio-header">
    <div class="contenedor sitio-header__fila">
        <a href="{{ route('home') }}" class="marca" aria-label="TTR, ir al inicio">
            <svg class="marca__icono" viewBox="0 0 32 32" aria-hidden="true" focusable="false">
                <rect width="32" height="32" rx="9" fill="currentColor"/>
                <path d="M12 9.5v13l11-6.5z" fill="var(--marca-tinta)"/>
            </svg>
            <span class="marca__texto">TTR</span>
        </a>

        <button class="nav-toggle" type="button" aria-expanded="false" aria-controls="menu-principal">
            <span class="sr">{{ __('ttr.nav.menu') }}</span>
            <span class="nav-toggle__barras" aria-hidden="true"></span>
        </button>

        <div class="sitio-nav" id="menu-principal">
            <nav aria-label="Principal">
                <ul class="menu">
                    <li><a href="{{ route('noticias.index') }}" @class(['activo' => request()->routeIs('noticias.*')]) @if (request()->routeIs('noticias.*')) aria-current="page" @endif>{{ __('ttr.nav.noticias') }}</a></li>
                    <li><a href="{{ route('trailers.index') }}" @class(['activo' => request()->routeIs('trailers.*')]) @if (request()->routeIs('trailers.*')) aria-current="page" @endif>{{ __('ttr.nav.trailers') }}</a></li>
                    <li><a href="{{ route('resenas.index') }}" @class(['activo' => request()->routeIs('resenas.*')]) @if (request()->routeIs('resenas.*')) aria-current="page" @endif>{{ __('ttr.nav.resenas') }}</a></li>
                    <li><a href="{{ route('plataformas.show') }}" @class(['activo' => request()->routeIs('plataformas.*')]) @if (request()->routeIs('plataformas.*')) aria-current="page" @endif>{{ __('ttr.nav.plataformas') }}</a></li>
                    <li><a href="{{ route('sugerencias.create') }}" @class(['activo' => request()->routeIs('sugerencias.*')]) @if (request()->routeIs('sugerencias.*')) aria-current="page" @endif>{{ __('ttr.nav.sugerir') }}</a></li>
                </ul>
            </nav>

            <form class="buscador" role="search" action="{{ route('busqueda') }}" method="GET">
                <label class="sr" for="buscar-global">{{ __('ttr.nav.buscar') }}</label>
                <input id="buscar-global" type="search" name="q" value="{{ request()->routeIs('busqueda') ? request('q') : '' }}" placeholder="{{ __('ttr.nav.buscar') }}…" maxlength="80">
            </form>

            <div class="acciones">
                <button class="btn-tema" type="button" aria-label="{{ __('ttr.nav.tema') }}" title="{{ __('ttr.nav.tema') }}">
                    <svg viewBox="0 0 24 24" width="20" height="20" aria-hidden="true" focusable="false"><path fill="currentColor" d="M12 3a9 9 0 1 0 9 9c0-.46-.04-.92-.1-1.36a5.39 5.39 0 0 1-4.4 2.26A5.4 5.4 0 0 1 11.1 7.5c0-1.8.88-3.4 2.24-4.4A9.2 9.2 0 0 0 12 3z"/></svg>
                </button>

                @auth
                    <a class="btn btn--sm" href="{{ route('admin.dashboard') }}">{{ __('ttr.nav.panel') }}</a>
                    <form method="POST" action="{{ route('logout') }}" class="en-linea">
                        @csrf
                        <button type="submit" class="btn btn--sec btn--sm">{{ __('ttr.nav.salir') }}</button>
                    </form>
                @else
                    <a class="btn btn--sec btn--sm" href="{{ route('login') }}">{{ __('ttr.nav.acceso') }}</a>
                @endauth
            </div>
        </div>
    </div>
</header>
