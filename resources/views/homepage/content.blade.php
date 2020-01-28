@extends('layouts.master')

@section('styles')
    <style>
        body {
            @if(!\Illuminate\Support\Facades\Auth::check())
                 background-image: url({{asset('image/WelcomePage.jpg')}});
                 background-position: 0 40px;
                 overflow-y: hidden;
            @else
                 background-color: #5d5d5d;
            @endif
        }

        /* Main marketing message and sign up button */
        .jumbotron {
            font-family: 'Montserrat',sans-serif;
            text-align: center;
            background-color: rgba(0,0,0,0.5);
        }

        .jumbotron > p {
            font-family: 'Ubuntu',sans-serif;
        }

        .jumbotron .btn {
            padding: 14px 24px;
            font-size: 21px;
        }

        .col-lg-4 > h2 {
            font-family: 'Montserrat',sans-serif;
        }
        .col-lg-4 > p {
            font-family: 'Ubuntu',sans-serif;
            font-size: 1.2em;
            text-align: justify;
        }

        .col-lg-6 > h2 {
            font-family: 'Montserrat',sans-serif;
        }
        .col-lg-6 > p {
            font-family: 'Ubuntu',sans-serif;
            font-size: 1.2em;
            line-height: 1.7em;
            text-align: justify;
        }

        .centre h1, p,h2,a {
            color: #ffffff;
        }
    </style>
@endsection

@section('content')
    @if(!\Illuminate\Support\Facades\Auth::check())
        <div class="outer">
            <div class="middle">
                <div class="inner">
                    <div class="container">
                        <div class="text-center" style="margin-bottom: 20%">
                            <p class="title1" style="font-family: 'Montserrat',sans-serif;font-weight: 500">Cherchez, appliquez <br> et travaillez</p>
                            <p class="title2" style="font-family: 'Ubuntu',sans-serif;">
                                Grâce à une application web polyvalente <br> permettant la gestion de votre milieu <br> de travail
                            </p>
                            <div class="form-group" style="margin-top: 40px">
                                <a href="/company">
                                    <button type="button" class="btn purplebtn" role="button">
                                        Commencer à chercher les entreprises
                                    </button>
                                </a>
                            </div>
                            <a href="/company/create" class="link" style="font-family: 'Montserrat',sans-serif;text-decoration: none !important;color:black!important;">ou créez votre propre entreprise</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @else

        <div class="layout">
            <div class="centre" style="margin-bottom: 10px">
                <!-- Jumbotron -->
                <div class="jumbotron" style="margin-top: 10%">
                    <h1 class="welcome" style="font-weight: 500;font-size:3em">Bienvenue, {{\Illuminate\Support\Facades\Auth::user()->fullname}}</h1>
                    <p class="lead">Toute l'équipe de LetsWork vous souhaite la bienvenue dans notre application web. Nous espérons que vous saurez vous l'approprier!</p>
                    <br>
                    <p><a id="bigbtn" class="btn btn-lg purplebtn" style="font-size: 20px!important;" href="{{route('company.index')}}" role="button">Voir les compagnies</a></p>
                </div>

                <!-- Example row of columns -->
                <div class="row">
                    @if (\App\Tools\Helper::CCompany() != null)
                        <div class="col-lg-4"  style="overflow: hidden">
                            <h2>Curriculum Vitae</h2>
                            <p>Pour trouver un emploi, il est primordial pour un candidat faire un curriculum vitae pour se vanter. Déposez votre CV et magasinez les emplois disponibles.</p>
                            <p><a class="btn purplebtn" href="{{route('cv.create')}}" role="button">Déposer mon cv &raquo;</a></p>
                        </div>
                        <div class="col-lg-4" style="overflow: hidden">
                            <h2>Calendrier</h2>
                            <p>En tant qu'employé, que vous soyez un caissier ou un directeur, il va de soi qu'il est essentiel pour vous de visualiser votre calendrier ou même de le modifier.</p>
                            <p><a class="btn purplebtn" href="@if(\App\Tools\Helper::CIsHighRanked()) {{route('schedule.editing')}} @else {{route('schedule.index')}} @endif" role="button">@if(\App\Tools\Helper::CIsHighRanked()) Modifier le calendrier @else Visualiser le calendrier @endif &raquo;</a></p>
                        </div>
                        <div class="col-lg-4"  style="overflow: hidden">
                            <h2>À propos</h2>
                            <p>LetsWork est une entreprise offrant ses services pour vous faciliter la vie que ce soit pour la recherche d'emploi, la gestion d'employés et bien plus. Pour en savoir plus, nous vous avons préparé une section du site pour vous parler de nous.</p>
                            <p><a class="btn purplebtn" href="{{route('information.aboutus')}}" role="button">À propos &raquo;</a></p>
                        </div>
                    @else
                        <div class="col-lg-6"  style="overflow: hidden">
                            <h2>Curriculum Vitae</h2>
                            <p>Pour trouver un emploi, il est primordial pour un candidat faire un curriculum vitae pour se vanter. Déposez votre CV et magasinez les emplois disponibles.</p>
                            <p><a class="btn purplebtn" href="{{route('cv.create')}}" role="button">Déposer mon cv &raquo;</a></p>
                        </div>
                        <div class="col-lg-6"  style="overflow: hidden">
                            <h2>À propos</h2>
                            <p>LetsWork est une entreprise offrant ses services pour vous faciliter la vie que ce soit pour la recherche d'emploi, la gestion d'employés et bien plus. Pour en savoir plus, nous vous avons préparé une section du site pour vous parler de nous.</p>
                            <p><a class="btn purplebtn" href="{{route('information.aboutus')}}" role="button">À propos &raquo;</a></p>
                        </div>
                    @endif
                </div>

            </div> <!-- /container -->
        </div>

    @endif
@endsection

@section('scripts')
    <script>
        function onChange() {
            let mq = window.matchMedia("screen and (min-width: 985px)"),
                mq2 = window.matchMedia("screen and (min-width: 805px)"),
                mq3 = window.matchMedia("screen and (min-width: 912px)"),
                mq4 = window.matchMedia("screen and (max-width: 767px)");
            if (!mq.matches) {
                $('.welcome').css({
                   fontSize: '3em'
                });
            }

            if (!mq2.matches) {
                $('.welcome').css({
                    fontSize: '2em'
                });
            } else {
                $('.welcome').css({
                    fontSize: '3em'
                });
            }

            @if (\Illuminate\Support\Facades\Auth::check())
            if (!mq3.matches) {
                $('#bigbtn')[0].style.setProperty('font-size','16px','important');
            } else {
                $('#bigbtn')[0].style.setProperty('font-size','20px','important');
            }

            if (mq4.matches) {
                $('#bigbtn')[0].style.setProperty('font-size','20px','important');
            }
            @endif
        }

        onChange();

        $(window).resize(function () {
            onChange();
        });
    </script>
@endsection