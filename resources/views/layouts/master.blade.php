<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">

    <title>LetsWork - @yield('title')</title>
    <!-- First include jquery js -->
    <script src="//code.jquery.com/jquery-1.12.0.min.js"></script>
    <script src="//code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
    <!-- Then include bootstrap js -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>

    <link href="{{asset('css/libs.css')}}" rel="stylesheet">
    <link href="{{asset('css/app.css')}}" rel="stylesheet">
    @yield('styles')

    <style>
        .navbar-theme {
            background-color: #464646;
            color: #FFFFFF;
        }
        .nav-item,.nav-link {
            color: #FFFFFF !important;
        }
        .nav > li > a:hover, .nav > li > a:focus {
            text-decoration: none;
            background-color: #535353;
        }
        .nav .open > a, .nav .open > a:hover, .nav .open > a:focus{
            text-decoration: none;
            background-color: #535353;
        }
    </style>
</head>
<body>
<nav class="navbar navbar-toggleable-md navbar-light bg-faded navbar-theme navbar-fixed-top">
    <a class="navbar-brand" style="color: #ffffff;" href="#">
        <img src="{{asset('image/LetsWw.png')}}" width="auto" height="25" class="d-inline-block align-top" alt="">
    </a>
    <div class="collapse navbar-collapse" id="navbarNavDropdown">
        <ul class="nav navbar-nav">
            <li class="nav-item">
                <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">Features</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">Pricing</a>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="http://example.com" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Dropdown link
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                    <a class="dropdown-item" href="#">Action</a>
                    <a class="dropdown-item" href="#">Another action</a>
                    <a class="dropdown-item" href="#">Something else here</a>
                </div>
            </li>
        </ul>
        <div class="nav navbar-nav navbar-right">
            <form class="navbar-form" role="search">
                <div class="input-group">
                    <input type="text" class="form-control" placeholder="Search" name="q">
                    <div class="input-group-btn">
                        <button class="btn btn-default" type="submit"><i class="glyphicon glyphicon-search"></i></button>
                    </div>
                </div>
            </form>
            @if (!Auth::check())
                <ul class="nav navbar-nav">
                    <li><a href="" style="color: white"><span class="glyphicon glyphicon-user" style="color: white"></span> Sign Up</a></li>
                    <li><a href="" style="color: white"><span class="glyphicon glyphicon-log-in" style="color: white"></span> Login</a></li>
                </ul>
            @else
                <ul class="nav navbar-nav">
                    <li><a href="#" style="color: white"><span class="glyphicon glyphicon-user" style="color: white"></span>{{Auth::user()->name}}</a></li>
                    <li><a href="#" style="color: white"><span class="glyphicon glyphicon-log-in" style="color: white"></span> Logout</a></li>
                </ul>
            @endif
        </div>
    </div>
</nav>

<div id="body">
    @yield('content')
</div>

<script src="https://npmcdn.com/tether@1.2.4/dist/js/tether.min.js"></script>
<script src="https://npmcdn.com/bootstrap@4.0.0-alpha.6/dist/js/bootstrap.min.js"></script>
<script src="{{asset('js/libs.js')}}"></script>
@yield('scripts')
</body>
</html>