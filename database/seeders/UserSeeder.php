<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Credenciales de DEMOSTRACIÓN. En producción define TTR_ADMIN_EMAIL y
     * TTR_ADMIN_PASSWORD en el .env antes de ejecutar el seeder.
     */
    public function run(): void
    {
           User::updateOrCreate(
               ['email' => env('TTR_ADMIN_EMAIL') ?: 'admin@ttr.test'],
               ['name' => 'Josué Mora', 'password' => env('TTR_ADMIN_PASSWORD') ?: 'Admin#2026', 'rol' => 'admin']
           );

        if (! app()->environment('production')) {
            User::updateOrCreate(
                ['email' => 'editor@ttr.test'],
                ['name' => 'Ana Redactora', 'password' => 'Editor#2026', 'rol' => 'editor']
            );
        }
    }
}
