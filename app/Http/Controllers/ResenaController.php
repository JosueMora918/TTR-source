<?php

namespace App\Http\Controllers;

use App\Models\Resena;
use App\Support\Ttr;
use Illuminate\Http\Request;

class ResenaController extends Controller
{
    /** Catálogo de reseñas con búsqueda, filtro por plataforma y orden (RF-04, RF-05). */
    public function index(Request $request)
    {
        $plataforma = in_array($request->query('plataforma'), Ttr::PLATAFORMAS, true) ? $request->query('plataforma') : null;
        $q = trim((string) $request->query('q'));
        $orden = $request->query('orden') === 'nota' ? 'nota' : 'recientes';

        $resenas = Resena::publicados()
            ->dePlataforma($plataforma)
            ->buscar($q)
            ->when($orden === 'nota',
                fn ($query) => $query->orderByDesc('puntuacion')->latest(),
                fn ($query) => $query->latest())
            ->paginate(9)
            ->withQueryString();

        return view('resenas.index', compact('resenas', 'plataforma', 'q', 'orden'));
    }

    /** Ficha técnica individual por slug. Borrador → 404 para el público. */
    public function show(Request $request, Resena $resena)
    {
        abort_unless($resena->estaPublicado() || $request->user(), 404);

        $relacionadas = Resena::publicados()
            ->where('id', '!=', $resena->id)
            ->where('plataforma', $resena->plataforma)
            ->latest()->take(3)->get();

        return view('resenas.show', compact('resena', 'relacionadas'));
    }
}
