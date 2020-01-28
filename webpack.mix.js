const { mix } = require('laravel-mix');

mix.js('resources/assets/js/app.js', 'public/js')
   .sass('resources/assets/sass/app.scss', 'public/css');

mix.styles([
    'resources/assets/css/fonts.css',
    'resources/assets/css/libs/font-awesome.css',
    'resources/assets/css/tether.css',
    'resources/assets/css/libs/homepage.css',
    'resources/assets/css/libs/tools.css',
    'resources/assets/css/libs/profile.css',
    'resources/assets/css/libs/forgetpassword.css',
    'resources/assets/css/libs/dropzone.css',
    'resources/assets/css/libs/basic.css',
    'resources/assets/css/libs/404page.css',
    'resources/assets/css/bootstrap-datetimepicker.css',
    'resources/assets/css/bootstrap-datetimepicker-standalone.css',
    'resources/assets/css/bootstrap-select.css',
    'resources/assets/css/schedule/style.css',
    'resources/assets/css/libs/sidemenu.css',
    'resources/assets/css/schedule/dhtmlxcalendar.css',
],'public/css/libs.css');

mix.scripts([
    'resources/assets/js/schedule/dhtmlxcalendar.js',
    'resources/assets/js/schedule/date.format.js',
    'node_modules/jquery/dist/jquery.js',
    'resources/assets/js/schedule/hour-container.js',
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
    'resources/assets/js/libs/masonry.pkgd.js',
    'resources/assets/js/libs/infinite-scroll.pkgd.js',
    'resources/assets/js/libs/isotope.pkgd.js',
    'resources/assets/js/libs/vue.min.js',
    'resources/assets/js/libs/pdfobject.js',
    'resources/assets/js/schedule/modernizr.js',
    'resources/assets/js/schedule/tools.js',
    'resources/assets/js/libs/jquery.mask.js',
    'resources/assets/js/libs/modal.js',
    'resources/assets/js/libs/Chart.js',
    'resources/assets/js/libs/socket.io.js',
    'resources/assets/js/libs/jquery-ui.js',
    'resources/assets/js/libs/bloodhound.js',
    'resources/assets/js/libs/typeahead.bundle.js',
    'resources/assets/js/libs/typeahead.jquery.js',
],'public/js/libs.js');

mix.babel([
    'resources/assets/js/schedule/main.js'
], 'public/js/schedule.js');