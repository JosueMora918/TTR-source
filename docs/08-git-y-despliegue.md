# 8. Git, GitHub y despliegue  _(secciones 19 y OE-4)_

## 19.2 Estrategia de commits (sugerida)
```
git checkout -b feature/u2-mvc
feat(mvc): controladores, rutas nombradas, layout Blade y componentes
feat(forms): formulario de sugerencias con validación, CSRF y flash
feat(i18n): localización es y mensajes de sesión
feat(ui): rediseño responsivo con modo oscuro
git checkout main && git merge --no-ff feature/u2-mvc

git checkout -b feature/u3-bd
feat(db): migraciones, modelos Eloquent y relaciones
feat(db): seeders y factories de datos de prueba
feat(crud): CRUD de noticias, tráilers y reseñas con búsqueda y paginación

git checkout -b feature/u4-seguridad
feat(auth): login, logout y recuperación de contraseña
feat(roles): middleware rol, policies y gestión de usuarios
feat(services): cache, events/listeners, logging e ImagenService

git checkout -b feature/u5-final
feat(api): API REST v1 de solo lectura
test: pruebas automáticas de funcionalidades
docs: README, diccionario de datos, API y casos de prueba
chore: limpieza de datos/rutas de prueba y .env.example
git tag -a v1.0.0 -m "Versión final TTR" && git push --tags
```
Usa **issues** de GitHub (uno por requisito: RF-01…RNF-08) y vincúlalos con `Closes #n` en los commits; publica el **release** v1.0.0.

## .gitignore y secretos
Verifica `git status`: `.env`, `vendor/`, `node_modules/` y `storage/*.key` no deben aparecer. Si `.env` se subió alguna vez: `git rm --cached .env`, rota `APP_KEY` y contraseñas.

## Despliegue (OE-4)
Vercel **no ejecuta PHP/Laravel** de forma nativa; el documento lo menciona, así que conviene justificar el cambio. Opciones con capa gratuita o educativa: **Railway** o **Render** (Docker) con MySQL externo, o un hosting compartido con PHP 8.2 y MySQL.
Pasos generales: `APP_ENV=production`, `APP_DEBUG=false`, `APP_URL` real, `APP_KEY` generada, credenciales de BD, `TTR_ADMIN_EMAIL/PASSWORD`, `php artisan migrate --force`, `php artisan db:seed --class=UserSeeder --force`, `php artisan storage:link`, `php artisan config:cache route:cache view:cache`, apuntar la raíz web a `/public` y habilitar HTTPS. En hosting efímero (Render/Railway sin disco persistente) las portadas subidas se pierden: usa un volumen o un disco S3 compatible.
