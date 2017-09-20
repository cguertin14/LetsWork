<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="icon" href="{{asset('image/lw.png')}}" type="image/png">

        <title>LetsWork @yield('title')</title>

        <link href="{{asset('css/libs.css')}}" rel="stylesheet">
        <link href="{{asset('css/app.css')}}" rel="stylesheet">

        @yield('styles')
    </head>
    <body>
        @yield('contenu')
        <script src="{{asset('js/libs.js')}}"></script>
        @include('include.dropdown')
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.10/jquery.mask.js"></script>
        @yield('scripts')
    </body>
</html>