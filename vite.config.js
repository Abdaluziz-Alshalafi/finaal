import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/css/styles.css',
                'resources/css/add-projects.css',
                'resources/css/dilog.css',
                'resources/css/stylesss.css',
                'resources/css/multi-step-form.css',
                'resources/css/her.css',


                'resources/js/add_project.js',
                'resources/js/app.js',
                'resources/js/dashboard.js',
                'resources/js/script.js',
                'resources/js/cheack.js',

                              ],            refresh: true,
        }),
    ],
});
