import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            // Dodaj 'resources/js/add_puzzle.js' u input array
            input: [
                'resources/css/app.css',
                'resources/js/app.js',
                'resources/js/add_puzzle.js',
            ],
            refresh: true,
        }),
    ],
});
