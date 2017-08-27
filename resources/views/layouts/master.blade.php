<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">

        <title>LetsWork - @yield('title')</title>

        <link href="{{asset('css/libs.css')}}" rel="stylesheet">
        <link href="{{asset('css/app.css')}}"  rel="stylesheet">

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->

        @yield('styles')
    </head>
    <body>

        <nav class="navbar">

        </nav>

        @yield('content')


        <!-- jQuery -->
        <script src="{{asset('js/libs.js')}}"></script>
        @yield('scripts')

    </body>
</html>