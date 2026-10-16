<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sugerencia extends Model
{
    protected $table = 'sugerencias';

    protected $fillable = ['nombre', 'email', 'titulo_juego', 'plataforma', 'comentario', 'estado'];
}
