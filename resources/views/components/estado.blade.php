@props(['valor'])
<span {{ $attributes->class(['estado', 'estado--'.$valor]) }}>{{ __('ttr.estado.'.$valor) }}</span>
