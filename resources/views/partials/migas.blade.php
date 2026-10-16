{{-- Ruta de navegación. Uso: @include('partials.migas', ['items' => [['Noticias', route('noticias.index')], ['Título', null]]]) --}}
<nav class="migas" aria-label="Ruta de navegación">
    <ol>
        <li><a href="{{ route('home') }}">Inicio</a></li>
        @foreach ($items as [$texto, $url])
            <li>
                @if ($url)<a href="{{ $url }}">{{ $texto }}</a>@else<span aria-current="page">{{ $texto }}</span>@endif
            </li>
        @endforeach
    </ol>
</nav>
