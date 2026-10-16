@props([
    'nombre',
    'etiqueta',
    'tipo' => 'text',
    'valor' => null,
    'ayuda' => null,
    'opciones' => [],
    'vacio' => null,
    'requerido' => false,
])
{{-- Campo de formulario reutilizable: etiqueta + control + ayuda + error + old() --}}
@php($id = 'campo-'.$nombre)
<div @class(['campo', 'campo--error' => $errors->has($nombre)])>
    <label for="{{ $id }}">{{ $etiqueta }}@if ($requerido)<span class="campo__req" aria-hidden="true"> *</span>@endif</label>

    @if ($tipo === 'textarea')
        <textarea id="{{ $id }}" name="{{ $nombre }}" @required($requerido)
                  aria-describedby="{{ $nombre }}-msg" {{ $attributes->merge(['rows' => 4]) }}>{{ old($nombre, $valor) }}</textarea>
    @elseif ($tipo === 'select')
        <select id="{{ $id }}" name="{{ $nombre }}" @required($requerido) aria-describedby="{{ $nombre }}-msg" {{ $attributes }}>
            @if ($vacio !== null)<option value="">{{ $vacio }}</option>@endif
            {{-- $opciones: lista simple ['PC','Xbox'] o pares ['borrador' => 'Borrador'] --}}
            @foreach ($opciones as $clave => $texto)
                @php($v = is_int($clave) ? $texto : $clave)
                <option value="{{ $v }}" @selected((string) old($nombre, $valor) === (string) $v)>{{ $texto }}</option>
            @endforeach
        </select>
    @else
        <input id="{{ $id }}" type="{{ $tipo }}" name="{{ $nombre }}"
               @unless (in_array($tipo, ['password', 'file'])) value="{{ old($nombre, $valor) }}" @endunless
               @required($requerido) aria-describedby="{{ $nombre }}-msg" {{ $attributes }}>
    @endif

    <p class="campo__msg" id="{{ $nombre }}-msg">
        @error($nombre)<span class="campo__error">{{ $message }}</span>@elseif ($ayuda)<span class="campo__ayuda">{{ $ayuda }}</span>@enderror
    </p>
</div>
