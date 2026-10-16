# 5. API REST de solo lectura

Base: `http://ttr.test/api/v1` · Formato JSON · Solo contenido **publicado** · 60 peticiones/min por IP.

| Método | Endpoint | Parámetros | Respuesta |
|---|---|---|---|
| GET | `/noticias` | `plataforma`, `q`, `page` | 200 lista paginada |
| GET | `/noticias/{slug}` | — | 200 / 404 |
| GET | `/trailers` | `plataforma` (incluye `Multi`), `q`, `page` | 200 |
| GET | `/trailers/{slug}` | — | 200 / 404 |
| GET | `/resenas` | `plataforma`, `q`, `page` | 200 |
| GET | `/resenas/{slug}` | — | 200 / 404 |

Ejemplo `GET /api/v1/resenas/nebula-rift`:
```json
{ "data": { "slug": "nebula-rift", "titulo": "Análisis de Nébula Rift", "videojuego": "Nébula Rift",
  "desarrollador": "Void Horizon Studios", "genero": "RPG de ciencia ficción", "plataforma": "PC",
  "puntuacion": 8.7, "pros": ["Narrativa profunda", "..."], "contras": ["..."],
  "veredicto": "...", "imagen": null, "url": "http://ttr.test/resenas/nebula-rift", "publicada": "2026-10-01T12:00:00-06:00" } }
```
Errores: `404 {"message": "..."}`, `429` al exceder el límite.

## Pruebas en Postman / Insomnia
1. `GET /api/v1/resenas` → 200 con `data`, `links`, `meta`.
2. `GET /api/v1/resenas?plataforma=PC` → solo PC.
3. `GET /api/v1/resenas/inexistente` → 404 JSON.
4. Borrador: crear una reseña en borrador y pedir su slug → 404.
5. `GET /api/v1/resenas?plataforma=Atari` → el filtro inválido se ignora.
