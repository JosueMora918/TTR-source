<?php

namespace App\Http\Requests;

use App\Support\Ttr;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class NoticiaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // El acceso se controla con middleware y Policies.
    }

    protected function prepareForValidation(): void
    {
        // Sanitización básica de campos de una sola línea.
        $this->merge([
            'titulo' => strip_tags((string) $this->titulo),
            'resumen' => strip_tags((string) $this->resumen) ?: null,
            'plataforma' => $this->plataforma ?: null,
        ]);
    }

    public function rules(): array
    {
        return [
            'titulo' => ['required', 'string', 'min:5', 'max:200'],
            'resumen' => ['nullable', 'string', 'max:300'],
            'contenido' => ['required', 'string', 'min:50'],
            'categoria' => ['required', Rule::in(Ttr::CATEGORIAS)],
            'plataforma' => ['nullable', Rule::in(Ttr::PLATAFORMAS)],
            'estado' => ['required', Rule::in(Ttr::ESTADOS)],
            'imagen' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120'], // 5 MB (RNF-05)
        ];
    }
}
