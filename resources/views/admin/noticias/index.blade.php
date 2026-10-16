@extends('layouts.admin')

@section('titulo', 'Noticias · Panel')

@section('admin')
    <header class="pagina__cab pagina__cab--panel pagina__cab--fila">
        <h1>Noticias</h1>
        <a class="btn" href="{{ route('admin.noticias.create') }}">Nueva noticia</a>
    </header>

    @include('partials.filtros', [
        'ruta' => route('admin.noticias.index'), 'q' => $q, 'plataforma' => $plataforma, 'placeholder' => 'Título o contenido',
        'extras' => [['name' => 'estado', 'label' => 'Estado', 'valor' => $estado, 'opciones' => ['' => 'Todos', 'borrador' => 'Borrador', 'publicado' => 'Publicado']]],
    ])

    <div class="tabla-wrap">
        <table class="tabla">
            <thead><tr><th>Título</th><th>Categoría</th><th>Autor</th><th>Estado</th><th>Fecha</th><th><span class="sr">Acciones</span></th></tr></thead>
            <tbody>
            @forelse ($noticias as $item)
                <tr>
                    <td data-etiqueta="Título"><strong>{{ $item->titulo }}</strong>@if ($item->plataforma) <x-plataforma :nombre="$item->plataforma" />@endif</td>
                    <td data-etiqueta="Categoría">{{ $item->categoria }}</td>
                    <td data-etiqueta="Autor">{{ $item->autor->name }}</td>
                    <td data-etiqueta="Estado"><x-estado :valor="$item->estado" /></td>
                    <td data-etiqueta="Fecha">{{ $item->created_at->format('d/m/Y') }}</td>
                    <td>@include('admin._acciones', ['item' => $item, 'tipo' => 'noticias'])</td>
                </tr>
            @empty
                <tr><td colspan="6" class="vacio vacio--chico">No hay noticias con esos filtros.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>

    {{ $noticias->links() }}
@endsection
