# 7\. Bitácora de uso de IA generativa  *(sección 20\)*

## 7.1 Herramientas

- **Claude (Anthropic)**, usado en conversación web. Ayudó a generar código, documentación, diseño visual y a diagnosticar errores.  
- **Limitación importante:** en este entorno la IA no pudo ejecutar PHP, Composer ni Laravel. Todo el código se entregó sin haberse corrido, y la verificación de que funciona la hice yo en Laragon.

## 7.2 Propósitos

1. Ampliar la primera versión de TTR (fase 1, con datos de ejemplo) hasta un proyecto completo que cubra las Actividades 5 a 8: MVC, base de datos, seguridad y versión final.  
2. Rediseñar la interfaz (responsiva, modo oscuro, color por plataforma).  
3. Generar la documentación técnica (`docs/`), las pruebas automáticas y el documento de evidencias.  
4. Diagnosticar los errores que aparecieron al instalar y probar el sistema.  
5. Orientarme en Git/GitHub y en las opciones de hosting.

## 7.3 Bitácora de prompts

| Fecha | Prompt (resumen) | Qué generó o respondió la IA | Qué hice yo |
| :---- | :---- | :---- | :---- |
| Oct 2026 | Pedí una página web que cumpla `requisitos.txt` con base en mi documento de tesis (PDF) | Resumen del proyecto, requisitos, decisiones técnicas y plan de entrega; preguntó si ya tenía un proyecto base | Revisé el plan y respondí con el proyecto de la fase 1 |
| Oct 2026 | Usar el proyecto de la fase 1 (zip y repositorio) como base y mejorar el diseño | Revisó la base y generó un proyecto Laravel completo (controladores, modelos, migraciones, vistas Blade, CSS/JS, API, pruebas y 8 documentos) | Lo instalé y lo probé en Laragon |
| Oct 2026 | Pegué el error de Composer al crear el proyecto (Laravel 11\) | Buscó el estado de soporte; explicó que Laravel 11 ya no recibe parches de seguridad y recomendó Laravel 12 | Creé el proyecto con Laravel 12 |
| Oct 2026 | Pegué el error "directorio no vacío" de `create-project` | Explicó la causa y dio dos opciones | Usé una carpeta nueva (`TTRv3`) |
| Oct 2026 | Reporté "las credenciales no coinciden" y pregunté si debía agregar el usuario en HeidiSQL | Detectó que `.env.example` dejaba variables vacías que anulaban las credenciales del seeder; corrigió seeder, `.env.example` y README | Apliqué la corrección y volví a sembrar la base; el login funcionó |
| Oct 2026 | Pregunté qué hacer después de que todo funcionara | Lista priorizada: Git, pruebas, capturas, contenido real, documentos, despliegue | Seguí la lista |
| Oct 2026 | Pegué el resultado de ejecutar mensajes de commit como comandos de PowerShell | Explicó que eran mensajes y dio la secuencia de `git add` / `git commit` por rama | Ejecuté los commits por rama y subí al repositorio |
| Oct 2026 | Consulté por "compare & pull request" y por la rama `master` | Explicó la diferencia entre ramas; al ver mi historial, detectó que no existía `main` y propuso crearla con un commit vacío y fusionar las ramas | Ejecuté los pasos de Git y revisé el historial |
| Oct 2026 | Pregunté si podía usar GitHub Pages como hosting | Explicó que solo sirve sitios estáticos; buscó opciones gratuitas y sus límites | Quedó pendiente decidir el hosting |
| Oct 2026 | Pegué el log con el error al subir una imagen | Identificó el error (`ImageManager::read()` no existe en la versión instalada de `intervention/image`) y dio el comando con la versión correcta | Apliqué la corrección de versión |
| Oct 2026 | Pregunté cómo comprobar los casos M21 (CSRF) y M24 (Lighthouse) | Pasos con DevTools y con la pestaña Lighthouse, y qué métricas anotar | Realicé ambas pruebas y tomé las capturas |
| Oct 2026 | Subí 46 capturas y pedí ordenarlas por tarea y redactar un documento | Clasificó las capturas, descartó las poco útiles, generó el documento de evidencias y detectó pendientes | Revisaré el documento y completaré las evidencias que faltan |
| Oct 2026 | Pedí llenar esta bitácora | Redactó este documento con base en la conversación | Lo reviso y lo ajusto con mis palabras |

## 7.4 Sugerencias de la IA que adopté o rechacé

| Sugerencia | Decisión |
| :---- | :---- |
| Usar Laravel 12 en lugar de Laravel 11 | Adoptada (Laravel 11 ya no recibe parches de seguridad) |
| No usar Vercel para desplegar PHP/Laravel | Adoptada; el hosting definitivo sigue pendiente |
| Crear las cuentas del equipo desde el panel de administración, sin registro abierto | Adoptada; evita que cualquier persona publique |
| Fijar `intervention/image` a la versión 3 | Adoptada |
| Medir Lighthouse sobre el sitio publicado para el valor definitivo | Pendiente hasta tener hosting |
| Publicar el release `v1.0.0` y crear issues en GitHub | Pendiente |

## 7.5 Modificaciones realizadas por mí

Lo que hice yo, además de pedir y revisar el código:

- Instalé y configuré el entorno (Laragon, PHP, MySQL, WebStorm) y creé el proyecto con Laravel 12\.  
- Ejecuté `php artisan migrate:fresh --seed`, `php artisan test` y `php artisan route:list`.  
- Apliqué las correcciones de los errores que aparecieron (versión de Laravel, seeder, versión de `intervention/image`).  
- Revisé en HeidiSQL que las tablas, los usuarios y las contraseñas con hash estuvieran correctos.  
- Realicé las pruebas manuales de `docs/06-pruebas.md`, incluidas CSRF, roles, validaciones, recuperación de contraseña y vista móvil, y tomé 46 capturas.  
- Creé contenido de prueba propio (una reseña y un tráiler con video real).  
- Organicé el historial de Git en ramas por actividad, creé `main` y subí el proyecto a GitHub.

**Lo que no modifiqué:** el código fuente generado por la IA (controladores, modelos, vistas, estilos y pruebas) se usó tal como se entregó, salvo las correcciones indicadas arriba. Solo lo declaro porque así fue.

## 7.6 Elementos descartados

- Laravel 11, por seguridad.  
- Capturas poco útiles o que podían confundir (errores desactualizados, pasos previos, una vista previa de markdown y una con una notificación personal visible).  
- Pendiente de decidir: reemplazar los videos de ejemplo del seeder por tráilers reales.

## 7.7 Errores de la IA que detecté

| Error | Cómo se detectó | Corrección |
| :---- | :---- | :---- |
| El `README` y las instrucciones iniciales indicaban Laravel 11, que ya no tiene soporte | Composer bloqueó la instalación | Se cambió a Laravel 12 |
| El seeder creó al administrador con correo y contraseña vacíos, porque `.env.example` dejaba variables vacías | No pude iniciar sesión como admin | Se corrigió el seeder y `.env.example` |
| `intervention/image` se instaló en una versión incompatible con el código (se esperaba la 3\) | Error `ImageManager::read()` en el log al subir una portada | Se fijó la versión 3 |
| Las instrucciones de Git asumían que existía una rama `main` | Al revisar `git branch -a` solo había ramas `feature/*` | Se creó `main` con un commit vacío y se fusionaron las ramas |
| El paquete entregado incluyó una carpeta basura con nombre `{layouts,partials,components,vendor…}`, creada por un comando de la IA | La vi en el árbol del proyecto en WebStorm | Debo eliminarla del proyecto |
| El código no se probó antes de entregarlo | La IA lo advirtió: no tenía PHP en su entorno | Verifiqué con `php artisan test` (17 pruebas aprobadas) y pruebas manuales |

## 7.8 Validación

* **Pruebas automáticas:** `php artisan test` con 17 pruebas aprobadas (15 propias y 2 de ejemplo de Laravel).  
* **Pruebas manuales:** casos M1 a M24 de `docs/06-pruebas.md`, con capturas en el documento de evidencias.  
* **Base de datos:** revisión en HeidiSQL de tablas, registros y hash Bcrypt.  
* **Rendimiento:** Lighthouse móvil sobre el servidor local (99 / 96 / 100 / 100); la medición definitiva se hará con el sitio publicado.  
* **Git:** historial por ramas y repositorio actualizado.

## 7.9 Aprendizajes

* Los paquetes y las versiones de las herramientas cambian: hay que fijar versiones y leer el error real del log antes de culpar al código.  
* Un valor vacío en el `.env` no equivale a "sin valor"; puede anular los valores por defecto.  
* El historial de Git y la diferencia entre ramas locales y remotas, y cómo fusionar con `--no-ff`.  
* Cómo se separan las responsabilidades en MVC: rutas, controladores, middleware, políticas, validaciones y vistas.  
* Lo que genera una IA debe probarse: el código llegó sin ejecutarse y los errores salieron al correrlo.

## 7.10 Ética y autoría

* Declaro que utilicé IA generativa como apoyo, que lo indico aquí y que el uso fue transparente.  
* El código generado por la IA fue probado y revisado por mí en Laragon y, hasta donde el alcance de este proyecto lo exige, entiendo cómo funciona.  
* Los videojuegos, estudios y notas del seeder son ficticios. El contenido de prueba que creé a mano incluye una reseña y un tráiler de un videojuego real con fines de prueba; no constituye contenido editorial definitivo.  
* Las referencias y los datos del documento del proyecto (PDF) son los de mi protocolo; la IA no los verificó contra las fuentes originales.