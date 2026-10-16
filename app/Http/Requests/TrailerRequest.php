<?php

namespace App\Http\Requests;

use App\Models\Trailer;
use App\Support\Ttr;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class TrailerRequest extends FormRequest
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
            'url_embebida' => trim((string) $this->url_embebida),
        ]);
    }

    public function rules(): array
    {
        return [
            'titulo' => ['required', 'string', 'min:5', 'max:200'],
            'videojuego' => ['required', 'string', 'max:150'],
            'plataforma' => ['required', Rule::in(Trailer::PLATAFORMAS)],
            // Solo proveedores externos de video (RI-02): YouTube o Vimeo.
            'url_embebida' => [
                'required', 'url', 'max:255',
                'regex:#^https?://((www|m)\.)?(youtube\.com|youtu\.be|youtube-nocookie\.com|vimeo\.com|player\.vimeo\.com)/#i',
            ],
            'descripcion' => ['nullable', 'string', 'max:1000'],
            'estado' => ['required', Rule::in(Ttr::ESTADOS)],
        ];
    }
}
