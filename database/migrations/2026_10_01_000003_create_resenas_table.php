<?php

use App\Support\Ttr;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('resenas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->restrictOnDelete();
            $table->string('titulo', 200);
            $table->string('slug', 220)->unique();
            $table->string('videojuego', 150);
            $table->string('desarrollador', 120);
            $table->string('genero', 80);
            $table->enum('plataforma', Ttr::PLATAFORMAS);
            $table->decimal('puntuacion', 3, 1); // 1.0 a 10.0
            $table->text('pros');
            $table->text('contras');
            $table->text('veredicto');
            $table->string('imagen_portada')->nullable();
            $table->enum('estado', Ttr::ESTADOS)->default('borrador');
            $table->timestamps();

            $table->index(['estado', 'created_at']);
            $table->index('plataforma');
        });

        // Restricción de integridad a nivel de base de datos (MySQL 8+/MariaDB 10.2+).
        if (in_array(DB::getDriverName(), ['mysql', 'mariadb'], true)) {
            DB::statement('ALTER TABLE resenas ADD CONSTRAINT chk_resenas_puntuacion CHECK (puntuacion BETWEEN 1.0 AND 10.0)');
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('resenas');
    }
};
