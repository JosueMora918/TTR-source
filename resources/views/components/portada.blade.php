@props(['imagen' => null, 'titulo' => '', 'plataforma' => null, 'ratio' => '16-9'])
{{-- Portada con imagen subida o, si no existe, una portada generada con el color de la plataforma --}}
<div {{ $attributes->class(['portada', 'portada--'.$ratio, \App\Support\Ttr::claseDePlataforma($plataforma) => ! $imagen]) }}>
    @if ($imagen)
        <img src="{{ $imagen }}" alt="" loading="lazy" decoding="async">
    @else
        <span class="portada__inicial" aria-hidden="true">{{ mb_strtoupper(mb_substr($titulo, 0, 1)) }}</span>
    @endif
</div>
