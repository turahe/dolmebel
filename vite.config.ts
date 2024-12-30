import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import { VitePWA } from 'vite-plugin-pwa'
import path from 'path'
export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.ts'],
            refresh: true,
        }),
        VitePWA({ registerType: 'autoUpdate' })
    ],
    resolve: {
        alias: {
            '@': path.resolve(__dirname, './resources/js')
        },
    },
});
