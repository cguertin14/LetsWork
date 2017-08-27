<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">

        <title>LetsWork - @yield('title')</title>

        <link href="{{asset('css/libs.css')}}" rel="stylesheet">
        <link href="{{asset('css/app.css')}}"  rel="stylesheet">

        @yield('styles')
    </head>
    <body>
<<<<<<< HEAD
        <nav class="navbar navbar-inverse bg-inverse navbar-toggleable-md">
            <div class="container">
                <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarsExampleContainer" aria-controls="navbarsExampleContainer" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <a class="navbar-brand" href="#">Container</a>

                <div class="collapse navbar-collapse" id="navbarsExampleContainer">
                    <ul class="navbar-nav mr-auto">
                        <li class="nav-item active">
                            <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Link</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link disabled" href="#">Disabled</a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="http://example.com" id="dropdown02" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Dropdown</a>
                            <div class="dropdown-menu" aria-labelledby="dropdown02">
                                <a class="dropdown-item" href="#">Action</a>
                                <a class="dropdown-item" href="#">Another action</a>
                                <a class="dropdown-item" href="#">Something else here</a>
                            </div>
                        </li>
                    </ul>
                    <form class="form-inline my-2 my-md-0">
                        <input class="form-control mr-sm-2" type="text" placeholder="Search">
                        <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
                    </form>
                </div>
            </div>
=======

        <nav class="navbar">

>>>>>>> parent of 1ac42f4... image
        </nav>

        @yield('content')

        <!-- jQuery -->
        <script src="{{asset('js/libs.js')}}"></script>
        @yield('scripts')

    </body>
</html>