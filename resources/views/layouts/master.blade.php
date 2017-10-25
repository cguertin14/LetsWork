@extends('layouts.top')

@section('contenu')
    <nav class="navbar navbar-default navbar-theme navbar-fixed-top navbar-toggleable-md bg-faded" style="margin-bottom: 0">
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
            <div class="navbar-right" style="margin-right: 20px">
                @if(Session::has('CurrentCompany'))
                    <ul class="nav navbar-nav" style="margin-right: 10px">
                        <li>
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false" style="color: white">Mon travail</a>
                            <ul class="dropdown-menu" role="menu">
                                <li>
                                    <a id="punch" class="dropdown-toggle" role="button">
                                        {{\App\Tools\Helper::punchMessage(\App\Tools\Helper::hasLastPunch())}}
                                    </a>
                                </li>
                                <li>
                                    <a href="{{route('punch')}}" >Total des heures de travail</a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                @endif
                @if (!Auth::check())
                    <ul class="nav navbar-nav">
                        <li><a href="/login" style="color: white"><span class="glyphicon glyphicon-log-in" style="color: white"></span> Se Connecter</a></li>
                        <li><a href="/register" style="color: white"><span class="glyphicon glyphicon-user" style="color: white"></span> S'inscrire</a></li>
                    </ul>
                @else
                    <ul class="nav navbar-nav" style="margin-right: 10px">
                        <li>
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false" style="color: white">
                                <span class="glyphicon glyphicon-user" style="color: white"></span>&nbsp;{{Auth::user()->fullname}}
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
    </nav>

    @if(\Illuminate\Support\Facades\Auth::check())
        <div id="wrapper">
            <div id="sidebar-wrapper">
                <div id="mySidenav" class="sidenav">
                    <ul style="list-style-type: none;padding-left: 0px;margin-right: 10px">
                        <li>
                            <a id="dropdown1Title" href="#">Compagnies <span id="img1" class="glyphicon glyphicon-chevron-down pull-right" style="margin-top: .2em"></span></a>
                            <ul id="dropdown1" style="list-style-type: none;height: 0px;transition: height 0.5s;overflow: hidden;">
                                <li><a href="/company">Voir tout</a></li>
                                <li><a href="/company/create">Créer</a></li>
                            </ul>
                        </li>
                        <li>
                            <a id="dropdown6Title" href="#">Offres d'emplois <span id="img6" class="glyphicon glyphicon-chevron-down pull-right" style="margin-top: .2em"></span></a>
                            <ul id="dropdown6"  style="list-style-type: none;height: 0px;transition: height 0.5s;overflow: hidden;">
                                <li><a href="{{route('joboffer.index')}}">Voir tout</a></li>
                                @if (Session::has('CurrentCompany'))
                                    @if (Illuminate\Support\Facades\Auth::user()->isOwner())
                                        <li><a href="{{route('joboffer.create')}}">Créer</a></li>
                                    @endif
                                @endif
                            </ul>
                        </li>
                        @if(count(Illuminate\Support\Facades\Auth::user()->companies) > 1)
                        <li>
                            <a  id="dropdown2Title" href="#">@if (!Session::has('CurrentCompany')) Choisir un emploi @else Changer d'emploi @endif<span id="img2" class="glyphicon glyphicon-chevron-down pull-right" style="margin-top: .2em"></span></a>
                            <ul id="dropdown2" style="list-style-type: none;height: 0px;transition: height 0.5s;overflow: hidden;">
                                @foreach(\Illuminate\Support\Facades\Auth::user()->companies as $company)
                                    <li onclick="selectCompany('{{$company->slug}}')"><a href="#">@if(strlen($company->name) > 17){{ substr($company->name,0,17) . '..'}} @else{{$company->name}} @endif</a></li>
                                @endforeach
                            </ul>
                        </li>
                        @endif
                        @if (Session::has('CurrentCompany'))
                            @if (Illuminate\Support\Facades\Auth::user()->isOwner())
                                <li>
                                    <a href="#" id="dropdown3Title">Postes <span id="img3" class="glyphicon glyphicon-chevron-down pull-right" style="margin-top: .2em"></span></a>
                                    <ul id="dropdown3" style="list-style-type: none;height: 0px;transition: height 0.5s;overflow: hidden;">
                                        <li><a href="{{route('specialrole.index')}}">Voir tout</a></li>
                                        <li><a href="{{route('specialrole.create')}}">Créer</a></li>
                                    </ul>
                                </li>
                            @endif
                            <li>
                                <a id="dropdown7Title" href="#">Disponibilités <span id="img7" class="glyphicon glyphicon-chevron-down pull-right" style="margin-top: .2em"></span></a>
                                <ul id="dropdown7" style="list-style-type: none;height: 0px;transition: height 0.5s;overflow: hidden;">
                                    <li><a href="{{route('dispo.index')}}">Voir tout</a></li>
                                    <li><a href="{{route('dispo.create')}}">Créer</a></li>
                                </ul>
                            </li>
                            <li>
                                <a id="dropdown4Title" href="#">Compétences <span id="img4" class="glyphicon glyphicon-chevron-down pull-right" style="margin-top: .2em"></span></a>
                                <ul id="dropdown4" style="list-style-type: none;height: 0px;transition: height 0.5s;overflow: hidden;">
                                    <li><a href="{{route('skill.index')}}">Voir tout</a></li>
                                    @if (Illuminate\Support\Facades\Auth::user()->isOwner())
                                    <li><a href="{{route('skill.create')}}">Créer</a></li>
                                    @endif
                                </ul>
                            </li>
                            <li>
                                <a id="dropdown5Title" href="#">Calendrier <span id="img5" class="glyphicon glyphicon-chevron-down pull-right" style="margin-top: .2em"></span></a>
                                <ul id="dropdown5" style="list-style-type: none;height: 0px;transition: height 0.5s;overflow: hidden;">
                                    <li><a href="{{route('schedule.index')}}">Voir</a></li>
                                    @if (Illuminate\Support\Facades\Auth::user()->isOwner())
                                        <li><a href="{{route('schedule.editing')}}">Modifier</a></li>
                                    @endif
                                </ul>
                            </li>
                            <li><a href="{{route('absence.create')}}">Demande d'absence</a></li>
                            @if (Illuminate\Support\Facades\Auth::user()->isOwner())
                                <li><a href="{{route('jobofferuser.index')}}">Demandes d'emploi</a></li>
                            @endif
                        @endif
                        <li><a href="{{route('cv.create')}}">Dépôt du CV</a></li>
                        <li><a href="{{route('information.aboutus')}}">À Propos</a></li>
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

@section("scriptsm")
    <script>
        $("#punch").click(function () {
            let self = this;
            $.ajax({
                url: '/punch',
                method: 'POST',
                data: { _token: "{{ csrf_token() }}" },
                success: function (data) {
                    if(data == true)
                        $(self).text("{{\App\Tools\Helper::punchMessage(true)}}");
                    else
                        $(self).text("{{\App\Tools\Helper::punchMessage(false)}}");
                }
            });
        })
    </script>
    @yield("scripts")
@endsection