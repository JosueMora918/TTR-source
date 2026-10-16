<?php

namespace App\Models\Concerns;

use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

/**
 * Comportamiento compartido por Noticia, Trailer y Resena:
 * slug único automático, estado Borrador/Publicado, autor y filtros.
 */
trait EsContenidoEditorial
{
    public static function bootEsContenidoEditorial(): void
    {
        static::creating(function ($modelo) {
            if (empty($modelo->slug)) {
                $modelo->slug = static::slugUnico($modelo->titulo);
            }
        });
    }

    public static function slugUnico(string $base): string
    {
        $slug = Str::slug(Str::limit($base, 180, '')) ?: 'contenido';
        $original = $slug;
        $n = 2;

        while (static::where('slug', $slug)->exists()) {
            $slug = $original.'-'.$n++;
        }

        return $slug;
    }

    public function autor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function scopePublicados(Builder $query): Builder
    {
        return $query->where('estado', 'publicado');
    }

    public function scopeDePlataforma(Builder $query, ?string $plataforma): Builder
    {
        return $query->when($plataforma, fn ($q) => $q->where('plataforma', $plataforma));
    }

    public function scopeConEstado(Builder $query, ?string $estado): Builder
    {
        return $query->when($estado, fn ($q) => $q->where('estado', $estado));
    }

    public function estaPublicado(): bool
    {
        return $this->estado === 'publicado';
    }

    public function getImagenUrlAttribute(): ?string
    {
        return $this->imagen_portada ? Storage::disk('public')->url($this->imagen_portada) : null;
    }
}
