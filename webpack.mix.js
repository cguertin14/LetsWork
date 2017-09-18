const { mix } = require('laravel-mix');

mix.styles([
    'resources/assets/css/tether.css',
    'resources/assets/css/homepage.css',
    'resources/assets/css/tools.css',
    'resources/assets/css/profile.css',
    'resources/assets/css/forgetpassword.css',
    'resources/assets/css/sidemenu.css'
],'public/css/libs.css');

mix.scripts([
    'node_modules/jquery/dist/jquery.js',
    'resources/assets/js/tether.js',
    'resources/assets/js/libs/tools.js',
    'resources/assets/js/libs/profile.js',
    'resources/assets/js/libs/dropzone.js',
    'node_modules/bootstrap-sass/assets/javascripts/bootstrap.js',
],'public/js/libs.js');

mix.js('resources/assets/js/app.js', 'public/js')
    .sass('resources/assets/sass/app.scss', 'public/css');