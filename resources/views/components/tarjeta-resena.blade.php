@props(['resena'])
<article class="tarjeta tarjeta--resena">
    <a href="{{ route('resenas.show', $resena->slug) }}" class="tarjeta__enlace" aria-label="{{ $resena->titulo }}">
        <div class="tarjeta__media">
            <x-portada :imagen="$resena->imagen_url" :titulo="$resena->videojuego" :plataforma="$resena->plataforma" />
            <x-nota :valor="$resena->puntuacion" class="tarjeta__nota" />
        </div>
    </a>
    <div class="tarjeta__cuerpo">
        <x-plataforma :nombre="$resena->plataforma" />
        <h3 class="tarjeta__titulo"><a href="{{ route('resenas.show', $resena->slug) }}">{{ $resena->videojuego }}</a></h3>
        <p class="tarjeta__meta">{{ $resena->desarrollador }} · {{ $resena->genero }}</p>
    </div>
</article>
