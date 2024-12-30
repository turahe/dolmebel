/// <reference types="vitest/config" />

// Configure Vitest (https://vitest.dev/config/)

import { defineConfig } from 'vite'
import path from 'path';
export default defineConfig({
    test: {
        /* for example, use global to avoid globals imports (describe, test, expect): */
        globals: true,
    },
    resolve: {
        alias: {
            '@': path.resolve(__dirname, './resources/js')
        },
    },
})
