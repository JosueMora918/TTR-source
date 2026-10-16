{{-- Mensajes de sesión (flash) y errores de validación --}}
<div class="contenedor mensajes">
    @if (session('exito'))
        <div class="aviso aviso--exito" role="status">{{ session('exito') }}</div>
    @endif

    @if (session('aviso'))
        <div class="aviso aviso--aviso" role="status">{{ session('aviso') }}</div>
    @endif

    @if (session('error'))
        <div class="aviso aviso--error" role="alert">{{ session('error') }}</div>
    @endif

    @if (isset($errors) && $errors->any())
        <div class="aviso aviso--error" role="alert">
            <strong>Revisa los campos marcados:</strong>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
</div>
