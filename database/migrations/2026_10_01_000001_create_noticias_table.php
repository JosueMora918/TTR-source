<?php

use App\Support\Ttr;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('noticias', function (Blueprint $table) {
            $table->id();
            // Integridad referencial: no se puede borrar un usuario que tenga noticias.
            $table->foreignId('user_id')->constrained('users')->restrictOnDelete();
            $table->string('titulo', 200);
            $table->string('slug', 220)->unique();
            $table->string('resumen', 300)->nullable();
            $table->longText('contenido');
            $table->string('imagen_portada')->nullable();
            $table->string('categoria', 50);
            $table->enum('plataforma', Ttr::PLATAFORMAS)->nullable();
            $table->enum('estado', Ttr::ESTADOS)->default('borrador');
            $table->timestamps();

            $table->index(['estado', 'created_at']);
            $table->index('plataforma');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('noticias');
    }
};
