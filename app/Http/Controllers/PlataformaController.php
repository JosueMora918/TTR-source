<?php

namespace App\Http\Controllers;

use App\Models\Noticia;
use App\Models\Resena;
use App\Models\Trailer;
use App\Support\Ttr;

class PlataformaController extends Controller
{
    /**
     * Ruta con parámetro OPCIONAL: /plataformas  (índice)  |  /plataformas/{plataforma}
     */
    public function show(?string $plataforma = null)
    {
        if ($plataforma === null) {
            $conteos = collect(Ttr::PLATAFORMAS)->mapWithKeys(fn ($p) => [
                $p => Resena::publicados()->where('plataforma', $p)->count()
                    + Trailer::publicados()->where('plataforma', $p)->count()
                    + Noticia::publicados()->where('plataforma', $p)->count(),
            ]);

            return view('plataformas.index', compact('conteos'));
        }

        $nombre = Ttr::plataformaDesdeSlug($plataforma);
        abort_if($nombre === null, 404);

        return view('plataformas.show', [
            'plataforma' => $nombre,
            'resenas' => Resena::publicados()->dePlataforma($nombre)->latest()->take(6)->get(),
            'trailers' => Trailer::publicados()->dePlataforma($nombre)->latest()->take(3)->get(),
            'noticias' => Noticia::publicados()->dePlataforma($nombre)->latest()->take(6)->get(),
        ]);
    }
}
