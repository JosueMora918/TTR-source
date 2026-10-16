<?php

namespace App\Models;

use App\Models\Concerns\EsContenidoEditorial;
use App\Support\Ttr;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Resena extends Model
{
    use EsContenidoEditorial, HasFactory;

    protected $fillable = [
        'user_id', 'titulo', 'slug', 'videojuego', 'desarrollador', 'genero',
        'plataforma', 'puntuacion', 'pros', 'contras', 'veredicto',
        'imagen_portada', 'estado',
    ];

    protected function casts(): array
    {
        return ['puntuacion' => 'decimal:1'];
    }

    public function scopeBuscar(Builder $query, ?string $termino): Builder
    {
        return $query->when($termino, function ($q) use ($termino) {
            $like = Ttr::comodin($termino);
            $q->where(fn ($w) => $w->where('titulo', 'like', $like)
                ->orWhere('videojuego', 'like', $like)
                ->orWhere('desarrollador', 'like', $like));
        });
    }

    /** Regla de negocio del diagrama de clases: la nota va de 1.0 a 10.0. */
    public static function validarPuntuacion(float $nota): bool
    {
        return $nota >= 1.0 && $nota <= 10.0;
    }

    public function getProsListaAttribute()
    {
        return Ttr::lineas($this->pros);
    }

    public function getContrasListaAttribute()
    {
        return Ttr::lineas($this->contras);
    }

    public function getVeredictoParrafosAttribute()
    {
        return Ttr::parrafos($this->veredicto);
    }
}
