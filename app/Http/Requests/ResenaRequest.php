<?php

namespace App\Http\Requests;

use App\Support\Ttr;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ResenaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'titulo' => strip_tags((string) $this->titulo),
            'videojuego' => strip_tags((string) $this->videojuego),
            'desarrollador' => strip_tags((string) $this->desarrollador),
            'genero' => strip_tags((string) $this->genero),
        ]);
    }

    public function rules(): array
    {
        return [
            'titulo' => ['required', 'string', 'min:5', 'max:200'],
            'videojuego' => ['required', 'string', 'max:150'],
            'desarrollador' => ['required', 'string', 'max:120'],
            'genero' => ['required', 'string', 'max:80'],
            'plataforma' => ['required', Rule::in(Ttr::PLATAFORMAS)],
            // Escala decimal estricta 1.0 a 10.0 con un solo decimal (RF-09).
            'puntuacion' => ['required', 'numeric', 'between:1,10', 'decimal:0,1'],
            'pros' => ['required', 'string', 'min:3'],
            'contras' => ['required', 'string', 'min:3'],
            'veredicto' => ['required', 'string', 'min:20'],
            'estado' => ['required', Rule::in(Ttr::ESTADOS)],
            'imagen' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
        ];
    }
}
