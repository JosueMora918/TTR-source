<?php

namespace App\Http\Controllers;

use App\Models\Noticia;
use App\Support\Ttr;
use Illuminate\Http\Request;

class NoticiaController extends Controller
{
    /** Catálogo público con búsqueda, filtros y paginación (RF-01, RF-05). */
    public function index(Request $request)
    {
        $plataforma = in_array($request->query('plataforma'), Ttr::PLATAFORMAS, true) ? $request->query('plataforma') : null;
        $categoria = in_array($request->query('categoria'), Ttr::CATEGORIAS, true) ? $request->query('categoria') : null;
        $q = trim((string) $request->query('q'));

        $noticias = Noticia::publicados()
            ->dePlataforma($plataforma)
            ->when($categoria, fn ($query) => $query->where('categoria', $categoria))
            ->buscar($q)
            ->latest()
            ->paginate(9)
            ->withQueryString();

        return view('noticias.index', compact('noticias', 'plataforma', 'categoria', 'q'));
    }

    /** Lectura individual por slug (RF-02). Los borradores solo los ve el equipo editorial. */
    public function show(Request $request, Noticia $noticia)
    {
        abort_unless($noticia->estaPublicado() || $request->user(), 404);

        $relacionadas = Noticia::publicados()
            ->where('id', '!=', $noticia->id)
            ->where('categoria', $noticia->categoria)
            ->latest()->take(3)->get();

        return view('noticias.show', compact('noticia', 'relacionadas'));
    }
}
