@props(['nombre' => null])
<span {{ $attributes->class(['plat', \App\Support\Ttr::claseDePlataforma($nombre)]) }}>{{ $nombre ?: 'Multi' }}</span>
