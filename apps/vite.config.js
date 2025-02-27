import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import { Html5QrcodeScanner } from "html5-qrcode";

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
    ],
    // server: {
    //     host: '30.30.30.33',
    //     hmr: {
    //         host: '30.30.30.33'
    //     },
    // },
});
