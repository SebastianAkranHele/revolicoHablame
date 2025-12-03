import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/js/app.js',
                 'resources/css/categories.css',
                'resources/js/categories.js',
                 'resources/css/listing-show.css',
                  'resources/js/listing-show.js',
            ],
            refresh: true,
        }),
    ],
});
