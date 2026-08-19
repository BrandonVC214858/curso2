import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import { bunny } from 'laravel-vite-plugin/fonts';
import tailwindcss from '@tailwindcss/vite';

// Config del curso: la misma de Laravel mas la seccion "server", para que los
// estilos carguen igual en el contenedor local y en GitHub Codespaces.
// Sin esto, el navegador busca al servidor de Vite en una direccion que no
// puede alcanzar desde fuera del contenedor y la pagina se ve SIN estilos.

const enCodespaces = !!process.env.CODESPACE_NAME;
const dominio = process.env.GITHUB_CODESPACES_PORT_FORWARDING_DOMAIN ?? 'app.github.dev';
const hostPublico = `${process.env.CODESPACE_NAME}-5173.${dominio}`;

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
            fonts: [
                bunny('Instrument Sans', {
                    weights: [400, 500, 600],
                }),
            ],
        }),
        tailwindcss(),
    ],
    server: {
        watch: {
            ignored: ['**/storage/framework/views/**'],
        },
        host: '0.0.0.0',
        port: 5173,
        strictPort: true,
        ...(enCodespaces
            ? {
                  // En Codespaces el navegador entra por el dominio publico del puerto 5173
                  // (recuerda ponerlo en "Public" en la pestana PORTS)
                  hmr: { protocol: 'wss', host: hostPublico, clientPort: 443 },
                  origin: `https://${hostPublico}`,
              }
            : {
                  // Contenedor local o Laragon: el navegador llega por localhost
                  hmr: { host: 'localhost' },
              }),
    },
});
