<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class NoticiaResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'slug' => $this->slug,
            'titulo' => $this->titulo,
            'resumen' => $this->extracto,
            'contenido' => $this->when($request->route('noticia'), $this->contenido),
            'categoria' => $this->categoria,
            'plataforma' => $this->plataforma,
            'imagen' => $this->imagen_url,
            'url' => route('noticias.show', $this->slug),
            'publicada' => $this->created_at?->toIso8601String(),
        ];
    }
}
