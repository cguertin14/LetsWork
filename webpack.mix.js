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
    'resources/assets/css/bootstrap-select.css',
],'public/css/libs.css');

mix.scripts([
    'node_modules/jquery/dist/jquery.js',
    'resources/assets/js/tether.js',
    'resources/assets/js/libs/tools.js',
    'resources/assets/js/libs/profile.js',
    'resources/assets/js/libs/dropzone.js',
    'resources/assets/js/libs/dropzone-amd-module.js',
    'resources/assets/js/typeahead/bloodhound.js',
    'resources/assets/js/typeahead/typeahead.bundle.js',
    'resources/assets/js/typeahead/typeahead.jquery.js',
    'node_modules/bootstrap-sass/assets/javascripts/bootstrap.js',
    'node_modules/moment/moment.js',
    'node_modules/moment/locale/fr-ca.js',
    'resources/assets/js/libs/bootstrap-datetimepicker.js',
    'resources/assets/js/libs/bootstrap-select.js',
    "resources/assets/js/libs/masonry.pkgd.js",
    "resources/assets/js/libs/infinite-scroll.pkgd.js",
    "resources/assets/js/libs/isotope.pkgd.js",
    "resources/assets/js/libs/vue.js"
],'public/js/libs.js');