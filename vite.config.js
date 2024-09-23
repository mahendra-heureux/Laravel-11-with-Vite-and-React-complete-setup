import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import react from '@vitejs/plugin-react';

export default defineConfig({
    base: 'http://127.0.0.1:8000/build/', // Adjust this path if necessary
    plugins: [
        laravel({
            input: 'resources/js/app.jsx',
            refresh: true,
        }),
        react(),
    ],
    server: {
        host: 'http://127.0.0.1:8000/', // External access to Vite from anywhere
        port: 5173, // Vite's default port
        hmr: {
            host: 'http://127.0.0.1:8000/', // GitHub Codespace URL without https://
            protocol: 'wss', // WebSocket Secure since Codespaces use HTTPS
            clientPort: 443, // WebSocket port for HTTPS
        },
    },
    build: {
        sourcemap: true, // Enable source maps
    }
});
