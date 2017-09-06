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
    <nav class="navbar navbar-toggleable-md navbar-light bg-faded navbar-theme navbar-fixed-top navbar-static-top">
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbarNavDropdown">
                    <span class="sr-only" style="background-color: white; border-color: white">Toggle navigation</span>
                    <span class="icon-bar" style="background-color: white; border-color: white"></span>
                    <span class="icon-bar" style="background-color: white; border-color: white"></span>
                    <span class="icon-bar" style="background-color: white; border-color: white"></span>
                </button>
                <a class="navbar-brand" style="color: #ffffff;" href="{{route('homepage.content')}}">
                    <img src="{{asset('image/LetsWw.png')}}" width="auto" height="25" class="d-inline-block align-top" alt="">
                </a>
            </div>
            <div class="collapse navbar-collapse" id="navbarNavDropdown">
                <div class="nav navbar-nav navbar-right">
                    @if (!Auth::check())
                        <ul class="nav navbar-nav">
                            <li><a href="/login" style="color: white"><span class="glyphicon glyphicon-log-in" style="color: white"></span> Se Connecter</a></li>
                            <li><a href="/register" style="color: white"><span class="glyphicon glyphicon-user" style="color: white"></span> S'inscrire</a></li>
                        </ul>
                    @else
                        <ul class="nav navbar-nav">
                            <li><a href="#" style="color: white"><span class="glyphicon glyphicon-log-out" style="color: white"></span> Se déconnecter</a></li>
                            <li><a href="#" style="color: white"><span class="glyphicon glyphicon-user" style="color: white"></span>{{Auth::user()->name}}</a></li>
                        </ul>
                    @endif
                </div>
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