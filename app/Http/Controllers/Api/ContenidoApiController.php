<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\NoticiaResource;
use App\Http\Resources\ResenaResource;
use App\Http\Resources\TrailerResource;
use App\Models\Noticia;
use App\Models\Resena;
use App\Models\Trailer;
use App\Support\Ttr;
use Illuminate\Http\Request;

/**
 * API REST de solo lectura (/api/v1). Solo expone contenido PUBLICADO.
 * Filtros: ?plataforma=PC  ?q=texto  ?page=2
 */
class ContenidoApiController extends Controller
{
    private function plataforma(Request $request): ?string
    {
        return in_array($request->query('plataforma'), Ttr::PLATAFORMAS, true) ? $request->query('plataforma') : null;
    }

    public function noticias(Request $request)
    {
        return NoticiaResource::collection(
            Noticia::publicados()->dePlataforma($this->plataforma($request))
                ->buscar(trim((string) $request->query('q')))
                ->latest()->paginate(10)->withQueryString()
        );
    }

    public function noticia(Noticia $noticia)
    {
        abort_unless($noticia->estaPublicado(), 404);

        return new NoticiaResource($noticia);
    }

    public function trailers(Request $request)
    {
        return TrailerResource::collection(
            Trailer::publicados()->dePlataforma($this->plataforma($request))
                ->buscar(trim((string) $request->query('q')))
                ->latest()->paginate(10)->withQueryString()
        );
    }

    public function trailer(Trailer $trailer)
    {
        abort_unless($trailer->estaPublicado(), 404);

        return new TrailerResource($trailer);
    }

    public function resenas(Request $request)
    {
        return ResenaResource::collection(
            Resena::publicados()->dePlataforma($this->plataforma($request))
                ->buscar(trim((string) $request->query('q')))
                ->latest()->paginate(10)->withQueryString()
        );
    }

    public function resena(Resena $resena)
    {
        abort_unless($resena->estaPublicado(), 404);

        return new ResenaResource($resena);
    }
}
