<?php

namespace App\Http\Requests;

use App\Support\Ttr;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SugerenciaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // Formulario público: cualquier lector puede sugerir.
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'nombre' => strip_tags((string) $this->nombre),
            'titulo_juego' => strip_tags((string) $this->titulo_juego),
            'comentario' => strip_tags((string) $this->comentario) ?: null,
        ]);
    }

    public function rules(): array
    {
        return [
            'nombre' => ['required', 'string', 'max:80'],
            'email' => ['required', 'email', 'max:150'],
            'titulo_juego' => ['required', 'string', 'max:120'],
            'plataforma' => ['required', Rule::in(Ttr::PLATAFORMAS)],
            'comentario' => ['nullable', 'string', 'max:500'],
        ];
    }

    public function messages(): array
    {
        return [
            'nombre.required' => 'Indica tu nombre para que sepamos quién sugiere.',
            'email.required' => 'Necesitamos un correo por si hay que contactarte.',
            'titulo_juego.required' => 'Escribe el título del videojuego que quieres ver reseñado.',
            'plataforma.required' => 'Selecciona una plataforma.',
        ];
    }
}
