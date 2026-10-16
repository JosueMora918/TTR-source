<?php

namespace Database\Factories;

use App\Models\User;
use App\Support\Ttr;
use Illuminate\Database\Eloquent\Factories\Factory;

class NoticiaFactory extends Factory
{
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'titulo' => rtrim(fake()->sentence(7), '.'),
            'resumen' => fake()->sentence(14),
            'contenido' => implode("\n\n", fake()->paragraphs(4)),
            'categoria' => fake()->randomElement(Ttr::CATEGORIAS),
            'plataforma' => fake()->randomElement([...Ttr::PLATAFORMAS, null]),
            'estado' => 'publicado',
        ];
    }

    public function borrador(): static
    {
        return $this->state(fn () => ['estado' => 'borrador']);
    }
}
