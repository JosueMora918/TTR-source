<?php

use App\Http\Controllers\Admin;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\PasswordResetController;
use App\Http\Controllers\BusquedaController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\NoticiaController;
use App\Http\Controllers\PlataformaController;
use App\Http\Controllers\ResenaController;
use App\Http\Controllers\SugerenciaController;
use App\Http\Controllers\TrailerController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Rutas web de TTR (Trailers, Teasers and Reviews)
|--------------------------------------------------------------------------
| Toda la lógica vive en controladores; las rutas solo la enlazan.
| Parámetro obligatorio: {slug via binding}. Parámetro opcional: /plataformas/{plataforma?}
*/

// ---------- Zona pública ----------
Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/noticias', [NoticiaController::class, 'index'])->name('noticias.index');
Route::get('/noticias/{noticia:slug}', [NoticiaController::class, 'show'])->name('noticias.show');

Route::get('/trailers', [TrailerController::class, 'index'])->name('trailers.index');
Route::get('/trailers/{trailer:slug}', [TrailerController::class, 'show'])->name('trailers.show');

Route::get('/resenas', [ResenaController::class, 'index'])->name('resenas.index');
Route::get('/resenas/{resena:slug}', [ResenaController::class, 'show'])->name('resenas.show');

Route::get('/plataformas/{plataforma?}', [PlataformaController::class, 'show'])
    ->whereIn('plataforma', ['pc', 'playstation', 'xbox', 'nintendo'])
    ->name('plataformas.show');

Route::get('/buscar', [BusquedaController::class, 'index'])->name('busqueda');

Route::get('/sugerencias/crear', [SugerenciaController::class, 'create'])->name('sugerencias.create');
Route::post('/sugerencias', [SugerenciaController::class, 'store'])
    ->middleware('throttle:6,1')
    ->name('sugerencias.store');

// Healthcheck (Response de texto plano con cabecera manual)
Route::get('/estado', fn () => response('TTR operativo. Servicio disponible.', 200)
    ->header('Content-Type', 'text/plain'))->name('estado');

// ---------- Autenticación ----------
Route::middleware('guest')->group(function () {
    Route::get('/acceso', [LoginController::class, 'create'])->name('login');
    Route::post('/acceso', [LoginController::class, 'store'])->middleware('throttle:6,1')->name('login.store');

    Route::get('/recuperar', [PasswordResetController::class, 'solicitar'])->name('password.request');
    Route::post('/recuperar', [PasswordResetController::class, 'enviar'])->middleware('throttle:3,1')->name('password.email');
    Route::get('/restablecer/{token}', [PasswordResetController::class, 'formulario'])->name('password.reset');
    Route::post('/restablecer', [PasswordResetController::class, 'restablecer'])->name('password.update');
});

Route::post('/salir', [LoginController::class, 'destroy'])->middleware('auth')->name('logout');

// ---------- Panel editorial /admin/* (admin y editor) ----------
Route::prefix('admin')
    ->name('admin.')
    ->middleware(['auth', 'rol:admin,editor'])
    ->group(function () {
        Route::get('/', [Admin\DashboardController::class, 'index'])->name('dashboard');

        Route::resource('noticias', Admin\NoticiaController::class)->except('show');
        Route::patch('noticias/{noticia}/estado', [Admin\NoticiaController::class, 'cambiarEstado'])->name('noticias.estado');

        Route::resource('trailers', Admin\TrailerController::class)->except('show');
        Route::patch('trailers/{trailer}/estado', [Admin\TrailerController::class, 'cambiarEstado'])->name('trailers.estado');

        Route::resource('resenas', Admin\ResenaController::class)->except('show');
        Route::patch('resenas/{resena}/estado', [Admin\ResenaController::class, 'cambiarEstado'])->name('resenas.estado');

        Route::get('sugerencias', [Admin\SugerenciaController::class, 'index'])->name('sugerencias.index');
        Route::patch('sugerencias/{sugerencia}/revisar', [Admin\SugerenciaController::class, 'revisar'])->name('sugerencias.revisar');
        Route::delete('sugerencias/{sugerencia}', [Admin\SugerenciaController::class, 'destroy'])->name('sugerencias.destroy');

        Route::get('cuenta', [Admin\CuentaController::class, 'edit'])->name('cuenta.edit');
        Route::put('cuenta/password', [Admin\CuentaController::class, 'actualizarPassword'])->name('cuenta.password');

        // Solo administradores: gestión de cuentas y roles.
        Route::middleware('rol:admin')->group(function () {
            Route::resource('usuarios', Admin\UsuarioController::class)->except('show');
        });
    });

// Cualquier otra URL → 404 con la plantilla del sitio (dentro del grupo web, con sesión).
Route::fallback(fn () => abort(404));
