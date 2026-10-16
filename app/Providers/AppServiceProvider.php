<?php

namespace App\Providers;

use App\Models\Noticia;
use App\Models\Resena;
use App\Models\Trailer;
use App\Policies\ContenidoPolicy;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        // URLs de recursos en español: /admin/resenas/crear, /admin/resenas/1/editar
        Route::resourceVerbs([
            'create' => 'crear',
            'edit' => 'editar',
        ]);

        // Paginación propia (sin Tailwind).
        Paginator::defaultView('vendor.pagination.ttr');

        // Una sola Policy para los tres tipos de contenido editorial.
        Gate::policy(Noticia::class, ContenidoPolicy::class);
        Gate::policy(Trailer::class, ContenidoPolicy::class);
        Gate::policy(Resena::class, ContenidoPolicy::class);
    }
}
