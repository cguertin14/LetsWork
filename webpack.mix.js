const { mix } = require('laravel-mix');

mix.js('resources/assets/js/app.js', 'public/js')
   .sass('resources/assets/sass/app.scss', 'public/css');

mix.styles([
    'resources/assets/css/libs/bootstrap.css',
],'public/css/libs.css');

mix.scripts([
    'resources/assets/js/libs/jquery-3.2.1.js',
    'resources/assets/js/libs/bootstrap.js'
],'public/js/libs.js');