<?php

namespace Tests\Feature;

use App\Models\Noticia;
use App\Models\Resena;
use App\Models\Trailer;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * Pruebas de las Actividades 5-8: rutas públicas, middleware, roles,
 * validaciones, integridad y API. Ejecutar con:  php artisan test
 */
class TtrTest extends TestCase
{
    use RefreshDatabase;

    private function usuario(string $rol = 'editor'): User
    {
        return User::factory()->create(['rol' => $rol]);
    }

    private function datosResena(array $extra = []): array
    {
        return array_merge([
            'titulo' => 'Análisis de Prueba',
            'videojuego' => 'Prueba',
            'desarrollador' => 'Estudio Demo',
            'genero' => 'RPG',
            'plataforma' => 'PC',
            'puntuacion' => '8.5',
            'pros' => 'Buen arte',
            'contras' => 'Algunos errores',
            'veredicto' => 'Un veredicto con más de veinte caracteres.',
            'estado' => 'borrador',
        ], $extra);
    }

    public function test_portada_y_catalogos_publicos_cargan(): void
    {
        $this->get('/')->assertOk();
        $this->get('/noticias')->assertOk();
        $this->get('/trailers')->assertOk();
        $this->get('/resenas')->assertOk();
        $this->get('/plataformas')->assertOk();
        $this->get('/plataformas/pc')->assertOk();
        $this->get('/buscar?q=zelda')->assertOk();
        $this->get('/sugerencias/crear')->assertOk();
    }

    public function test_publicado_es_visible_y_borrador_da_404(): void
    {
        $publicada = Resena::factory()->create(['estado' => 'publicado']);
        $borrador = Resena::factory()->create(['estado' => 'borrador']);

        $this->get(route('resenas.show', $publicada->slug))->assertOk()->assertSee($publicada->videojuego);
        $this->get(route('resenas.show', $borrador->slug))->assertNotFound();
    }

    public function test_plataforma_invalida_da_404(): void
    {
        $this->get('/plataformas/atari')->assertNotFound();
    }

    public function test_invitado_es_redirigido_al_login_en_admin(): void
    {
        $this->get('/admin')->assertRedirect(route('login'));
        $this->get('/admin/resenas/crear')->assertRedirect(route('login'));
    }

    public function test_login_correcto_e_incorrecto(): void
    {
        User::factory()->create(['email' => 'a@ttr.test', 'password' => 'Secreto123', 'rol' => 'editor']);

        $this->post('/acceso', ['email' => 'a@ttr.test', 'password' => 'mal'])
            ->assertSessionHasErrors('email');
        $this->assertGuest();

        $this->post('/acceso', ['email' => 'a@ttr.test', 'password' => 'Secreto123'])
            ->assertRedirect(route('admin.dashboard'));
        $this->assertAuthenticated();
    }

    public function test_password_se_guarda_con_hash(): void
    {
        $u = User::factory()->create(['password' => 'Secreto123']);

        $this->assertNotSame('Secreto123', $u->password);
        $this->assertTrue(password_verify('Secreto123', $u->password));
    }

    public function test_editor_no_accede_a_usuarios_pero_admin_si(): void
    {
        $this->actingAs($this->usuario('editor'))->get(route('admin.usuarios.index'))->assertForbidden();
        $this->actingAs($this->usuario('admin'))->get(route('admin.usuarios.index'))->assertOk();
    }

    public function test_validacion_de_puntuacion_fuera_de_rango_y_con_dos_decimales(): void
    {
        $editor = $this->usuario();

        $this->actingAs($editor)->post(route('admin.resenas.store'), $this->datosResena(['puntuacion' => '11']))
            ->assertSessionHasErrors('puntuacion');

        $this->actingAs($editor)->post(route('admin.resenas.store'), $this->datosResena(['puntuacion' => '8.55']))
            ->assertSessionHasErrors('puntuacion');

        $this->assertDatabaseCount('resenas', 0);
    }

    public function test_editor_crea_resena_con_slug_y_redirige_con_mensaje(): void
    {
        $editor = $this->usuario();

        $this->actingAs($editor)->post(route('admin.resenas.store'), $this->datosResena())
            ->assertRedirect(route('admin.resenas.index'))
            ->assertSessionHas('exito');

        $this->assertDatabaseHas('resenas', ['slug' => 'analisis-de-prueba', 'user_id' => $editor->id]);
    }

    public function test_editor_no_edita_ni_borra_contenido_ajeno(): void
    {
        $ajena = Resena::factory()->create();
        $editor = $this->usuario();

        $this->actingAs($editor)->get(route('admin.resenas.edit', $ajena))->assertForbidden();
        $this->actingAs($editor)->delete(route('admin.resenas.destroy', $ajena))->assertForbidden();
        $this->assertDatabaseHas('resenas', ['id' => $ajena->id]);

        $this->actingAs($this->usuario('admin'))->delete(route('admin.resenas.destroy', $ajena))
            ->assertRedirect(route('admin.resenas.index'));
        $this->assertDatabaseMissing('resenas', ['id' => $ajena->id]);
    }

    public function test_conmutador_borrador_publicado(): void
    {
        $editor = $this->usuario();
        $noticia = Noticia::factory()->borrador()->create(['user_id' => $editor->id]);

        $this->actingAs($editor)->patch(route('admin.noticias.estado', $noticia))->assertSessionHas('exito');
        $this->assertSame('publicado', $noticia->fresh()->estado);
    }

    public function test_trailer_solo_acepta_youtube_o_vimeo(): void
    {
        $editor = $this->usuario();
        $base = [
            'titulo' => 'Tráiler de prueba', 'videojuego' => 'Prueba', 'plataforma' => 'PC',
            'estado' => 'borrador',
        ];

        $this->actingAs($editor)->post(route('admin.trailers.store'), $base + ['url_embebida' => 'https://sitio-malo.com/video.mp4'])
            ->assertSessionHasErrors('url_embebida');

        $this->actingAs($editor)->post(route('admin.trailers.store'), $base + ['url_embebida' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ'])
            ->assertRedirect(route('admin.trailers.index'));

        $this->assertSame('https://www.youtube-nocookie.com/embed/dQw4w9WgXcQ', Trailer::first()->iframe_url);
    }

    public function test_no_se_elimina_usuario_con_contenido(): void
    {
        $admin = $this->usuario('admin');
        $autor = $this->usuario('editor');
        Noticia::factory()->create(['user_id' => $autor->id]);

        $this->actingAs($admin)->delete(route('admin.usuarios.destroy', $autor))->assertSessionHas('error');
        $this->assertDatabaseHas('users', ['id' => $autor->id]);
    }

    public function test_sugerencia_publica_se_valida_y_guarda(): void
    {
        $this->post('/sugerencias', [])->assertSessionHasErrors(['nombre', 'email', 'titulo_juego', 'plataforma']);

        $this->post('/sugerencias', [
            'nombre' => 'Lector', 'email' => 'l@correo.test', 'titulo_juego' => 'Juego X', 'plataforma' => 'Xbox',
        ])->assertRedirect(route('sugerencias.create'))->assertSessionHas('exito');

        $this->assertDatabaseHas('sugerencias', ['titulo_juego' => 'Juego X', 'estado' => 'pendiente']);
    }

    public function test_api_expone_solo_contenido_publicado(): void
    {
        $pub = Resena::factory()->create(['estado' => 'publicado']);
        $bor = Resena::factory()->create(['estado' => 'borrador']);

        $this->getJson('/api/v1/resenas')->assertOk()->assertJsonCount(1, 'data');
        $this->getJson('/api/v1/resenas/'.$pub->slug)->assertOk()->assertJsonPath('data.slug', $pub->slug);
        $this->getJson('/api/v1/resenas/'.$bor->slug)->assertNotFound();
    }
}
