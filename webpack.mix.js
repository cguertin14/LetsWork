const { mix } = require('laravel-mix');

mix.js('resources/assets/js/app.js', 'public/js')
   .sass('resources/assets/sass/app.scss', 'public/css');

mix.styles([
    'resources/assets/css/bootstrap.css'
],'public/css/libs.css');

mix.scripts([
    'resources/assets/js/bootstrap.css',
    'node_modules/jquery/dist/jquery.js',
],'public/js/libs.js');