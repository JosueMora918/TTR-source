# TTR — Trailers, Teasers and Reviews

Plataforma web editorial de videojuegos (Laravel 11 · PHP 8.3 · MySQL). Noticias, tráilers embebidos y reseñas con ficha técnica, pros/contras y nota decimal de 1.0 a 10.0, más un panel `/admin` con roles.

Proyecto de titulación · Mora Prado Josué Emmanuel · CUValles, Universidad de Guadalajara · Asesor: Mtro. Adolfo Castillo Chavarín.

## Requisitos
- PHP 8.2+ con extensiones `gd` (con WebP), `pdo_mysql`, `mbstring`, `fileinfo`
- Composer 2, MySQL 8 / MariaDB 10.6+
- Laragon Full (Windows) incluye todo lo anterior

## Instalación en Laragon (desde cero)

```bash
# 1. Proyecto Laravel limpio
cd C:\laragon\www
composer create-project laravel/laravel:^12.0 ttr
cd ttr

# 2. Copia ENCIMA del proyecto todo el contenido de este paquete (respeta rutas).
#    Acepta sobrescribir: bootstrap/app.php, routes/web.php, .env.example,
#    app/Models/User.php, app/Providers/AppServiceProvider.php y la migración
#    database/migrations/0001_01_01_000000_create_users_table.php
#    Después elimina las migraciones sobrantes de Laravel (no se usan):
#    database/migrations/0001_01_01_000001_create_cache_table.php
#    database/migrations/0001_01_01_000002_create_jobs_table.php
#    y resources/views/welcome.blade.php

# 3. Paquete adicional (procesa y optimiza portadas)
composer require intervention/image

# 4. Configuración
copy .env.example .env
php artisan key:generate
```

Crea la base de datos `ttr` (HeidiSQL → clic derecho → Crear base de datos → `utf8mb4_unicode_ci`). Ajusta `DB_*` en `.env` si usas otra contraseña.

En `config/app.php` cambia `'timezone' => 'UTC'` por `'America/Mexico_City'`.

```bash
# 5. Base de datos, datos de prueba y enlace de imágenes
php artisan migrate:fresh --seed
php artisan storage:link

# 6. Ejecutar
php artisan serve          # http://127.0.0.1:8000   (o http://ttr.test con Laragon)
php artisan test           # pruebas automáticas
php artisan route:list     # evidencia de rutas
```

### Cuentas de demostración (solo local)
| Rol | Correo | Contraseña |
|---|---|---|
| admin | admin@ttr.test | Admin#2026 |
| editor | editor@ttr.test | Editor#2026 |

**Cámbialas o no uses el seeder en producción** (usa `TTR_ADMIN_EMAIL` / `TTR_ADMIN_PASSWORD`).

### Recuperación de contraseña
Con `MAIL_MAILER=log` el enlace de restablecimiento aparece en `storage/logs/laravel.log`.

### Notas
- Los videojuegos, estudios y notas del seeder son **ficticios**. Los enlaces de video de ejemplo son un placeholder: reemplázalos desde `/admin/trailers`.
- No hay build de frontend: CSS y JS están en `public/css` y `public/js` (no se necesita `npm`).
- `.env` nunca se sube a GitHub (ya está en el `.gitignore` de Laravel).

## Mapa de requisitos → dónde está
| Requisito | Ubicación |
|---|---|
| Controladores / rutas nombradas / parámetros opcionales | `app/Http/Controllers`, `routes/web.php` |
| Middleware propio | `app/Http/Middleware/VerificarRol.php` (alias `rol`) |
| Blade (layout, parciales, componentes) | `resources/views/layouts`, `partials`, `components` |
| Formularios + CSRF + validación + `old()` | `app/Http/Requests`, `resources/views/**/form.blade.php` |
| Localización | `lang/es/*.php` |
| Migraciones / modelos / seeders / factories | `database/`, `app/Models` |
| Roles, Policies, hashing, recuperación | `User`, `ContenidoPolicy`, `Auth/*` |
| Servicios Laravel: Cache, Events/Listeners, Collections, File Storage, Helpers, Mail/Notifications | ver `docs/04-seguridad-y-servicios.md` |
| Paquete adicional | `intervention/image` → `app/Services/ImagenService.php` |
| API | `routes/api.php`, `docs/05-api.md` |
| Pruebas | `tests/Feature/TtrTest.php`, `docs/06-pruebas.md` |

Documentación completa en la carpeta [`docs/`](docs).
