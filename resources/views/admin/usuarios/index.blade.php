@extends('layouts.admin')

@section('titulo', 'Usuarios · Panel')

@section('admin')
    <header class="pagina__cab pagina__cab--panel pagina__cab--fila">
        <h1>Usuarios</h1>
        <a class="btn" href="{{ route('admin.usuarios.create') }}">Nueva cuenta</a>
    </header>

    <div class="tabla-wrap">
        <table class="tabla">
            <thead><tr><th>Nombre</th><th>Correo</th><th>Rol</th><th>Contenido</th><th><span class="sr">Acciones</span></th></tr></thead>
            <tbody>
            @foreach ($usuarios as $u)
                <tr>
                    <td data-etiqueta="Nombre"><strong>{{ $u->name }}</strong>@if ($u->id === auth()->id()) <span class="categoria">tú</span>@endif</td>
                    <td data-etiqueta="Correo">{{ $u->email }}</td>
                    <td data-etiqueta="Rol"><span class="rol rol--{{ $u->rol }}">{{ $u->rol }}</span></td>
                    <td data-etiqueta="Contenido">{{ $u->noticias_count }} noticias · {{ $u->trailers_count }} tráilers · {{ $u->resenas_count }} reseñas</td>
                    <td>
                        <div class="acciones-fila">
                            <a class="btn btn--sec btn--sm" href="{{ route('admin.usuarios.edit', $u) }}">Editar</a>
                            @if ($u->id !== auth()->id())
                                <form method="POST" action="{{ route('admin.usuarios.destroy', $u) }}" class="en-linea" data-confirm="¿Eliminar la cuenta de «{{ $u->name }}»?">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn--peligro btn--sm">Eliminar</button>
                                </form>
                            @endif
                        </div>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>

    {{ $usuarios->links() }}
@endsection
