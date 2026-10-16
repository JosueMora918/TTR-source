{{--
  Barra de búsqueda y filtros (GET). Variables: $ruta, $q, $plataforma
  Opcionales: $plataformas (lista), $extras = [['name','label','opciones'=>[valor=>texto],'valor']], $placeholder
--}}
@php
    $plataformas = $plataformas ?? \App\Support\Ttr::PLATAFORMAS;
    $extras = $extras ?? [];
    $hayFiltros = collect([$q, $plataforma])->merge(collect($extras)->pluck('valor'))->filter()->isNotEmpty();
@endphp
<form class="filtros" method="GET" action="{{ $ruta }}" role="search">
    <div class="filtros__campo filtros__campo--grande">
        <label for="f-q">Buscar</label>
        <input id="f-q" type="search" name="q" value="{{ $q }}" maxlength="80" placeholder="{{ $placeholder ?? 'Título, juego o palabra clave' }}">
    </div>

    <div class="filtros__campo">
        <label for="f-plataforma">Plataforma</label>
        <select id="f-plataforma" name="plataforma">
            <option value="">Todas</option>
            @foreach ($plataformas as $p)
                <option value="{{ $p }}" @selected($plataforma === $p)>{{ $p }}</option>
            @endforeach
        </select>
    </div>

    @foreach ($extras as $extra)
        <div class="filtros__campo">
            <label for="f-{{ $extra['name'] }}">{{ $extra['label'] }}</label>
            <select id="f-{{ $extra['name'] }}" name="{{ $extra['name'] }}">
                @foreach ($extra['opciones'] as $valor => $texto)
                    <option value="{{ $valor }}" @selected((string) $extra['valor'] === (string) $valor)>{{ $texto }}</option>
                @endforeach
            </select>
        </div>
    @endforeach

    <div class="filtros__acciones">
        <button class="btn" type="submit">Filtrar</button>
        @if ($hayFiltros)<a class="btn btn--sec" href="{{ $ruta }}">Limpiar</a>@endif
    </div>
</form>
