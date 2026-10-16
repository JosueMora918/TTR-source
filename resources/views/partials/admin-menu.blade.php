<aside class="admin__menu" aria-label="Menú del panel">
    <p class="admin__usuario">
        <strong>{{ auth()->user()->name }}</strong>
        <span class="rol rol--{{ auth()->user()->rol }}">{{ auth()->user()->rol }}</span>
    </p>
    <nav aria-label="Secciones del panel">
        <ul>
            <li><a href="{{ route('admin.dashboard') }}" @class(['activo' => request()->routeIs('admin.dashboard')])>Resumen</a></li>
            <li><a href="{{ route('admin.noticias.index') }}" @class(['activo' => request()->routeIs('admin.noticias.*')])>Noticias</a></li>
            <li><a href="{{ route('admin.trailers.index') }}" @class(['activo' => request()->routeIs('admin.trailers.*')])>Tráilers</a></li>
            <li><a href="{{ route('admin.resenas.index') }}" @class(['activo' => request()->routeIs('admin.resenas.*')])>Reseñas</a></li>
            <li><a href="{{ route('admin.sugerencias.index') }}" @class(['activo' => request()->routeIs('admin.sugerencias.*')])>Sugerencias</a></li>
            @if (auth()->user()->esAdmin())
                <li><a href="{{ route('admin.usuarios.index') }}" @class(['activo' => request()->routeIs('admin.usuarios.*')])>Usuarios</a></li>
            @endif
            <li><a href="{{ route('admin.cuenta.edit') }}" @class(['activo' => request()->routeIs('admin.cuenta.*')])>Mi cuenta</a></li>
        </ul>
    </nav>
</aside>
