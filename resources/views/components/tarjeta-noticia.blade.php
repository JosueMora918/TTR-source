@props(['noticia'])
<article class="tarjeta tarjeta--noticia">
    <a href="{{ route('noticias.show', $noticia->slug) }}" class="tarjeta__enlace" tabindex="-1" aria-hidden="true">
        <div class="tarjeta__media">
            <x-portada :imagen="$noticia->imagen_url" :titulo="$noticia->titulo" :plataforma="$noticia->plataforma" />
        </div>
    </a>
    <div class="tarjeta__cuerpo">
        <p class="tarjeta__meta">
            <span class="categoria">{{ $noticia->categoria }}</span>
            @if ($noticia->plataforma)<x-plataforma :nombre="$noticia->plataforma" />@endif
        </p>
        <h3 class="tarjeta__titulo"><a href="{{ route('noticias.show', $noticia->slug) }}">{{ $noticia->titulo }}</a></h3>
        <p class="tarjeta__texto">{{ $noticia->extracto }}</p>
        <time class="tarjeta__fecha" datetime="{{ $noticia->created_at->toDateString() }}">{{ $noticia->created_at->translatedFormat('j \d\e F, Y') }}</time>
    </div>
</article>
