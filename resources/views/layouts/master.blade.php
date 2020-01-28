@extends('layouts.top')

@section('styles')
    <style>
        li {
            margin-right: 1em;
        }
    </style>
@endsection

@section('contenu')
    <nav class="navbar navbar-default navbar-theme navbar-fixed-top navbar-toggleable-md bg-faded" style="margin-bottom: 0">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
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
                @if(Auth::check() && Session::has('CurrentCompany'))
                    <ul class="nav navbar-nav" style="margin-right: 10px">
                        {{--@if (\App\Tools\Helper::CIsEmployee())--}}
                        {{--<li><a href="{{route('chat')}}" style="color: white"><span class="fa fa-comments" aria-hidden="true" style="color: white"></span> Messagerie</a></li>--}}
                        {{--@endif--}}
                        <li><a href="{{route('information.aboutus')}}" style="color: white"><span class="glyphicon glyphicon-question-sign" style="color: white"></span> À Propos</a></li>
                        <li>
                            <a href="#" class="dropdown-toggle " data-toggle="dropdown" role="button" aria-expanded="false" style="color: white"><span class="fa fa-globe" style="color: white"></span> Mon travail</a>
                            <ul class="dropdown-menu" role="menu">
                                <li>
                                    <a id="punch" class="dropdown-toggle" role="button">
                                        {{\App\Tools\Helper::punchMessage(\App\Tools\Helper::hasLastPunch())}}
                                    </a>
                                </li>
                                <li>
                                    <a href="{{route('punch')}}" >Total des heures de travail</a>
                                    @if (\App\Tools\Helper::CCompany() != null && \App\Tools\Helper::CIsHighRanked())
                                        <a href="{{route('punch.employees')}}" >Heures de mes employés</a>
                                    @endif
                                </li>
                            </ul>
                        </li>
                    </ul>
                @endif
                @if (!\Illuminate\Support\Facades\Auth::check())
                    <ul class="nav navbar-nav">
                        <li><a href="{{route('information.aboutus')}}" style="color: white"><span class="glyphicon glyphicon-question-sign" style="color: white"></span> À Propos</a></li>
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
                                    <a href="{{route('profile.edit',\Illuminate\Support\Facades\Auth::user()->slug)}}"> <!--AJOUTER LIEN ICI-->
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

        <div class="modal fade" id="clockInModal" tabindex="-1" role="dialog" aria-hidden="true">
            @component('components.modal')
                @slot('title')
                    Confirmation de début de travail
                @endslot
                @slot('body')
                    <p style="color: white;">Êtes vous sûr(e) de vouloir commencer à travailler?</p>
                @endslot
                @slot('submitbtn')
                    <button type="button" id="confirm" class="btn purplebtn letswork" data-dismiss="modal" style="font-size: 17px !important;">Confirmer</button>
                @endslot
                @slot('events')
                @endslot
            @endcomponent
        </div>

        <div class="modal fade" id="clockOutModal" tabindex="-1" role="dialog" aria-hidden="true">
            @component('components.modal')
                @slot('title')
                    Confirmation de fin de travail
                @endslot
                @slot('body')
                    {!! Form::open(['method' => 'POST','action' => 'PunchController@clockOut','id' => 'clockOutForm']) !!}
                        <div class="form-group">
                            {!! Form::label('task', 'Qu\'avez-vous fait lors de votre période de travail?', ['class' => 'section-title']); !!}
                            <br>
                            {!! Form::textarea('task',null,['class' => 'form-control','id' => 'tasktxt','placeholder' => 'Description de la/les tâche(s) effectuée(s)...','rows' => 3,'required']); !!}
                        </div>
                    {!! Form::submit('Submit',['class' => 'btn','style' => 'display:none','id' => 'submit']) !!}
                    {!! Form::close() !!}
                @endslot
                @slot('submitbtn')
                    <button type="button" id="confirm" class="btn purplebtn letswork clockout" style="font-size: 17px !important;">Confirmer</button>
                @endslot
                @slot('events')
                @endslot
            @endcomponent
        </div>

        <div id="wrapper">
            <div id="sidebar-wrapper">
                <div id="mySidenav" class="sidenav">
                    <ul style="list-style-type: none;padding-left: 0px;margin-right: 10px">
                        <li>
                            <a id="dropdown1Title" href="#">Entreprises <span id="img1" class="glyphicon glyphicon-chevron-down pull-right" style="margin-top: .2em"></span></a>
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
                        @php
                            $jobs = \Illuminate\Support\Facades\Auth::user()->employees()->get()->map(function (\App\Employee $employee) { return $employee->companies()->get()->unique(); })->first();
                            if ($jobs != null) $jobs = $jobs->merge(\Illuminate\Support\Facades\Auth::user()->companies()->get())->unique();
                        @endphp
                        @if($jobs != null && $jobs->count() > 1)
                        <li>
                            <a id="dropdown2Title" href="#">@if (!Session::has('CurrentCompany')) Choisir un emploi @else Changer d'emploi @endif<span id="img2" class="glyphicon glyphicon-chevron-down pull-right" style="margin-top: .2em"></span></a>
                            <ul id="dropdown2" style="list-style-type: none;height: 0px;transition: height 0.5s;overflow: hidden;">
                                @foreach($jobs as $company)
                                    @if ($company->slug !== \App\Tools\Helper::CCompany()->slug)
                                        <li onclick="selectCompany('{{$company->slug}}')"><a href="#">@if(strlen($company->name) > 15){{ substr($company->name,0,15) . '..'}} @else{{$company->name}} @endif</a></li>
                                    @endif
                                @endforeach
                            </ul>
                        </li>
                        @endif
                        @if (Session::has('CurrentCompany'))
                            <li>
                                <a href="#" id="dropdownMyJobTitle">Mon Emploi <span id="imgMyJob" class="glyphicon glyphicon-chevron-down pull-right" style="margin-top: .2em"></span></a>
                                <ul id="dropdownMyJob" style="list-style-type: none;height: 0px;transition: height 0.5s;overflow: hidden; overflow-y:scroll;">
                                    @if (\App\Tools\Helper::CIsHighRanked())
                                        <li>
                                            <a href="#" id="dropdown3Title">Postes <span id="img3" class="glyphicon glyphicon-chevron-down pull-right" style="margin-top: .2em"></span></a>
                                            <ul id="dropdown3" style="list-style-type: none;height: 0px;transition: height 0.5s;overflow: hidden">
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
                                        @if (\App\Tools\Helper::CIsHighRanked())
                                        <li>
                                            <a id="dropdown4Title" href="#">Compétences <span id="img4" class="glyphicon glyphicon-chevron-down pull-right" style="margin-top: .2em"></span></a>
                                            <ul id="dropdown4" style="list-style-type: none;height: 0px;transition: height 0.5s;overflow: hidden;">
                                                <li><a href="{{route('skill.index')}}">Voir tout</a></li>
                                                @if (\App\Tools\Helper::CIsHighRanked())
                                                    <li><a href="{{route('skill.create')}}">Créer</a></li>
                                                @endif
                                            </ul>
                                        </li>
                                    @endif
                                    <li>
                                        <a id="dropdown5Title" href="#">Calendrier <span id="img5" class="glyphicon glyphicon-chevron-down pull-right" style="margin-top: .2em"></span></a>
                                        <ul id="dropdown5" style="list-style-type: none;height: 0px;transition: height 0.5s;overflow: hidden;">
                                            @if (\App\Tools\Helper::CIsHighRanked())
                                                <li><a href="{{route('schedule.editing')}}">Modifier</a></li>
                                            @else
                                                <li><a href="{{route('schedule.index')}}">Voir</a></li>
                                            @endif
                                        </ul>
                                    </li>
                                    <li>
                                        <a id="dropdown8Title" href="#">Absences <span id="img8" class="glyphicon glyphicon-chevron-down pull-right" style="margin-top: .2em"></span></a>
                                        <ul id="dropdown8" style="list-style-type: none;height: 0px;transition: height 0.5s;overflow: hidden;">
                                            <li><a href="{{route('absence.index')}}">Voir tout</a></li>
                                            <li><a href="{{route('absence.create')}}">Créer</a></li>
                                        </ul>
                                    </li>
                                    @if (\App\Tools\Helper::CIsHighRanked())
                                        <li><a href="{{route('employees.index')}}">Mes Employés</a></li>
                                        <li><a href="{{route('jobofferuser.index')}}">Demandes d'emploi</a></li>
                                    @endif
                                </ul>
                            </li>
                        @endif
                        <li><a href="{{route('cv.create')}}">Dépôt du CV</a></li>
                        <li><a href="{{route('information.aboutus')}}">À Propos</a></li>
                        <li style="bottom: 0;position: fixed;background-color: rgba(255, 255, 255, 0.04);line-height: 60px;width: 300px;">
                            <div class="text-center">
                                <span style="color: white;font-family: Ubuntu,sans-serif;font-weight: 500">Confidentialité | © LetsWork 2018</span>
                            </div>
                        </li>
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
        <div id="body" style="padding-top: 60px;overflow-x: hidden">
            @yield('content')
        </div>
    @endif
@endsection

@section("scriptsm")
    <script>
        var cancel = false;
        $('.closeout').click(function (e) {
            cancel = true;
        });
        $('.letswork').click(function (eve) {
            eve.preventDefault();
            cancel = false;
        });
        $('.clockout').click(function (e) {
            e.preventDefault();
            let modal = $('#clockOutModal');
            if (modal.find('#tasktxt').val().trim() !== '') {
                punch();
                modal.find('#clockOutForm').submit(function (e) {
                    $.ajax({
                        method: modal.find('#clockOutForm').attr('method'),
                        url: modal.find('#clockOutForm').attr('action'),
                        data: modal.find('#clockOutForm').serialize(),
                        success: function(data) {
                            modal.modal('hide');
                        }
                    });
                    e.preventDefault();
                    return false;
                });
                modal.find('#submit').trigger('click');
            } else {
                modal.find('#submit').trigger('click');
            }
        });
        let punch = function () {
            if (!cancel) {
                $.ajax({
                    url: '/punch',
                    method: 'POST',
                    data: { _token: "{{ csrf_token() }}" },
                    success: function (data) {
                        if(data.status)
                            $('#punch').text("{{\App\Tools\Helper::punchMessage(true)}}");
                        else
                            $('#punch').text("{{\App\Tools\Helper::punchMessage(false)}}");
                    }
                });
            }
        };
        $('#clockInModal').on('hidden.bs.modal', function () {
            punch();
        });

        $("#punch").click(function () {
            var self = this;
            if (self.text.trim() === '{{\App\Tools\Helper::punchMessage(false)}}') {
                 // Open modal to validate either yes or no employee wants to start working
                $('#clockInModal').modal({backdrop: 'static'});
            } else {
                // Open modal to en shift of current employee with description
                $('#clockOutModal').modal({backdrop: 'static'});
            }
        })
    </script>
    @yield('scripts')
@endsection
