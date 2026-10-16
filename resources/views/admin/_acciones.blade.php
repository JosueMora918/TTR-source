{{-- Acciones por fila. Variables: $item (modelo), $tipo (noticias|trailers|resenas) --}}
<div class="acciones-fila">
    @if ($item->estaPublicado())
        <a class="btn btn--sec btn--sm" href="{{ route($tipo.'.show', $item->slug) }}">Ver</a>
    @endif

    @can('update', $item)
        <a class="btn btn--sec btn--sm" href="{{ route('admin.'.$tipo.'.edit', $item) }}">Editar</a>

        <form method="POST" action="{{ route('admin.'.$tipo.'.estado', $item) }}" class="en-linea">
            @csrf
            @method('PATCH')
            <button type="submit" class="btn btn--sec btn--sm">{{ $item->estaPublicado() ? 'Pasar a borrador' : 'Publicar' }}</button>
        </form>
    @endcan

    @can('delete', $item)
        <form method="POST" action="{{ route('admin.'.$tipo.'.destroy', $item) }}" class="en-linea"
              data-confirm="¿Eliminar «{{ $item->titulo }}»? Esta acción no se puede deshacer.">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn--peligro btn--sm">Eliminar</button>
        </form>
    @endcan
</div>
