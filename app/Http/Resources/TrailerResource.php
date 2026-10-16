<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TrailerResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'slug' => $this->slug,
            'titulo' => $this->titulo,
            'videojuego' => $this->videojuego,
            'plataforma' => $this->plataforma,
            'proveedor' => $this->proveedor,
            'iframe_url' => $this->iframe_url,
            'descripcion' => $this->descripcion,
            'url' => route('trailers.show', $this->slug),
            'publicado' => $this->created_at?->toIso8601String(),
        ];
    }
}
