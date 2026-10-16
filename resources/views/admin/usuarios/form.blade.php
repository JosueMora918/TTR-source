@extends('layouts.admin')

@php($editando = $usuario->exists)
@section('titulo', ($editando ? 'Editar cuenta' : 'Nueva cuenta').' · Panel')

@section('admin')
    <header class="pagina__cab pagina__cab--panel">
        <h1>{{ $editando ? 'Editar cuenta' : 'Nueva cuenta' }}</h1>
        <p class="lede">Los lectores no necesitan cuenta; aquí se registran los redactores y administradores.</p>
    </header>

    <form method="POST" class="formulario" novalidate
          action="{{ $editando ? route('admin.usuarios.update', $usuario) : route('admin.usuarios.store') }}">
        @csrf
        @if ($editando) @method('PUT') @endif

        <div class="form-grid">
            <x-campo nombre="name" etiqueta="Nombre" :valor="$usuario->name" maxlength="100" autocomplete="off" :requerido="true" />
            <x-campo nombre="email" etiqueta="Correo electrónico" tipo="email" :valor="$usuario->email" maxlength="150" autocomplete="off" :requerido="true" />
            <x-campo nombre="rol" etiqueta="Rol" tipo="select" :opciones="['editor' => 'Editor (gestiona su propio contenido)', 'admin' => 'Administrador (gestiona todo)']" :valor="$usuario->rol" :requerido="true" />
        </div>

        <div class="form-grid">
            <x-campo nombre="password" :etiqueta="$editando ? 'Contraseña nueva (opcional)' : 'Contraseña'" tipo="password" autocomplete="new-password" ayuda="Mínimo 8 caracteres, con letras y números." :requerido="! $editando" />
            <x-campo nombre="password_confirmation" etiqueta="Repite la contraseña" tipo="password" autocomplete="new-password" :requerido="! $editando" />
        </div>

        <div class="formulario__acciones">
            <button type="submit" class="btn">{{ $editando ? 'Guardar cambios' : 'Crear cuenta' }}</button>
            <a class="btn btn--sec" href="{{ route('admin.usuarios.index') }}">Cancelar</a>
        </div>
    </form>
@endsection
