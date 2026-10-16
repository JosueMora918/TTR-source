<?php

namespace Database\Factories;

use App\Models\Trailer;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class TrailerFactory extends Factory
{
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'titulo' => 'Tráiler: '.fake()->words(3, true),
            'videojuego' => fake()->words(2, true),
            'plataforma' => fake()->randomElement(Trailer::PLATAFORMAS),
            // Reemplaza este enlace por un tráiler real desde el panel /admin/trailers.
            'url_embebida' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ',
            'descripcion' => fake()->sentence(12),
            'estado' => 'publicado',
        ];
    }

    public function borrador(): static
    {
        return $this->state(fn () => ['estado' => 'borrador']);
    }
}
