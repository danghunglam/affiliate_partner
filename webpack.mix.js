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
    .copy('resources/bootstrap/vendor/bootstrap/css/bootstrap.min.css','public/css/bootstrap.min.css')
    .copy('resources/bootstrap/vendor/fontawesome-free/css/all.min.css','public/css/all.min.css')
    .copy('resources/bootstrap/vendor/datatables/dataTables.bootstrap4.css','public/css/dataTables.bootstrap4.css')
    .copy('resources/bootstrap/css/sb-admin.css','public/css/sb-admin.css')
    .copy('resources/bootstrap/vendor/jquery/jquery.min.js','public/js/jquery.min.js')
    .copy('resources/bootstrap/vendor/bootstrap/js/bootstrap.bundle.min.js','public/js/bootstrap.bundle.min.js')
    .copy('resources/bootstrap/vendor/jquery-easing/jquery.easing.min.js','public/js/jquery.easing.min.js')
    .copy('resources/bootstrap/vendor/chart.js/Chart.min.js','public/js/Chart.min.js')
    .copy('resources/bootstrap/vendor/datatables/jquery.dataTables.js','public/js/jquery.dataTables.js')
    .copy('resources/bootstrap/vendor/datatables/dataTables.bootstrap4.js','public/js/dataTables.bootstrap4.js')
    .copy('resources/bootstrap/js/sb-admin.min.js','public/js/sb-admin.min.js')
    .copy('resources/bootstrap/js/demo/datatables-demo.js','public/js/datatables-demo.js')
    .copy('resources/bootstrap/js/demo/chart-bar-demo.js','public/js/chart-bar-demo.js')
    .copy('resources/js/create_link.js','public/js/create_link.min.js')
   .sass('resources/sass/app.scss', 'public/css');
