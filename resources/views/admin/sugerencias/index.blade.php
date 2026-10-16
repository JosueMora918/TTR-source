@extends('layouts.admin')

@section('titulo', 'Sugerencias · Panel')

@section('admin')
    <header class="pagina__cab pagina__cab--panel">
        <h1>Sugerencias de los lectores</h1>
    </header>

    <nav class="pestanas" aria-label="Filtrar por estado">
        <a href="{{ route('admin.sugerencias.index') }}" @class(['activo' => ! $estado])>Todas</a>
        <a href="{{ route('admin.sugerencias.index', ['estado' => 'pendiente']) }}" @class(['activo' => $estado === 'pendiente'])>Pendientes</a>
        <a href="{{ route('admin.sugerencias.index', ['estado' => 'revisada']) }}" @class(['activo' => $estado === 'revisada'])>Revisadas</a>
    </nav>

    <div class="tabla-wrap">
        <table class="tabla">
            <thead><tr><th>Videojuego</th><th>Lector</th><th>Comentario</th><th>Estado</th><th><span class="sr">Acciones</span></th></tr></thead>
            <tbody>
            @forelse ($sugerencias as $s)
                <tr>
                    <td data-etiqueta="Videojuego"><strong>{{ $s->titulo_juego }}</strong> <x-plataforma :nombre="$s->plataforma" /></td>
                    <td data-etiqueta="Lector">{{ $s->nombre }}<br><a href="mailto:{{ $s->email }}">{{ $s->email }}</a></td>
                    <td data-etiqueta="Comentario">{{ $s->comentario ?: '—' }}</td>
                    <td data-etiqueta="Estado"><x-estado :valor="$s->estado" /></td>
                    <td>
                        <div class="acciones-fila">
                            @if ($s->estado === 'pendiente')
                                <form method="POST" action="{{ route('admin.sugerencias.revisar', $s) }}" class="en-linea">@csrf @method('PATCH')<button class="btn btn--sec btn--sm" type="submit">Marcar revisada</button></form>
                            @endif
                            <form method="POST" action="{{ route('admin.sugerencias.destroy', $s) }}" class="en-linea" data-confirm="¿Eliminar la sugerencia de «{{ $s->titulo_juego }}»?">@csrf @method('DELETE')<button class="btn btn--peligro btn--sm" type="submit">Eliminar</button></form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr><td colspan="5" class="vacio vacio--chico">No hay sugerencias en esta vista.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>

    {{ $sugerencias->links() }}
@endsection
