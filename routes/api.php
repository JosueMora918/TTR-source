<?php

use App\Http\Controllers\Api\ContenidoApiController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API REST de TTR (solo lectura, contenido publicado)
|--------------------------------------------------------------------------
| Prefijo automático /api. Límite: 60 peticiones por minuto por IP.
*/
Route::prefix('v1')->name('api.')->middleware('throttle:60,1')->group(function () {
    Route::get('noticias', [ContenidoApiController::class, 'noticias'])->name('noticias.index');
    Route::get('noticias/{noticia:slug}', [ContenidoApiController::class, 'noticia'])->name('noticias.show');

    Route::get('trailers', [ContenidoApiController::class, 'trailers'])->name('trailers.index');
    Route::get('trailers/{trailer:slug}', [ContenidoApiController::class, 'trailer'])->name('trailers.show');

    Route::get('resenas', [ContenidoApiController::class, 'resenas'])->name('resenas.index');
    Route::get('resenas/{resena:slug}', [ContenidoApiController::class, 'resena'])->name('resenas.show');
});
