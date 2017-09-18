const { mix } = require('laravel-mix');

mix.styles([
    'resources/assets/css/tether.css',
    'resources/assets/css/homepage.css',
    'resources/assets/css/tools.css',
    'resources/assets/css/forgetpassword.css'
],'public/css/libs.css');

mix.scripts([
    'resources/assets/js/jquery-3.2.1.js',
    'resources/assets/js/tether.js',
    'node_modules/bootstrap-sass/assets/javascripts/bootstrap.js',
],'public/js/libs.js');

mix.js('resources/assets/js/app.js', 'public/js')
    .sass('resources/assets/sass/app.scss', 'public/css');