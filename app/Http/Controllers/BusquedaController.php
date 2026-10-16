<?php

namespace App\Http\Controllers;

use App\Models\Noticia;
use App\Models\Resena;
use App\Models\Trailer;
use App\Support\Ttr;
use Illuminate\Http\Request;

class BusquedaController extends Controller
{
    /** Búsqueda global sobre noticias, tráilers y reseñas publicados (RF-05). */
    public function index(Request $request)
    {
        $datos = $request->validate([
            'q' => ['nullable', 'string', 'min:2', 'max:80'],
            'plataforma' => ['nullable', 'in:'.implode(',', Ttr::PLATAFORMAS)],
        ]);

        $q = trim((string) ($datos['q'] ?? ''));
        $plataforma = $datos['plataforma'] ?? null;
        $buscando = $q !== '';

        $resultados = [
            'resenas' => $buscando ? Resena::publicados()->dePlataforma($plataforma)->buscar($q)->latest()->take(8)->get() : collect(),
            'trailers' => $buscando ? Trailer::publicados()->dePlataforma($plataforma)->buscar($q)->latest()->take(8)->get() : collect(),
            'noticias' => $buscando ? Noticia::publicados()->dePlataforma($plataforma)->buscar($q)->latest()->take(8)->get() : collect(),
        ];

        $total = collect($resultados)->sum(fn ($c) => $c->count());

        return view('busqueda.index', compact('q', 'plataforma', 'buscando', 'resultados', 'total'));
    }
}
