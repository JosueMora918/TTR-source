<?php

namespace App\Http\Controllers;

use App\Models\Trailer;
use Illuminate\Http\Request;

class TrailerController extends Controller
{
    /** Catálogo de tráilers y teasers embebidos (RF-03, RI-02). */
    public function index(Request $request)
    {
        $plataforma = in_array($request->query('plataforma'), Trailer::PLATAFORMAS, true) ? $request->query('plataforma') : null;
        $q = trim((string) $request->query('q'));

        $trailers = Trailer::publicados()
            ->dePlataforma($plataforma)
            ->buscar($q)
            ->latest()
            ->paginate(9)
            ->withQueryString();

        return view('trailers.index', compact('trailers', 'plataforma', 'q'));
    }

    public function show(Request $request, Trailer $trailer)
    {
        abort_unless($trailer->estaPublicado() || $request->user(), 404);

        $otros = Trailer::publicados()->where('id', '!=', $trailer->id)->latest()->take(3)->get();

        return view('trailers.show', compact('trailer', 'otros'));
    }
}
