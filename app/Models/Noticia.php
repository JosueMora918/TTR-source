<?php

namespace App\Models;

use App\Models\Concerns\EsContenidoEditorial;
use App\Support\Ttr;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Noticia extends Model
{
    use EsContenidoEditorial, HasFactory;

    protected $fillable = [
        'user_id', 'titulo', 'slug', 'resumen', 'contenido',
        'imagen_portada', 'categoria', 'plataforma', 'estado',
    ];

    public function scopeBuscar(Builder $query, ?string $termino): Builder
    {
        return $query->when($termino, function ($q) use ($termino) {
            $like = Ttr::comodin($termino);
            $q->where(fn ($w) => $w->where('titulo', 'like', $like)
                ->orWhere('resumen', 'like', $like)
                ->orWhere('contenido', 'like', $like));
        });
    }

    public function getExtractoAttribute(): string
    {
        return $this->resumen ?: Str::limit(strip_tags($this->contenido), 150);
    }

    public function getParrafosAttribute()
    {
        return Ttr::parrafos($this->contenido);
    }
}
