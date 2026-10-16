<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    public const ROLES = ['admin', 'editor'];

    protected $fillable = ['name', 'email', 'password', 'rol'];

    protected $hidden = ['password', 'remember_token'];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed', // Bcrypt automático al asignar (RNF-03)
        ];
    }

    public function esAdmin(): bool
    {
        return $this->rol === 'admin';
    }

    public function noticias(): HasMany
    {
        return $this->hasMany(Noticia::class);
    }

    public function trailers(): HasMany
    {
        return $this->hasMany(Trailer::class);
    }

    public function resenas(): HasMany
    {
        return $this->hasMany(Resena::class);
    }

    /** Integridad: un usuario con contenido no puede eliminarse. */
    public function tieneContenido(): bool
    {
        return $this->noticias()->exists()
            || $this->trailers()->exists()
            || $this->resenas()->exists();
    }
}
