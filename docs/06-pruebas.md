# 6. Pruebas  _(secciones 18.3 y 18.4)_

## Automatizadas — `php artisan test`
15 pruebas en `tests/Feature/TtrTest.php`: páginas públicas, borrador→404, redirección de invitados, login válido/inválido, hash de contraseña, 403 por rol, validación de nota (1–10, un decimal), creación con slug y redirect, edición ajena prohibida, conmutador de estado, restricción YouTube/Vimeo, integridad al borrar usuarios, formulario de sugerencias y API solo publicados.

## Manuales (llenar con fecha, resultado y captura)
| # | Caso | Datos | Resultado esperado | ✔/✖ |
|---|---|---|---|---|
| M1 | Portada carga | `/` | Hero, reseñas, noticias y tráilers | |
| M2 | Filtro por plataforma | `/resenas?plataforma=Xbox` | Solo Xbox | |
| M3 | Búsqueda sin resultados | `/buscar?q=zzzz` | Mensaje vacío | |
| M4 | Búsqueda 1 letra | `/buscar?q=a` | Error de validación | |
| M5 | Sugerencia válida | datos completos | Éxito + redirect | |
| M6 | Sugerencia vacía | campos vacíos | Errores por campo, valores conservados | |
| M7 | Login correcto | admin | Entra al panel | |
| M8 | Login incorrecto | clave errónea | Mensaje, sin sesión | |
| M9 | Admin sin sesión | `/admin` | Redirige a `/acceso` | |
| M10 | Editor → `/admin/usuarios` | URL directa | 403 | |
| M11 | Editor edita reseña ajena | URL directa | 403 | |
| M12 | Reseña nota 0 / 11 / 8.55 / texto | formulario | Error de validación | |
| M13 | Reseña válida con imagen 2 MB | formulario | Guardada, WebP en `storage` | |
| M14 | Imagen > 5 MB | archivo | Error "no puede pesar más de 5 MB" | |
| M15 | Tráiler con URL no permitida | `https://x.com/a.mp4` | Error | |
| M16 | Publicar / pasar a borrador | botón | Estado cambia; borrador da 404 público | |
| M17 | Eliminar con confirmación | botón | Pregunta y elimina | |
| M18 | Eliminar usuario con contenido | admin | Bloqueado con mensaje | |
| M19 | Recuperar contraseña | correo | Enlace en `laravel.log`; restablece | |
| M20 | Cambiar contraseña | formulario | Éxito; hash cambia en BD | |
| M21 | Token CSRF ausente | quitar `_token` (DevTools) | Página 419 | |
| M22 | Móvil 375 px | DevTools | Menú colapsable, sin scroll horizontal | |
| M23 | Tema oscuro/claro | botón | Persiste al recargar | |
| M24 | Lighthouse móvil | portada | LCP < 2.5 s | |

## Evidencias a capturar
Rutas (`php artisan route:list`), controladores, middleware (403 en pantalla y en el log), formularios, errores de validación, mensajes flash, layout Blade, navegación, hash en BD, usuarios por rol, `php artisan migrate:fresh --seed`, tablas, CRUD, `laravel.log`, Postman, `php artisan test`.

## Registro de errores y correcciones
| Fecha | Error encontrado | Corrección |
|---|---|---|
| | | |
