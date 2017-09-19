@extends('layouts.top')

@section('contenu')
    <nav class="navbar navbar-default navbar-theme navbar-fixed-top navbar-toggleable-md bg-faded" style="margin-bottom: 0">
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbarNavDropdown">
                    <span class="sr-only" style="border-color: white">Toggle navigation</span>
                    <span class="icon-bar" style="background-color: white; border-color: white"></span>
                    <span class="icon-bar" style="background-color: white; border-color: white"></span>
                    <span class="icon-bar" style="background-color: white; border-color: white"></span>
                </button>
                <a class="navbar-brand" style="color: #ffffff;" href="{{route('homepage.content')}}">
                    <img src="{{asset('image/LetsWw.png')}}" width="auto" height="25" class="d-inline-block align-top" alt="">
                </a>
            </div>

            <div class="collapse navbar-collapse" id="navbarNavDropdown">
                <div class="navbar-right">
                    @if (!Auth::check())
                        <ul class="nav navbar-nav">
                            <li><a href="/login" style="color: white"><span class="glyphicon glyphicon-log-in" style="color: white"></span> Se Connecter</a></li>
                            <li><a href="/register" style="color: white"><span class="glyphicon glyphicon-user" style="color: white"></span> S'inscrire</a></li>
                        </ul>
                    @else
                        <ul class="nav navbar-nav">
                            <li>
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false" style="color: white">
                                    <span class="glyphicon glyphicon-user" style="color: white"></span>{{Auth::user()->name}}
                                </a>
                                <ul class="dropdown-menu" role="menu">
                                    <li>
                                        <a href="/profile/{{\Illuminate\Support\Facades\Auth::user()->slug}}"> <!--AJOUTER LIEN ICI-->
                                            Éditer mon profil
                                        </a>

                                        <a href="{{ route('logout') }}"
                                           onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                            Se déconnecter
                                        </a>

                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                            {{ csrf_field() }}
                                        </form>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    @endif
                </div>
            </div>

        </div>
    </nav>

    @if(\Illuminate\Support\Facades\Auth::check())
        <div id="wrapper">
            <div id="sidebar-wrapper">
                <div id="mySidenav" class="sidenav">
                    <ul style="list-style-type: none">
                        <li class="dropdown">
                            <a href="#">Compagnies</a>
                            <ul class="collapse" style="list-style-type: none">
                                <li><a href="/company">Index</a></li>
                                <li><a href="/company/create">Créer</a></li>
                            </ul>
                        </li>
                        <li><a href="#">About</a></li>
                        <li id="dropdown">
                            <a href="#">Services</a>
                            <ul class="collapse" style="list-style-type: none">
                                <li><a href="">Test1</a></li>
                                <li><a href="">Test2</a></li>
                                <li><a href="">Test3</a></li>
                            </ul>
                        </li>
                        <li><a href="#">Clients</a></li>
                        <li><a href="#">Contact</a></li>
                    </ul>
                </div>
            </div>

            <!-- Page content section -->
            <div id="page-content-wrapper"  style="padding-top: 60px;">
                <div class="page-content">
                    <div class="container-fluid">
                        @yield('content')
                    </div>
                </div>
            </div>
            <!-- End of content section -->
        </div>
    @else
        <div id="body" style="padding-top: 60px;">
            @yield('content')
        </div>
    @endif
@endsection