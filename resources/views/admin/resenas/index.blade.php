@extends('layouts.admin')

@section('titulo', 'Reseñas · Panel')

@section('admin')
    <header class="pagina__cab pagina__cab--panel pagina__cab--fila">
        <h1>Reseñas</h1>
        <a class="btn" href="{{ route('admin.resenas.create') }}">Nueva reseña</a>
    </header>

    @include('partials.filtros', [
        'ruta' => route('admin.resenas.index'), 'q' => $q, 'plataforma' => $plataforma, 'placeholder' => 'Juego o desarrollador',
        'extras' => [['name' => 'estado', 'label' => 'Estado', 'valor' => $estado, 'opciones' => ['' => 'Todos', 'borrador' => 'Borrador', 'publicado' => 'Publicado']]],
    ])

    <div class="tabla-wrap">
        <table class="tabla">
            <thead><tr><th>Videojuego</th><th>Nota</th><th>Autor</th><th>Estado</th><th>Fecha</th><th><span class="sr">Acciones</span></th></tr></thead>
            <tbody>
            @forelse ($resenas as $item)
                <tr>
                    <td data-etiqueta="Videojuego"><strong>{{ $item->videojuego }}</strong> <x-plataforma :nombre="$item->plataforma" /></td>
                    <td data-etiqueta="Nota"><x-nota :valor="$item->puntuacion" /></td>
                    <td data-etiqueta="Autor">{{ $item->autor->name }}</td>
                    <td data-etiqueta="Estado"><x-estado :valor="$item->estado" /></td>
                    <td data-etiqueta="Fecha">{{ $item->created_at->format('d/m/Y') }}</td>
                    <td>@include('admin._acciones', ['item' => $item, 'tipo' => 'resenas'])</td>
                </tr>
            @empty
                <tr><td colspan="6" class="vacio vacio--chico">No hay reseñas con esos filtros.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>

    {{ $resenas->links() }}
@endsection
