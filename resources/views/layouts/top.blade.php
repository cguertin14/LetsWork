<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
        <meta name="viewport" content="width=device-width" />
        <link rel="icon" href="{{asset('image/lw.png')}}" type="image/png">
        <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">


        <title>LetsWork @yield('title')</title>

        @yield('fonts')
        <link href="{{asset('css/libs.css')}}" rel="stylesheet">
        <link href="{{asset('css/app.css')}}" rel="stylesheet">
        <style>
            .footer {
                visibility: hidden;
                position: absolute;
                bottom: 0;
                width: 100%;
                /* Set the fixed height of the footer here */
                height: 60px;
                line-height: 60px; /* Vertically center the text there */
                background-color: #696969;
            }

        </style>
        @yield('styles')
        @yield('headerscript')
    </head>
    <body>
        @yield('contenu')

        {{--<!-- Site footer -->--}}
        <footer class="footer">
            <div class="text-center">
                <span style="color: white;font-family: Ubuntu,sans-serif;font-weight: 500">Confidentialité | © LetsWork 2018</span>
            </div>
        </footer>

        <script src="{{asset('js/libs.js')}}"></script>
        @include('include.selectcompany')
        @include('include.dropdown')
        @yield('scriptsm')
    </body>
</html>