# 2. Arquitectura, rutas y controladores  _(secciones 9 y 11)_

## 9.1–9.2 Arquitectura y MVC
```
Petición HTTP → Middleware (web: sesión, CSRF · auth · rol) → Ruta nombrada
   → Controlador → (FormRequest valida) → Modelo Eloquent ⇄ MySQL
   → Vista Blade (layout + parciales + componentes) → Respuesta / Redirect con flash
                         └→ Event ContenidoModificado → Listeners (log, caché)
```
| Capa | Archivos |
|---|---|
| Modelo | `app/Models/*` + trait `EsContenidoEditorial` |
| Vista | `resources/views/**` (layouts, partials, components) |
| Controlador | `app/Http/Controllers/**` |
| Servicios | `ImagenService`, `Support/Ttr`, Events/Listeners |

## 9.4 Flujo funcional (alta de reseña)
1. Editor autenticado abre `/admin/resenas/crear` (middleware `auth` + `rol:admin,editor`).
2. Envía el formulario con `@csrf` → `ResenaRequest` valida (si falla: vuelve con errores y `old()`).
3. `Admin\ResenaController@store` procesa imagen (Intervention), crea el registro (slug automático).
4. Dispara `ContenidoModificado` → log con IP + invalida caché de portada.
5. `redirect()->route('admin.resenas.index')->with('exito', …)`.

## 9.5 Diseño de navegación
- **Encabezado fijo:** Noticias · Tráilers · Reseñas · Plataformas · Sugerir reseña · búsqueda global · tema · acceso/panel.
- **Migas de pan** en todas las páginas internas, **filtros** consistentes, tarjetas enlazan a detalle y “relacionados” cierran cada detalle.
- **Panel:** menú lateral (en móvil se vuelve barra horizontal) con Resumen, Noticias, Tráilers, Reseñas, Sugerencias, Usuarios (solo admin), Mi cuenta.

## 11.2 Rutas (extracto; lista completa con `php artisan route:list`)
| Método | URI | Nombre | Controlador | Protección |
|---|---|---|---|---|
| GET | `/` | home | HomeController@index | — |
| GET | `/noticias` · `/noticias/{noticia:slug}` | noticias.index/show | NoticiaController | — |
| GET | `/trailers` · `/trailers/{trailer:slug}` | trailers.index/show | TrailerController | — |
| GET | `/resenas` · `/resenas/{resena:slug}` | resenas.index/show | ResenaController | — |
| GET | `/plataformas/{plataforma?}` | plataformas.show | PlataformaController@show | **param. opcional** |
| GET | `/buscar` | busqueda | BusquedaController@index | — |
| GET/POST | `/sugerencias/crear` · `/sugerencias` | sugerencias.create/store | SugerenciaController | throttle 6/min |
| GET/POST | `/acceso` | login / login.store | Auth\LoginController | guest, throttle |
| POST | `/salir` | logout | Auth\LoginController@destroy | auth |
| GET/POST | `/recuperar`, `/restablecer/{token}`, `/restablecer` | password.* | Auth\PasswordResetController | guest |
| * | `/admin` … `/admin/{noticias,trailers,resenas}` (resource en español: `crear`, `editar`) | admin.* | Admin\* | `auth` + `rol:admin,editor` |
| PATCH | `/admin/{recurso}/{id}/estado` | admin.*.estado | Admin\* @cambiarEstado | + Policy |
| * | `/admin/usuarios` | admin.usuarios.* | Admin\UsuarioController | `rol:admin` |
| GET | `/api/v1/…` | api.* | Api\ContenidoApiController | throttle 60/min |

Redirecciones tras cada operación (POST/PUT/PATCH/DELETE) → siempre `redirect()` con mensaje flash.

## 11.3 Controladores
Públicos: `Home`, `Noticia`, `Trailer`, `Resena`, `Plataforma`, `Busqueda`, `Sugerencia`. Auth: `Login`, `PasswordReset`. Admin: `Dashboard`, `Noticia`, `Trailer`, `Resena`, `Sugerencia`, `Usuario`, `Cuenta`. API: `ContenidoApi`.
La lógica que antes estaba en las rutas (datos de ejemplo, validaciones) se movió a controladores, modelos y FormRequests.

## 11.4 Modelos
`User`, `Noticia`, `Trailer`, `Resena`, `Sugerencia`. Relaciones: `User hasMany Noticia|Trailer|Resena`; cada contenido `belongsTo User` (`autor`). Scopes: `publicados`, `dePlataforma`, `conEstado`, `buscar`.

## 11.5 Vistas y plantillas Blade
`layouts/app` (base) → `layouts/admin` (extiende app). `@yield/@section/@extends`, `@include` de parciales (`encabezado`, `pie`, `mensajes`, `migas`, `filtros`, `admin-menu`) y componentes `<x-nota>`, `<x-plataforma>`, `<x-portada>`, `<x-estado>`, `<x-campo>`, `<x-tarjeta-*>`.

## 11.6–11.8 Formularios, validación, sesiones
Formularios: sugerencia (público), login, recuperar/restablecer, cambiar contraseña, noticia, tráiler, reseña, usuario. Todos con `@csrf`, `old()` y errores por campo (`x-campo`) + resumen global (`partials/mensajes`). Mensajes de sesión: `exito`, `aviso`, `error`. Textos en `lang/es`.

## 11.9 Middleware
`VerificarRol` (alias `rol`): permite solo los roles indicados, registra en log los accesos denegados (IP, usuario, ruta) y responde 403. Aplicado únicamente a `/admin/*` (`rol:admin,editor`) y a `/admin/usuarios` (`rol:admin`).

## 17. Interfaz de usuario
- **17.1 Criterios:** rapidez (sin frameworks), legibilidad (línea ≤68 caracteres, contraste AA), color con significado (plataforma y rango de nota), accesibilidad (enlace “saltar”, foco visible, `aria-*`, `prefers-reduced-motion`).
- **17.2 Estructura:** encabezado fijo, contenido en contenedor de 1180 px, pie con secciones y plataformas.
- **17.3 Navegación:** ver 9.5. Móvil: menú colapsable, tablas del panel como tarjetas apiladas, tema claro/oscuro persistente.
