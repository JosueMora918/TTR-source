<?php

namespace App\Support;

use Illuminate\Support\Collection;

/**
 * Helpers de dominio de TTR (Act. 7: "Helpers").
 * Centraliza reglas pequeñas que usan modelos, vistas y controladores.
 */
final class Ttr
{
    public const PLATAFORMAS = ['PC', 'PlayStation', 'Xbox', 'Nintendo'];

    public const CATEGORIAS = ['Lanzamientos', 'Industria', 'Hardware', 'Eventos'];

    public const ESTADOS = ['borrador', 'publicado'];

    /** Clase CSS que asigna el color de cada plataforma. */
    public static function claseDePlataforma(?string $plataforma): string
    {
        return 'plat-'.strtolower($plataforma ?: 'multi');
    }

    /** Clase CSS según el rango de la nota decimal (1.0 a 10.0). */
    public static function claseNota(float|string|null $nota): string
    {
        $nota = (float) $nota;

        return match (true) {
            $nota >= 9 => 'nota--top',
            $nota >= 7 => 'nota--buena',
            $nota >= 5 => 'nota--media',
            default => 'nota--baja',
        };
    }

    /** Convierte el slug de la URL (pc, playstation...) en el nombre de la plataforma. */
    public static function plataformaDesdeSlug(?string $slug): ?string
    {
        return collect(self::PLATAFORMAS)->first(fn ($p) => strtolower($p) === strtolower((string) $slug));
    }

    /** Texto en párrafos (separados por línea en blanco). */
    public static function parrafos(?string $texto): Collection
    {
        return collect(preg_split('/\R{2,}/', trim((string) $texto)))->map('trim')->filter()->values();
    }

    /** Texto en líneas (un punto por renglón), usado en pros y contras. */
    public static function lineas(?string $texto): Collection
    {
        return collect(preg_split('/\R/', (string) $texto))->map('trim')->filter()->values();
    }

    /** Escapa los comodines de LIKE para que la búsqueda sea literal. */
    public static function comodin(string $termino): string
    {
        return '%'.addcslashes($termino, '%_\\').'%';
    }
}
