import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js','resources/js/admin-dashboard-charts.js','resources/js/user-dashboard-charts.js'],
            refresh: true,
        }),
    ],
});
