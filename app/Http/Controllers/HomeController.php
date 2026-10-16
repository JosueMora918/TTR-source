<?php

namespace App\Http\Controllers;

use App\Listeners\LimpiarCachePortada;
use App\Models\Noticia;
use App\Models\Resena;
use App\Models\Trailer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class HomeController extends Controller
{
    /**
     * Portada modular (RF-01). El contenido se guarda 10 minutos en caché
     * (servicio Cache) y se invalida desde el evento ContenidoModificado.
     */
    public function index(Request $request)
    {
        Log::info('Se visitó la portada de TTR.', ['ip' => $request->ip()]);

        $portada = Cache::remember(LimpiarCachePortada::CLAVE, now()->addMinutes(10), function () {
            $resenas = Resena::publicados()->latest()->take(4)->get();
            $noticias = Noticia::publicados()->latest()->take(5)->get();

            return [
                'destacada' => $resenas->first(),
                'resenas' => $resenas->slice(1)->values(),
                'noticiaPrincipal' => $noticias->first(),
                'noticias' => $noticias->slice(1)->values(),
                'trailers' => Trailer::publicados()->latest()->take(3)->get(),
            ];
        });

        return view('home', $portada);
    }
}
