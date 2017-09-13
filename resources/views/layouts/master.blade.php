@extends('layouts.top')

@section('styles')
    <style>

    </style>
@endsection

@section('contenu')
    <nav class="navbar navbar-default navbar-theme navbar-static-top navbar-toggleable-md bg-faded" style="margin-bottom: 0">
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
                <div class="nav navbar-nav navbar-right">
                    @if (!Auth::check())
                        <ul class="nav navbar-nav mr-auto">
                            <li><a href="/login" style="color: white"><span class="glyphicon glyphicon-log-in" style="color: white"></span> Se Connecter</a></li>
                            <li><a href="/register" style="color: white"><span class="glyphicon glyphicon-user" style="color: white"></span> S'inscrire</a></li>
                        </ul>
                    @else
                        <ul class="nav navbar-nav mr-auto">
                            <li>
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false" style="color: white">
                                    <span class="glyphicon glyphicon-user" style="color: white"></span>{{Auth::user()->name}}
                                </a>
                                <ul class="dropdown-menu" role="menu">
                                    <li>
                                        <a href="/profile"> <!--AJOUTER LIEN ICI-->
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
                <ul class="nav">
                    <li style="width: 100%;">
                        <a href="#">Categories<span class="glyphicon glyphicon-chevron-down pull-right"></span></a>
                        <ul class="nav nav-second-level collapse">
                            <li>
                                <a href="flot.html">Flot Charts</a>
                            </li>
                            <li>
                                <a href="morris.html">Morris.js Charts</a>
                            </li>
                        </ul>
                        <!-- /.nav-second-level -->
                    </li>
                </ul>
            </div>

            <!-- Page content section -->
            <div id="page-content-wrapper">
                <div class="page-content">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-md-12">
                                @yield('content')
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End of content section -->
        </div>
    @else
        <div id="body">
            @yield('content')
        </div>
    @endif


    <script src="https://npmcdn.com/tether@1.2.4/dist/js/tether.min.js"></script>
    <script src="https://npmcdn.com/bootstrap@4.0.0-alpha.6/dist/js/bootstrap.min.js"></script>
    <script src="{{asset('js/libs.js')}}"></script>
    @yield('scripts')
@endsection