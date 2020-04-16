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
    .styles([
        'resources/views/Admin/assets/js/datatables/css/jquery.dataTables.min.css',
        'resources/views/Admin/assets/js/datatables/css/responsive.dataTables.min.css',
        'resources/views/Admin/assets/js/select2/css/select2.min.css'
    ], 'public/assets/css/libs.css')

    .scripts([
        'resources/views/Admin/assets/js/datatables/js/jquery.dataTables.min.js',
        'resources/views/Admin/assets/js/datatables/js/dataTables.responsive.min.js',
        'resources/views/Admin/assets/js/select2/js/select2.min.js',
        'resources/views/Admin/assets/js/select2/js/i18n/pt-BR.js',
        'resources/views/Admin/assets/js/jquery.form.js',
        'resources/views/Admin/assets/js/jquery.mask.js',
    ], 'public/assets/js/libs.js')

    .options({
        processCssUrls: false
    })

    .version();
