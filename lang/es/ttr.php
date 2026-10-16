<?php

/*
| Textos propios de TTR (localización, español de México por defecto).
| Uso: __('ttr.nav.noticias')
*/
return [
    'marca' => 'TTR',
    'lema' => 'Trailers, Teasers and Reviews',

    'nav' => [
        'noticias' => 'Noticias',
        'trailers' => 'Tráilers',
        'resenas' => 'Reseñas',
        'plataformas' => 'Plataformas',
        'sugerir' => 'Sugerir reseña',
        'buscar' => 'Buscar',
        'panel' => 'Panel',
        'salir' => 'Salir',
        'acceso' => 'Acceso editores',
        'menu' => 'Menú',
        'tema' => 'Cambiar tema claro/oscuro',
        'saltar' => 'Saltar al contenido',
    ],

    'estado' => [
        'borrador' => 'Borrador',
        'publicado' => 'Publicado',
        'pendiente' => 'Pendiente',
        'revisada' => 'Revisada',
    ],

    'tipos' => [
        'noticia' => 'La noticia',
        'trailer' => 'El tráiler',
        'resena' => 'La reseña',
        'usuario' => 'La cuenta',
        'sugerencia' => 'La sugerencia',
    ],

    'flash' => [
        'creado' => ':tipo se guardó correctamente.',
        'actualizado' => ':tipo se actualizó correctamente.',
        'eliminado' => ':tipo se eliminó.',
        'estado_cambiado' => 'El estado ahora es «:estado».',
        'sugerencia_enviada' => '¡Gracias! Recibimos tu sugerencia de «:juego».',
        'sugerencia_revisada' => 'La sugerencia se marcó como revisada.',
    ],

    'auth' => [
        'bienvenida' => 'Hola, :nombre. Iniciaste sesión.',
        'despedida' => 'Cerraste sesión correctamente.',
        'enlace_enviado' => 'Si el correo está registrado, te enviamos un enlace para restablecer la contraseña.',
        'password_restablecida' => 'Tu contraseña se restableció. Ya puedes iniciar sesión.',
        'password_cambiada' => 'Tu contraseña se cambió correctamente.',
    ],

    'errores' => [
        'sin_permiso' => 'No tienes permiso para realizar esta acción.',
        'usuario_con_contenido' => ':nombre tiene noticias, tráilers o reseñas asociados y no puede eliminarse.',
        'auto_eliminar' => 'No puedes eliminar tu propia cuenta.',
        'auto_degradar' => 'No puedes quitarte a ti mismo el rol de administrador.',
        'imagen' => 'No se pudo procesar la imagen. Prueba con otro archivo JPG, PNG o WebP.',
    ],

    'paginacion' => [
        'anterior' => 'Anterior',
        'siguiente' => 'Siguiente',
        'pagina' => 'Página :actual de :total',
    ],
];
