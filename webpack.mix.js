const { mix } = require('laravel-mix');

mix.js('resources/assets/js/app.js', 'public/js')
   .sass('resources/assets/sass/app.scss', 'public/css');

mix.styles([
    'resources/assets/css/bootstrap.css'
],'public/css/libs.css');

mix.scripts([
    'resources/assets/js/bootstrap.js',
    'resources/assets/js/jquery-3.2.1.js',
],'public/js/libs.js');