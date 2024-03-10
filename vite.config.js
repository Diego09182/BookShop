import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css','resources/css/materialize.css','resources/js/app.js','resources/js/materialize.js','resources/js/init.js'],
            refresh: true,
        }),
    ],
});
