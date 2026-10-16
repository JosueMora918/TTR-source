@props(['valor', 'grande' => false])
<span {{ $attributes->class(['nota', \App\Support\Ttr::claseNota($valor), 'nota--grande' => $grande]) }}
      aria-label="Puntuación {{ number_format((float) $valor, 1) }} de 10">
    <span class="nota__num">{{ number_format((float) $valor, 1) }}</span>@if ($grande)<span class="nota__max">/10</span>@endif
</span>
