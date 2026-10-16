<?php

use App\Models\Trailer;
use App\Support\Ttr;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('trailers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->restrictOnDelete();
            $table->string('titulo', 200);
            $table->string('slug', 220)->unique();
            $table->string('videojuego', 150);
            $table->enum('plataforma', Trailer::PLATAFORMAS);
            $table->string('url_embebida'); // solo enlace externo, nunca archivo de video (RI-02)
            $table->text('descripcion')->nullable();
            $table->enum('estado', Ttr::ESTADOS)->default('borrador');
            $table->timestamps();

            $table->index(['estado', 'created_at']);
            $table->index('plataforma');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('trailers');
    }
};
