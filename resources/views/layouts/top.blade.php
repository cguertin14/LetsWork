<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="icon" href="{{asset('image/lw.png')}}" type="image/png">

        <title>LetsWork @yield('title')</title>

        <link href="{{asset('css/libs.css')}}" rel="stylesheet">
        <link href="{{asset('css/app.css')}}" rel="stylesheet">
        {{--<!--jQuery js-->--}}
        {{--<script src="//code.jquery.com/jquery-1.12.0.min.js"></script>--}}
        {{--<script src="//code.jquery.com/jquery-migrate-1.2.1.min.js"></script>--}}
        {{--<!--bootstrap js-->--}}
        {{--<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>--}}


        @yield('styles')
    </head>
    <body>
        @yield('contenu')

        <script src="{{asset('js/libs.js')}}"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.10/jquery.mask.js"></script>
        @yield('scripts')
    </body>
</html>