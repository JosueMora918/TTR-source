@extends('layouts.admin')

@section('titulo', 'Tráilers · Panel')

@section('admin')
    <header class="pagina__cab pagina__cab--panel pagina__cab--fila">
        <h1>Tráilers</h1>
        <a class="btn" href="{{ route('admin.trailers.create') }}">Nuevo tráiler</a>
    </header>

    @include('partials.filtros', [
        'ruta' => route('admin.trailers.index'), 'q' => $q, 'plataforma' => $plataforma, 'plataformas' => \App\Models\Trailer::PLATAFORMAS,
        'placeholder' => 'Título o videojuego',
        'extras' => [['name' => 'estado', 'label' => 'Estado', 'valor' => $estado, 'opciones' => ['' => 'Todos', 'borrador' => 'Borrador', 'publicado' => 'Publicado']]],
    ])

    <div class="tabla-wrap">
        <table class="tabla">
            <thead><tr><th>Título</th><th>Proveedor</th><th>Autor</th><th>Estado</th><th>Fecha</th><th><span class="sr">Acciones</span></th></tr></thead>
            <tbody>
            @forelse ($trailers as $item)
                <tr>
                    <td data-etiqueta="Título"><strong>{{ $item->titulo }}</strong> <x-plataforma :nombre="$item->plataforma" /></td>
                    <td data-etiqueta="Proveedor">{{ $item->proveedor ? ucfirst($item->proveedor) : 'Enlace no válido' }}</td>
                    <td data-etiqueta="Autor">{{ $item->autor->name }}</td>
                    <td data-etiqueta="Estado"><x-estado :valor="$item->estado" /></td>
                    <td data-etiqueta="Fecha">{{ $item->created_at->format('d/m/Y') }}</td>
                    <td>@include('admin._acciones', ['item' => $item, 'tipo' => 'trailers'])</td>
                </tr>
            @empty
                <tr><td colspan="6" class="vacio vacio--chico">No hay tráilers con esos filtros.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>

    {{ $trailers->links() }}
@endsection
