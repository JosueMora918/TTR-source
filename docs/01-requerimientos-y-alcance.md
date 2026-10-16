# 1. Alcance y requerimientos  _(secciones 6, 7 del documento)_

## 6.1 Alcance funcional / 6.2 Funcionalidades incluidas
| Módulo | Pública | Panel `/admin` |
|---|---|---|
| Noticias | Catálogo paginado, filtro por plataforma/categoría, búsqueda, lectura por slug | CRUD, imagen de portada, Borrador/Publicado |
| Tráilers | Catálogo con video embebido (iframe tras clic), detalle | CRUD, validación YouTube/Vimeo |
| Reseñas | Ficha técnica, pros/contras, nota 1.0–10.0, orden por nota | CRUD, imagen, Borrador/Publicado |
| Plataformas | `/plataformas/{plataforma?}` agrupa todo el contenido | — |
| Búsqueda | `/buscar?q=` global | Filtros por texto/estado/plataforma |
| Sugerencias | Formulario público | Bandeja: marcar revisada / eliminar |
| Usuarios | — | Alta, edición, rol, eliminación protegida (solo admin) |
| Seguridad | — | Login/logout, recuperación y cambio de contraseña, roles |

**Fuera de alcance:** pagos, comentarios, app móvil nativa, alojar video propio.

## 7.1 Requerimientos funcionales
| ID | Estado | Implementación |
|---|---|---|
| RF-01 Portada modular | ✅ | `HomeController` + `home.blade.php` (cache 10 min) |
| RF-02 Lectura de noticias | ✅ | `NoticiaController@show`, `noticias/show` |
| RF-03 Trailers embebidos | ✅ | `x-tarjeta-trailer`, `trailers/show`, `Trailer::iframe_url` |
| RF-04 Reseña estructurada | ✅ | `resenas/show` (ficha, pros, contras, veredicto, nota) |
| RF-05 Búsqueda y filtros | ✅ | `partials/filtros`, scopes `buscar`, `dePlataforma` |
| RF-06 Autenticación admin | ✅ | `Auth\LoginController`, middleware `auth` |
| RF-07 CRUD noticias + imagen ≤5 MB + slug | ✅ | `Admin\NoticiaController`, `ImagenService` |
| RF-08 CRUD trailers | ✅ | `Admin\TrailerController` |
| RF-09 CRUD reseñas con decimal | ✅ | `Admin\ResenaController`, `ResenaRequest` |
| RF-10 Borrador/Publicado | ✅ | `cambiarEstado` + scope `publicados` |

## 7.2 Requerimientos no funcionales
| ID | Cómo se cumple | Cómo se verifica |
|---|---|---|
| RNF-01 LCP < 2.5 s | CSS único sin framework, JS mínimo, video bajo demanda, imágenes WebP ≤1600 px, caché de portada | Lighthouse móvil en la portada |
| RNF-02 100 concurrentes | Consultas indexadas, caché, sin video propio | Prueba de carga (ej. `ab -n 500 -c 100`) |
| RNF-03 CSRF + hashing | `@csrf` en todos los POST, cast `hashed` (Bcrypt) | `TtrTest`, columna `password` en BD |
| RNF-04 Sin video local | Solo enlaces YouTube/Vimeo validados por regex | `test_trailer_solo_acepta_youtube_o_vimeo` |
| RNF-05 Imagen ≤5 MB | Regla `max:5120` + `ImagenService` | Subir archivo >5 MB |
| RNF-06 Responsive + oscuro | `ttr.css` con 3 breakpoints, tema claro/oscuro | DevTools modo móvil |
| RNF-07 Slugs limpios | Trait `EsContenidoEditorial` | URLs `/resenas/nebula-rift` |
| RNF-08 Logging | `Log::*` + listener `RegistrarCambioEditorial` | `storage/logs/laravel.log` |

## 7.3 Historias de usuario y 7.4 criterios de aceptación
| Historia | Criterios de aceptación |
|---|---|
| Como **lector** quiero filtrar reseñas por plataforma para ver solo mis juegos | `/resenas?plataforma=PC` lista solo reseñas de PC publicadas; si no hay, muestra mensaje vacío |
| Como **lector** quiero ver el tráiler sin salir del sitio | Al pulsar play se crea el iframe; no se descarga video del servidor TTR |
| Como **lector** quiero sugerir un juego | Con datos válidos: guarda, muestra mensaje de éxito y redirige. Con datos inválidos: muestra errores y conserva lo escrito |
| Como **editor** quiero guardar un borrador de reseña | Se crea con estado `borrador`; no aparece en el sitio público (404 por URL directa) |
| Como **editor** quiero que mi nota sea válida | Rechaza <1, >10 y más de un decimal con mensaje claro |
| Como **editor** no debo modificar contenido ajeno | Editar/eliminar contenido de otro devuelve 403 |
| Como **admin** quiero gestionar cuentas | Crear/editar rol; no puede eliminarse a sí mismo ni a quien tenga contenido |
| Como **usuario** olvidé mi contraseña | Se genera enlace con token; al usarlo puedo definir una nueva; mensaje neutro para no revelar correos |
