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
    .ts('resources/js/web/index.ts', 'public/js/web.js')
    .ts('resources/js/admin/index.ts', 'public/js/admin.js')
    .react()
    .sass('resources/sass/common.scss', 'public/css')
    .sass('resources/sass/app/app.scss', 'public/css')
    .sass('resources/sass/admin/admin.scss', 'public/css')
    .copy('node_modules/tinymce/skins/ui/oxide/skin.min.css', 'public/js/skins/ui/oxide/skin.min.css')
    .copy('node_modules/tinymce/skins/content/default/content.css', 'public/js/skins/content/default/content.css')
    .copy('node_modules/tinymce/skins/content/default/content.min.css', 'public/js/skins/ui/oxide/content.min.css')
    .copy('node_modules/tinymce/skins/ui/tinymce-5/content.min.css', 'public/css/tinymce/content.min.css')
    .sourceMaps();
