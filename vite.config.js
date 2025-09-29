import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/css/landing.css',
                'resources/css/admin.css',
                'resources/js/app.js',
                'resources/js/landing.js',
                'resources/js/admin.js',
            ],
            refresh: true,
        }),
    ],
    build: {
        rollupOptions: {
            output: {
                manualChunks: {
                    vendor: ['axios', 'alpinejs'],
                }
            }
        }
    }
});
