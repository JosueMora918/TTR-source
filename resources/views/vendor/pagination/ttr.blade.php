@if ($paginator->hasPages())
    <nav class="paginacion" role="navigation" aria-label="Paginación">
        @if ($paginator->onFirstPage())
            <span class="btn btn--sec btn--off" aria-disabled="true">{{ __('ttr.paginacion.anterior') }}</span>
        @else
            <a class="btn btn--sec" href="{{ $paginator->previousPageUrl() }}" rel="prev">{{ __('ttr.paginacion.anterior') }}</a>
        @endif

        <span class="paginacion__estado">{{ __('ttr.paginacion.pagina', ['actual' => $paginator->currentPage(), 'total' => $paginator->lastPage()]) }}</span>

        @if ($paginator->hasMorePages())
            <a class="btn btn--sec" href="{{ $paginator->nextPageUrl() }}" rel="next">{{ __('ttr.paginacion.siguiente') }}</a>
        @else
            <span class="btn btn--sec btn--off" aria-disabled="true">{{ __('ttr.paginacion.siguiente') }}</span>
        @endif
    </nav>
@endif
