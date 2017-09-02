@extends('layouts.top')

@section('styles')
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
@endsection

@section('contenu')
    <nav class="navbar navbar-toggleable-md navbar-light bg-faded navbar-theme navbar-fixed-top">
        <a class="navbar-brand" style="color: #ffffff;" href="{{route('homepage.content')}}">
            <img src="{{asset('image/letsworkw.svg')}}" width="auto" height="25" class="d-inline-block align-top" alt="">
        </a>
        <div class="collapse navbar-collapse" id="navbarNavDropdown">
            <ul class="nav navbar-nav">
                <li class="nav-item active">
                    <a class="nav-link" href="{{route('homepage.content')}}">Home<span class="sr-only">(current)</span></a>
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
                        <input type="text" class="form-control" placeholder="Chercher..." name="q">
                        <div class="input-group-btn">
                            <button class="btn btn-default" type="submit"><i class="glyphicon glyphicon-search"></i></button>
                        </div>
                    </div>
                </form>
                @if (!Auth::check())
                    <ul class="nav navbar-nav">
                        <li><a href="/register" style="color: white"><span class="glyphicon glyphicon-user" style="color: white"></span> S'inscrire</a></li>
                        <li><a href="/login" style="color: white"><span class="glyphicon glyphicon-log-in" style="color: white"></span> Se Connecter</a></li>
                    </ul>
                @else
                    <ul class="nav navbar-nav">
                        <li><a href="#" style="color: white"><span class="glyphicon glyphicon-user" style="color: white"></span>{{Auth::user()->name}}</a></li>
                        <li><a href="#" style="color: white"><span class="glyphicon glyphicon-log-out" style="color: white"></span> Se déconnecter</a></li>
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
@endsection