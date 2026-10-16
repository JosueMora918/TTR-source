<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ResenaResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'slug' => $this->slug,
            'titulo' => $this->titulo,
            'videojuego' => $this->videojuego,
            'desarrollador' => $this->desarrollador,
            'genero' => $this->genero,
            'plataforma' => $this->plataforma,
            'puntuacion' => (float) $this->puntuacion,
            'pros' => $this->pros_lista,
            'contras' => $this->contras_lista,
            'veredicto' => $this->veredicto,
            'imagen' => $this->imagen_url,
            'url' => route('resenas.show', $this->slug),
            'publicada' => $this->created_at?->toIso8601String(),
        ];
    }
}
