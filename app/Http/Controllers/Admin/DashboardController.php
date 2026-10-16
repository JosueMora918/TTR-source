<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Noticia;
use App\Models\Resena;
use App\Models\Sugerencia;
use App\Models\Trailer;
use App\Support\Ttr;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        // Uso de Collections: se combinan los tres tipos de contenido para el resumen.
        $contenidos = collect([
            'Noticias' => Noticia::query(),
            'Tráilers' => Trailer::query(),
            'Reseñas' => Resena::query(),
        ])->map(fn ($consulta) => [
            'total' => (clone $consulta)->count(),
            'publicados' => (clone $consulta)->where('estado', 'publicado')->count(),
            'borradores' => (clone $consulta)->where('estado', 'borrador')->count(),
        ]);

        $notaPromedio = Resena::publicados()->avg('puntuacion');

        $porPlataforma = collect(Ttr::PLATAFORMAS)->mapWithKeys(
            fn ($p) => [$p => Resena::publicados()->where('plataforma', $p)->count()]
        );

        $misBorradores = collect()
            ->merge(Noticia::where('user_id', $request->user()->id)->where('estado', 'borrador')->get()->map(fn ($m) => ['Noticia', $m->titulo, route('admin.noticias.edit', $m)]))
            ->merge(Trailer::where('user_id', $request->user()->id)->where('estado', 'borrador')->get()->map(fn ($m) => ['Tráiler', $m->titulo, route('admin.trailers.edit', $m)]))
            ->merge(Resena::where('user_id', $request->user()->id)->where('estado', 'borrador')->get()->map(fn ($m) => ['Reseña', $m->titulo, route('admin.resenas.edit', $m)]));

        return view('admin.dashboard', [
            'contenidos' => $contenidos,
            'notaPromedio' => $notaPromedio,
            'porPlataforma' => $porPlataforma,
            'misBorradores' => $misBorradores,
            'sugerenciasPendientes' => Sugerencia::where('estado', 'pendiente')->count(),
        ]);
    }
}
