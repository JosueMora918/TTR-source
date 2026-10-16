<?php

namespace App\Models;

use App\Models\Concerns\EsContenidoEditorial;
use App\Support\Ttr;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Trailer extends Model
{
    use EsContenidoEditorial, HasFactory;

    public const PLATAFORMAS = [...Ttr::PLATAFORMAS, 'Multi'];

    protected $fillable = [
        'user_id', 'titulo', 'slug', 'videojuego', 'plataforma',
        'url_embebida', 'descripcion', 'estado',
    ];

    public function scopeBuscar(Builder $query, ?string $termino): Builder
    {
        return $query->when($termino, function ($q) use ($termino) {
            $like = Ttr::comodin($termino);
            $q->where(fn ($w) => $w->where('titulo', 'like', $like)
                ->orWhere('videojuego', 'like', $like));
        });
    }

    /** 'youtube' | 'vimeo' | null según la URL registrada. */
    public function getProveedorAttribute(): ?string
    {
        return match (true) {
            (bool) preg_match('#(youtube\.com|youtu\.be|youtube-nocookie\.com)#i', $this->url_embebida) => 'youtube',
            (bool) preg_match('#vimeo\.com#i', $this->url_embebida) => 'vimeo',
            default => null,
        };
    }

    public function getVideoIdAttribute(): ?string
    {
        $patron = $this->proveedor === 'vimeo'
            ? '#vimeo\.com/(?:video/)?(\d+)#i'
            : '#(?:v=|youtu\.be/|/embed/|/shorts/)([A-Za-z0-9_-]{11})#';

        return preg_match($patron, (string) $this->url_embebida, $m) ? $m[1] : null;
    }

    /** URL para el <iframe>. Nunca se aloja video propio (RI-02 / RNF-04). */
    public function getIframeUrlAttribute(): ?string
    {
        if (! $this->video_id) {
            return null;
        }

        return $this->proveedor === 'vimeo'
            ? 'https://player.vimeo.com/video/'.$this->video_id
            : 'https://www.youtube-nocookie.com/embed/'.$this->video_id;
    }

    public function getMiniaturaAttribute(): ?string
    {
        return ($this->proveedor === 'youtube' && $this->video_id)
            ? 'https://i.ytimg.com/vi/'.$this->video_id.'/hqdefault.jpg'
            : null;
    }
}
