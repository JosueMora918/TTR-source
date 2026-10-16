<?php

namespace Database\Seeders;

use App\Models\Noticia;
use App\Models\Resena;
use App\Models\Trailer;
use App\Models\User;
use Illuminate\Database\Seeder;

/**
 * Datos de prueba. Los videojuegos y estudios son FICTICIOS.
 * Los enlaces de video son de ejemplo: cámbialos desde el panel por tráilers reales.
 */
class ContenidoSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::where('rol', 'admin')->first();
        $editor = User::where('email', 'editor@ttr.test')->first() ?? $admin;

        $resenas = [
            ['Nébula Rift', 'Void Horizon Studios', 'RPG de ciencia ficción', 'PC', 8.7, $admin,
                "Narrativa profunda\nDirección de arte memorable\nExcelente rendimiento en PC",
                "Curva de aprendizaje pronunciada\nErrores menores de interfaz",
                "Nébula Rift apuesta por una galaxia llena de decisiones con peso y lo cumple casi siempre.\n\nLa exploración y la historia se refuerzan entre sí, y el apartado técnico en PC es sólido incluso en equipos modestos. Le falta pulir la interfaz de inventario, pero es un RPG que se recuerda."],
            ['Sombras de Kaelen', 'Grimforge Interactive', 'Acción y sigilo', 'PlayStation', 7.2, $editor,
                "Sistema de sigilo sólido\nBuena respuesta del control",
                "Historia predecible\nPoca variedad de enemigos",
                "Cumple como juego de sigilo y se disfruta durante las primeras diez horas.\n\nDespués se vuelve repetitivo y la trama no sorprende. Una compra recomendable en oferta."],
            ['Aurora Tácticos', 'Polar Bit', 'Estrategia por turnos', 'Nintendo', 9.1, $admin,
                "Sistema de combate profundo\nInterfaz clara en modo portátil\nRejugabilidad enorme",
                "Tutorial demasiado largo",
                "Una joya de la estrategia por turnos que aprovecha muy bien la consola híbrida.\n\nCada misión plantea decisiones interesantes y las campañas cortas invitan a repetir. Es de lo mejor del año en su género."],
            ['Carrera Meridiana', 'Eje Motorsport', 'Carreras arcade', 'Xbox', 6.4, $editor,
                "Sensación de velocidad\nGran selección musical",
                "Pocos circuitos\nIA de rivales inconsistente",
                "Es divertido en sesiones cortas, pero el contenido escasea.\n\nLa conducción es disfrutable y visualmente luce muy bien, aunque la variedad de pistas se agota pronto."],
            ['Bosque de Cristal', 'Lumen Tales', 'Aventura narrativa', 'PC', 8.0, $admin,
                "Banda sonora excelente\nPersonajes carismáticos",
                "Duración corta\nPuzzles poco desafiantes",
                "Una aventura breve y emotiva que prioriza la atmósfera sobre el reto.\n\nSu mayor virtud son los personajes y la música; su mayor defecto, que termina cuando mejor está."],
            ['Último Circuito', 'Neon Foundry', 'Plataformas 2D', 'Nintendo', 5.8, $editor,
                "Estética retro bien lograda",
                "Dificultad mal balanceada\nControles imprecisos en saltos largos",
                "Tiene personalidad, pero tropieza en lo más importante: el control.\n\nLa estética retro funciona y hay buenas ideas, aunque los picos de dificultad frustran más de lo que retan."],
        ];

        foreach ($resenas as [$juego, $dev, $genero, $plat, $nota, $autor, $pros, $contras, $veredicto]) {
            Resena::create([
                'user_id' => $autor->id,
                'titulo' => "Análisis de {$juego}",
                'videojuego' => $juego,
                'desarrollador' => $dev,
                'genero' => $genero,
                'plataforma' => $plat,
                'puntuacion' => $nota,
                'pros' => $pros,
                'contras' => $contras,
                'veredicto' => $veredicto,
                'estado' => 'publicado',
            ]);
        }

        Resena::create([
            'user_id' => $editor->id,
            'titulo' => 'Análisis de Cumbre Hueca (borrador)',
            'videojuego' => 'Cumbre Hueca',
            'desarrollador' => 'Alto Norte Games',
            'genero' => 'Supervivencia',
            'plataforma' => 'PlayStation',
            'puntuacion' => 7.5,
            'pros' => 'Ambientación muy lograda',
            'contras' => 'Pendiente de completar',
            'veredicto' => 'Borrador pendiente de revisión: este contenido no es visible para el público.',
            'estado' => 'borrador',
        ]);

        $noticias = [
            ['Nuevo tráiler de la expansión de Elysium Chronicles', 'Lanzamientos', 'PC', 'El estudio reveló la primera vista de la próxima expansión narrativa.', $admin],
            ['Mejoras de rendimiento en consolas tras la última actualización', 'Industria', 'PlayStation', 'Se corrigieron los problemas de frame pacing reportados por la comunidad.', $editor],
            ['Se anuncia una nueva consola portátil de última generación', 'Hardware', 'Nintendo', 'La compañía promete hasta 8 horas de batería en juegos exigentes.', $admin],
            ['Fecha de estreno confirmada para Aurora Tácticos en consolas', 'Lanzamientos', 'Nintendo', 'El título llegará con una edición física limitada.', $editor],
            ['Los estudios independientes lideran las nominaciones del año', 'Industria', null, 'Cinco de las siete nominaciones principales son producciones de equipos pequeños.', $admin],
            ['Pruebas de latencia en servicios de juego en la nube', 'Hardware', 'Xbox', 'Un análisis compara tres servicios con conexión doméstica promedio.', $editor],
        ];

        foreach ($noticias as [$titulo, $cat, $plat, $resumen, $autor]) {
            Noticia::create([
                'user_id' => $autor->id,
                'titulo' => $titulo,
                'resumen' => $resumen,
                'contenido' => $resumen."\n\nEsta nota de ejemplo se generó con datos de prueba para validar el diseño de la plataforma TTR. Reemplázala por contenido editorial real desde el panel de administración.\n\nLos detalles completos se ampliarán conforme el estudio publique más información oficial.",
                'categoria' => $cat,
                'plataforma' => $plat,
                'estado' => 'publicado',
            ]);
        }

        // Volumen extra para demostrar la paginación.
        Noticia::factory()->count(12)->create(['user_id' => $editor->id]);

        $trailers = [
            ['Elysium Chronicles — Tráiler de la expansión', 'Elysium Chronicles', 'PC', $admin],
            ['Nébula Rift — Teaser de lanzamiento', 'Nébula Rift', 'PC', $editor],
            ['Sombras de Kaelen — Tráiler de jugabilidad', 'Sombras de Kaelen', 'PlayStation', $admin],
            ['Aurora Tácticos — Presentación de campañas', 'Aurora Tácticos', 'Nintendo', $editor],
            ['Carrera Meridiana — Tráiler de anuncio', 'Carrera Meridiana', 'Xbox', $admin],
            ['Bosque de Cristal — Teaser', 'Bosque de Cristal', 'Multi', $editor],
        ];

        foreach ($trailers as [$titulo, $juego, $plat, $autor]) {
            Trailer::create([
                'user_id' => $autor->id,
                'titulo' => $titulo,
                'videojuego' => $juego,
                'plataforma' => $plat,
                'url_embebida' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ',
                'descripcion' => "Avance oficial de {$juego}. Enlace de ejemplo: reemplázalo desde el panel.",
                'estado' => 'publicado',
            ]);
        }
    }
}
