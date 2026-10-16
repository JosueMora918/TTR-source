@props(['trailer'])
{{-- Fachada de video: el <iframe> externo solo se carga al hacer clic (cuida el LCP y el ancho de banda) --}}
<article class="tarjeta tarjeta--trailer">
    @if ($trailer->iframe_url)
        <button type="button" class="video-fachada {{ \App\Support\Ttr::claseDePlataforma($trailer->plataforma) }}"
                data-embed="{{ $trailer->iframe_url }}" data-titulo="{{ $trailer->titulo }}"
                aria-label="Reproducir {{ $trailer->titulo }}">
            @if ($trailer->miniatura)
                <img src="{{ $trailer->miniatura }}" alt="" loading="lazy" decoding="async">
            @endif
            <span class="video-fachada__play" aria-hidden="true"></span>
        </button>
        <noscript><p class="tarjeta__meta"><a href="{{ $trailer->url_embebida }}" rel="noopener" target="_blank">Ver en el sitio del proveedor</a></p></noscript>
    @else
        <div class="video-fachada video-fachada--vacio"><span>Video no disponible</span></div>
    @endif
    <div class="tarjeta__cuerpo">
        <p class="tarjeta__meta"><x-plataforma :nombre="$trailer->plataforma" /></p>
        <h3 class="tarjeta__titulo"><a href="{{ route('trailers.show', $trailer->slug) }}">{{ $trailer->titulo }}</a></h3>
    </div>
</article>
