<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;
use Throwable;

/**
 * Paquete adicional (Act. 8): intervention/image.
 * Redimensiona y convierte las portadas a WebP para cumplir RNF-01 (LCP)
 * y RNF-05 (control de peso de activos).
 */
class ImagenService
{
    public function guardar(UploadedFile $archivo, string $carpeta): string
    {
        try {
            $manager = new ImageManager(new Driver());
            $imagen = $manager->read($archivo->getRealPath())->scaleDown(width: 1600);

            $ruta = trim($carpeta, '/').'/'.Str::uuid().'.webp';
            Storage::disk('public')->put($ruta, (string) $imagen->toWebp(80));

            return $ruta;
        } catch (Throwable $e) {
            Log::error('No se pudo procesar la imagen de portada.', [
                'mensaje' => $e->getMessage(),
                'archivo' => $archivo->getClientOriginalName(),
            ]);

            throw ValidationException::withMessages([
                'imagen' => __('ttr.errores.imagen'),
            ]);
        }
    }

    public function eliminar(?string $ruta): void
    {
        if ($ruta) {
            Storage::disk('public')->delete($ruta);
        }
    }
}
