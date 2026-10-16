<?php

use App\Support\Ttr;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sugerencias', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', 80);
            $table->string('email', 150);
            $table->string('titulo_juego', 120);
            $table->enum('plataforma', Ttr::PLATAFORMAS);
            $table->string('comentario', 500)->nullable();
            $table->enum('estado', ['pendiente', 'revisada'])->default('pendiente');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sugerencias');
    }
};
