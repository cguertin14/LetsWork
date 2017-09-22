const { mix } = require('laravel-mix');

mix.js('resources/assets/js/app.js', 'public/js')
    .sass('resources/assets/sass/app.scss', 'public/css');

mix.styles([
    'resources/assets/css/tether.css',
    'resources/assets/css/libs/homepage.css',
    'resources/assets/css/libs/tools.css',
    'resources/assets/css/libs/profile.css',
    'resources/assets/css/libs/forgetpassword.css',
    'resources/assets/css/libs/dropzone.css',
    'resources/assets/css/libs/basic.css',
    'resources/assets/css/libs/sidemenu.css',
    'resources/assets/css/libs/404page.css',
    'resources/assets/css/bootstrap-datetimepicker.css',
    'resources/assets/css/bootstrap-datetimepicker-standalone.css',
],'public/css/libs.css');

mix.scripts([
    'node_modules/jquery/dist/jquery.js',
    'resources/assets/js/tether.js',
    'resources/assets/js/libs/tools.js',
    'resources/assets/js/libs/profile.js',
    'resources/assets/js/libs/dropzone.js',
    'resources/assets/js/libs/dropzone-amd-module.js',
    'node_modules/bootstrap-sass/assets/javascripts/bootstrap.js',
    'node_modules/moment/moment.js',
    'resources/assets/js/libs/bootstrap-datetimepicker.js',
],'public/js/libs.js');