# Si el servidor se apaga y no vuelve

> Borrador: revísalo y ajústalo con tus palabras antes de entregar.

## ¿Qué se pierde exactamente?

**Se pierde lo que vive en los dos volúmenes y en los secretos que no están en Git.**

- **`datos-db`**, el volumen de PostgreSQL. Ahí están las dos bases: `avisos_laravel` (avisos, categorías, etiquetas, usuarios con su rol, y los tokens de acceso personal que Angular usa para iniciar sesión) y `avisos_django` (los avisos de la API de Django). Es lo único irrecuperable de verdad: los seeders solo reponen categorías, avisos de ejemplo y los usuarios de `UserSeeder`; cualquier aviso, usuario o cambio hecho después desde Angular o Filament desaparece.
- **`almacen-laravel`**, el volumen de `storage/`. Con `SESSION_DRIVER` y `CACHE_STORE` en `file`, ahí están las sesiones y la caché. Se pierden, pero se regeneran solas: el costo es que las sesiones activas se cierran. Este proyecto no sube archivos, así que no hay nada más valioso ahí.
- **Los secretos**: el `.env` del servidor (`APP_KEY`, `BD_CLAVE`, `DJANGO_SECRET_KEY`) y las variables de GitLab (`SERVIDOR_TOKEN`, `SERVIDOR_URL`, `SERVIDOR_UUID`). Si la `APP_KEY` se pierde y se genera otra, lo cifrado con la anterior (cookies, sesiones) deja de leerse; los tokens de la base siguen valiendo porque se guardan con hash.

**No se pierde:** el código, los tres `Dockerfile`, `compose.yaml`, el pipeline y los seeders, porque están en GitLab. Las imágenes se vuelven a construir con `docker compose up -d --build` en otra máquina, y las migraciones y seeders corren solos al arrancar. Eso es justo lo que demuestra la prueba de la copia limpia.

## ¿Qué tendría que existir para que no se perdiera?

1. **Un respaldo de la base fuera del servidor.** Un `pg_dump` periódico de las dos bases (`docker compose exec db pg_dump -U avisos avisos_laravel`, y lo mismo con `avisos_django`), enviado a un lugar que no sea esa máquina (otro servidor o almacenamiento de objetos). Un volumen no es un respaldo: vive en el mismo disco que el servidor, y `down -v` o un disco roto lo borran.
2. **Los secretos guardados aparte**, en un gestor de contraseñas o en las variables protegidas de GitLab, no solo en el `.env` del servidor.
3. **Un lugar al que volver a desplegar**: otra máquina y la misma cadena (GitLab → botón → servidor), que ya existe.

**Cómo comprobaría que los respaldos sirven:** un respaldo que nunca se restauró es una suposición. Cada cierto tiempo restauraría el último `pg_dump` en una copia limpia del proyecto (otro `COMPOSE_PROJECT_NAME`, otros puertos, igual que la parte 6 de la guía 04) con `psql < respaldo.sql`, y comprobaría que Angular muestra los avisos más recientes y que puedo iniciar sesión con un usuario creado *después* del seeder. Si algo de eso falla, el respaldo no sirve, y lo descubro un martes cualquiera y no el día del desastre.
