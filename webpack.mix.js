const mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */

mix.js('resources/js/app.js', 'public/js')
    .ts('resources/js/admin/index.ts', 'public/js/admin.js')
    .sass('resources/sass/common.scss', 'public/css')
    .sass('resources/sass/app/app.scss', 'public/css')
    .sass('resources/sass/admin/admin.scss', 'public/css')
    .sourceMaps();
