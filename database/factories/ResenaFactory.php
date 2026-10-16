<?php

namespace Database\Factories;

use App\Models\User;
use App\Support\Ttr;
use Illuminate\Database\Eloquent\Factories\Factory;

class ResenaFactory extends Factory
{
    public function definition(): array
    {
        $juego = ucfirst(fake()->words(2, true));

        return [
            'user_id' => User::factory(),
            'titulo' => 'Análisis de '.$juego,
            'videojuego' => $juego,
            'desarrollador' => fake()->company(),
            'genero' => fake()->randomElement(['RPG', 'Acción', 'Aventura', 'Estrategia', 'Plataformas']),
            'plataforma' => fake()->randomElement(Ttr::PLATAFORMAS),
            'puntuacion' => fake()->randomFloat(1, 4, 10),
            'pros' => "Buen apartado artístico\nControles precisos",
            'contras' => "Historia irregular\nAlgunos errores menores",
            'veredicto' => fake()->paragraph(3),
            'estado' => 'publicado',
        ];
    }

    public function borrador(): static
    {
        return $this->state(fn () => ['estado' => 'borrador']);
    }
}
