const mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel applications. By default, we are compiling the CSS
 | file for the application as well as bundling up all the JS files.
 |
 */

mix.styles([
    'resources/assets/admin/plugins/fontawesome-free/css/all.min.css',
    'resources/assets/common/plugins/select2/css/select2.css',
    'resources/assets/common/plugins/select2-bootstrap4-theme/select2-bootstrap4.css',
    'resources/assets/admin/css/adminlte.min.css',
    'resources/assets/common/css/custom.css',
    'resources/assets/admin/css/custom.css',
], 'public/assets/admin/css/admin.css');

mix.scripts([
    'resources/assets/admin/plugins/jquery/jquery.min.js',
    'resources/assets/admin/plugins/bootstrap/js/bootstrap.bundle.min.js',
    'resources/assets/common/plugins/select2/js/select2.full.js',
    'resources/assets/common/plugins/bs-custom-file-input/bs-custom-file-input.js',
    'resources/assets/admin/js/adminlte.min.js',
    'resources/assets/admin/js/demo.js',
    'resources/assets/common/js/custom.js',
    'resources/assets/admin/js/custom.js'
], 'public/assets/admin/js/admin.js');

mix.copyDirectory('resources/assets/admin/img', 'public/assets/admin/img');
mix.copyDirectory('resources/assets/admin/plugins/fontawesome-free/webfonts', 'public/assets/admin/webfonts');
mix.copy('resources/assets/admin/css/adminlte.min.css.map', 'public/assets/admin/css/adminlte.min.css.map');
mix.copy('resources/assets/admin/js/adminlte.min.js.map', 'public/assets/admin/js/adminlte.min.js.map');

mix.styles([
    'resources/assets/front/css/bootstrap.min.css',
    'resources/assets/front/css/font.awesome.css',
    'resources/assets/front/css/pe-icon-7-stroke.css',
    'resources/assets/front/css/animate.min.css',
    'resources/assets/front/css/swiper-bundle.min.css',
    'resources/assets/front/css/venobox.css',
    'resources/assets/front/css/jquery-ui.min.css',
    'resources/assets/front/css/style.css',
    'resources/assets/common/plugins/select2/css/select2.css',
    'resources/assets/common/plugins/select2-bootstrap4-theme/select2-bootstrap4.css',
    'resources/assets/common/css/custom.css',
    'resources/assets/front/css/custom.css',
], 'public/assets/front/css/front.css');

mix.scripts([
    'resources/assets/front/js/vendor/bootstrap.bundle.min.js',
    'resources/assets/front/js/vendor/jquery-3.6.0.min.js',
    'resources/assets/front/js/vendor/jquery-migrate-3.3.2.min.js',
    'resources/assets/front/js/vendor/modernizr-3.11.2.min.js',
    'resources/assets/front/js/plugins/jquery.countdown.min.js',
    'resources/assets/front/js/plugins/swiper-bundle.min.js',
    'resources/assets/front/js/plugins/scrollUp.js',
    'resources/assets/front/js/plugins/venobox.min.js',
    'resources/assets/front/js/plugins/jquery-ui.min.js',
    'resources/assets/front/js/plugins/mailchimp-ajax.js',
    'resources/assets/front/js/main.js',
    'resources/assets/common/plugins/select2/js/select2.full.js',
    'resources/assets/common/plugins/bs-custom-file-input/bs-custom-file-input.js',
    'resources/assets/common/js/custom.js'
], 'public/assets/front/js/front.js');

mix.copyDirectory('resources/assets/front/fonts', 'public/assets/front/fonts');
mix.copyDirectory('resources/assets/front/images', 'public/assets/front/images');
