# 4. Seguridad y servicios Laravel  _(sección 13)_

## 13.1 Registro y autenticación
Los lectores no tienen cuenta. Las cuentas del equipo las crea un **administrador** en `/admin/usuarios` (decisión de diseño: un registro abierto permitiría que cualquiera publicara). Login en `/acceso` con `Auth::attempt`, `session()->regenerate()` y logout con `invalidate()` + `regenerateToken()`. Límite de 6 intentos/minuto.

## 13.2 Roles y permisos
| Capacidad | Lector | Editor | Admin |
|---|:-:|:-:|:-:|
| Ver contenido publicado | ✔ | ✔ | ✔ |
| Ver borradores (vista previa) | ✖ | ✔ | ✔ |
| Crear noticias/tráilers/reseñas | ✖ | ✔ | ✔ |
| Editar/publicar/eliminar contenido propio | ✖ | ✔ | ✔ |
| Editar/eliminar contenido ajeno | ✖ | ✖ | ✔ |
| Gestionar usuarios | ✖ | ✖ | ✔ |

## 13.3 Middleware de autorización
`rol:admin,editor` en `/admin/*` y `rol:admin` en `/admin/usuarios`. Un acceso por URL sin permiso devuelve **403** y queda en el log.

## 13.4 Policies
`ContenidoPolicy` (`update`, `delete`) registrada para Noticia, Trailer y Resena en `AppServiceProvider`; se invoca con `$this->authorize()` y `@can` en las vistas.

## 13.5 Recuperación de contraseña
`/recuperar` → `Password::sendResetLink` (Notification + Mail; en local `MAIL_MAILER=log`) → `/restablecer/{token}` → `Password::reset`. Mensaje neutro (no revela si el correo existe). Cambio autenticado en `/admin/cuenta`.

## 13.6 CSRF
`@csrf` en todos los formularios POST/PUT/PATCH/DELETE; el middleware web de Laravel responde 419 si falta (vista `errors/419`).

## 13.7 Hashing
Cast `'password' => 'hashed'` en `User` (Bcrypt). Nunca se guarda ni se registra la contraseña en claro.

## 13.8 Validación y protección de datos
FormRequests con reglas estrictas, `strip_tags` en campos de una línea, salida escapada con `{{ }}` (los párrafos se muestran con `nl2br(e())`), consultas con Eloquent (parámetros enlazados), comodines LIKE escapados, enlaces de video restringidos a YouTube/Vimeo, imágenes validadas (`image`, `mimes`, `max:5120`) y reprocesadas a WebP.

## 13.9 Consideraciones de seguridad
`APP_DEBUG=false` en producción · `.env` fuera de Git · `throttle` en login, recuperación, sugerencias y API · iframes con `referrerpolicy` y dominio `youtube-nocookie` · cabeceras HTTPS/SSL en el hosting · integridad referencial en BD.

---
# Servicios Laravel utilizados (solo los usados)

| Servicio | Dónde | Por qué se eligió |
|---|---|---|
| **Cache** | `HomeController` (`Cache::remember`, 10 min) | La portada hace 4 consultas; con caché cumple RNF-01/02 |
| **Events y Listeners** | `ContenidoModificado` → `RegistrarCambioEditorial`, `LimpiarCachePortada` | Desacopla auditoría (RNF-08) e invalidación de caché de los controladores |
| **Collections** | `Dashboard`, ficha de reseñas, `Ttr::lineas/parrafos`, conteos por plataforma | Transformar pros/contras y agregados sin SQL repetitivo |
| **File Storage** | Disco `public` + `storage:link` (portadas) | Subida segura y borrado al reemplazar/eliminar |
| **Helpers** | `App\Support\Ttr`, `Str`, `Arr`, `now()`, `route()`, `old()` | Reglas pequeñas reutilizables entre vistas y modelos |
| **Mail / Notifications** | Recuperación de contraseña (`ResetPassword`) | Envío del enlace con token |
| **Logging** | Accesos, fallos de login, cambios editoriales, errores de imagen | Trazabilidad (RNF-08) |

## Paquete adicional: `intervention/image` v3
**Justificación técnica:** RNF-05 limita las portadas a 5 MB y RNF-01 exige LCP < 2.5 s. El paquete redimensiona (máx. 1600 px) y convierte a WebP al 80 %, reduciendo típicamente 70–90 % el peso. Un fallo del procesamiento se captura, se registra y se muestra como error de validación.

## Manejo de errores en operaciones críticas
`ImagenService` (try/catch + log), `UsuarioController@destroy` (integridad), páginas `403/404/419/500` propias, y respuestas JSON para errores de `/api/*`.
