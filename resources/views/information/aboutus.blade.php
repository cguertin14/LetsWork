@extends('layouts.top')

@section('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <style>
        .fa {
            padding: 20px !important;
            font-size: 30px !important;
            width: 70px !important;
            text-align: center !important;
            text-decoration: none !important;
            margin: 5px 2px !important;
            border-radius: 50% !important;
        }

        .fa:hover {
            opacity: 0.7 !important;
        }

        .fa-linkedin {
            background: #007bb5 !important;
            color: white !important;
        }

        .fa-envelope {
            background: #552AD6 !important;
            color: white !important;
        }
        body, html {
            height: 100%;
            margin: 0;
            font: 400 15px/1.8 "Lato", sans-serif;
            color: #777;
        }

        .bgimg-1, .bgimg-2, .bgimg-3, .bgimg-4 {
            position: relative;
            opacity: 0.65;
            background-attachment: fixed;
            background-position: center;
            background-repeat: no-repeat;
            background-size: cover;

        }
        .bgimg-1 {
            background-image: url("{{asset('image/office.jpg')}}");
            min-height: 100%;
        }

        .bgimg-2 {
            background-image: url("{{asset('image/office2.jpg')}}");
            min-height: 400px;
        }

        .bgimg-3 {
            background-image: url("{{asset('image/office3.jpg')}}");
            min-height: 400px;
        }

        .bgimg-4 {
            background-image: url("{{asset('image/office4.jpg')}}");
            min-height: 400px;
        }

        .caption {
            position: absolute;
            left: 0;
            top: 50%;
            width: 100%;
            text-align: center;
            color: #000;
        }

        .caption span.border {
            background-color: #111;
            color: #fff;
            padding: 18px;
            font-size: 25px;
            letter-spacing: 10px;
        }

        .caption a {
            background-color: #111;
            color: #fff;
            padding: 18px;
            font-size: 25px;
            letter-spacing: 10px;
        }

        h3 {
            letter-spacing: 5px;
            text-transform: uppercase;
            font: 20px "Lato", sans-serif;
            color: #111;
        }

        /* Turn off parallax scrolling for tablets and phones */
        @media only screen and (max-device-width: 1024px) {
            .bgimg-1, .bgimg-2, .bgimg-3, .bgimg-4 {
                background-attachment: scroll;
            }
        }


    </style>
@endsection

@section('contenu')

    <div class="bgimg-1">
        <div class="caption">
            <span class="border">LetsWork • À Propos</span>
        </div>
    </div>

    <div style="color: #777;background-color:white;text-align:center;padding:50px 80px;text-align: justify;">
        <h3 style="text-align:center;">Qu'est-ce que LetsWork?</h3>
        <br>
        <p>Notre projet est une application web destinée aux entreprises et aux particuliers voulant un ou des employés. Notre application fournit à ces derniers des outils permettant de gérer l’embauche et la gestion d’employés (incluant le système d’absences, de congés, de paies, de consultation d’horaires, de fabrication d’horaires, et bien plus). Les employeurs utilisant notre application pourront créer une page de promotion pour leurs entreprises où figureront leurs offres d’emplois. Les visiteurs parcourant ces pages auront la possibilité d’appliquer directement en ligne sans se connecter, en remplissant un formulaire. L’employeur recevra dans son centre de notifications la demande d'emploi et pourra choisir s’il l’accepte ou pas. Le visiteur recevra, suivant la réponse de l’employeur, une réponse par email lui offrant de se créer un compte pour continuer sa demande d’emploi.</p>
        <br>
        <p>De plus, notre application web peut être utilisée pour la recherche d'emploi et pour simplement travailler plus facilement, donc pour un employé ou un simple utilisateur.</p>
    </div>

    <div class="bgimg-2">
        {{--<div class="caption">
            <span class="border" style="background-color:transparent;font-size:25px;color: #f7f7f7;">LESS HEIGHT</span>
        </div>--}}
    </div>

    <div style="position:relative;">
        <div style="color:#ddd;background-color:#282E34;text-align:center;padding:50px 80px;text-align: justify;">
            <h3 style="text-align:center;color: #ffffff;">Quelles sont les technologies que nous utilisons?</h3>
            <br>
            <p class="text-center">LetsWork est écrit en PHP à l’aide du framework Laravel 5.5 (ou plus récent), avec l’aide d’une base de données MySql et d’outils tels que JavaScript 5, jQuery, Vue.js, CSS 3, HTML 5, Laravel Blade, NodeJS, etc.</p>
            <p class="text-center">Nos développeurs utilisent les dernières technologies sur le marché afin d'obtenir une rapidité optimale et de toujours innover.</p>
            <br>
            <br>
            <div class="row">
                <div class="text-center">
                    <img src="{{asset('image/nodejs.png')}}" alt="" width="400" height="250">
                    <img src="{{asset('image/jquery.png')}}" alt="" width="250" height="250">
                    <img src="{{asset('image/js.png')}}" alt="" width="250" height="250">
                    <img src="{{asset('image/CSS3.png')}}" alt="" width="200" height="250">
                    <img src="{{asset('image/html5.png')}}" alt="" width="200" height="250">
                </div>
            </div>
            <br>
            <div class="row">
                <div class="text-center">
                    <img src="{{asset('image/laravel.png')}}" alt="" width="350" height="200">
                    <img src="{{asset('image/mysql.png')}}" alt="" width="350" height="250" style="margin-left: 3em;">
                    <img src="{{asset('image/blade.png')}}" alt="" width="370" height="200">
                    <img src="{{asset('image/vue.png')}}" alt="" width="350" height="350">
                </div>
            </div>
        </div>
    </div>

    <div class="bgimg-3">
        {{--<div class="caption">
            <span class="border" style="background-color:transparent;font-size:25px;color: #f7f7f7;"></span>
        </div>--}}
    </div>

    <div style="position:relative;">
        <div style="color: #777;background-color:white;text-align:center;padding:50px 80px;text-align: justify;">
            <h3 style="text-align:center;">Qu'est-ce que LetsWork permet de faire?</h3>
            <br>
            <h2>Expérience utilisateur</h2>
            <p>Pour ce qui est des fonctionnalités de l’application, tout d’abord un utilisateur du site web arrivera sur la page d’accueil qui contiendra des annonces d’entreprises embauchant. À ce moment, l’usager pourra soit se connecter, s’inscrire (en tant qu’entreprise ou employé), envoyer une demande d’emploi ou consulter les informations d’une entreprise. Ensuite, une fois connecté, si l’utilisateur est un employé, il pourra consulter son horaire ainsi celui de ses collègues, communiquer avec son supérieur, communiquer avec un autre employé (par exemple pour échanger des heures de travail), faire des demandes d’absences/congés, avoir un système de punch et finalement avoir un calendrier avec tous les congés, absences, heures travaillées par intervalles de temps, etc.</p>
            <br>
            <h2>Patron de compagnie</h2>
            <p>Du côté du Manager (patron), ce dernier peut fabriquer une page de présentation pour son entreprise et ajouter des emplois disponible à celle-ci. Il peut aussi consulter ses notifications de demandes d’emplois dans la barre des tâches. La barre des tâches lui permet de prioriser ce qu’il doit faire pour ensuite effectuer la gestion de ses employés. Par exemple, engager un autres employé pour répondre aux besoins minimum de son entreprise. Il peut aussi fabriquer l’horaire des employés à l'aide d'un clic. L’employeur indiquera le nombre d'employés minimum qu’il a besoin à des heures spécifiques et le nombre d’heures minimum de chaque employé. À partir de cela, l’application fabriquera un horaire de travail selon les besoins de l’employeur, les disponibilités des employés, le rôle de chaque employé, les congés demandés ainsi que d’autres paramètres au choix de l’employeur. Par exemple, Sam ne peut pas travailler en même temps que Joe puisque ces derniers ne s’entendent pas bien.</p>
        </div>
    </div>

    <div class="bgimg-4">
        {{--<div class="caption">
            <span class="border" style="background-color:transparent;font-size:25px;color: #f7f7f7;"></span>
        </div>--}}
    </div>

    <div style="position:relative;">
        <div style="color:#ddd;background-color:#282E34;text-align:center;padding:50px 80px;text-align: justify;">
            <h3 style="text-align:center;color: #ffffff;">Qui fait partie de notre équipe?</h3>
            <br>
            <br>
            <!-- Team Members Row -->
            <div class="text-center">
                <div class="row" style="width: 100%;">
                    <div class="col-lg-4 col-sm-6 text-center mb-4" style="margin: 0 auto;">
                        <img class="rounded-circle img-fluid d-block mx-auto" height="300" width="300" src="{{asset('image/charles.jpg')}}" alt="">
                        <h3 style="color: #a5a4a4;">Charles Guertin
                            <small>Développeur Full-Stack</small>
                        </h3>
                        <a target="_blank" href="https://www.linkedin.com/in/charles-guertin-495b6520/" class="fa fa-linkedin"></a>
                        <a href="mailto:charlesguertin@live.ca" class="fa fa-envelope"></a>
                        <p>Je suis un jeune développeur de 19 ans passionné d'informatique. J'adore apprendre de nouvelles technologies, utiliser des environnements de travail rapides, travailler en temps réel (Client/Serveur). Travailler en équipe et bien communiquer est une priorité pour moi, car sinon, un projet ne peut pas avoir de succès. Mon but principal est de toujours me dépasser afin d'être le meilleur développeur possible.</p>
                    </div>
                    <div class="col-lg-4 col-sm-6 text-center mb-4" style="margin: 0 auto;">
                        <img class="rounded-circle img-fluid d-block mx-auto"  height="300" width="300"  src="http://placehold.it/300x300" alt="">
                        <h3 style="color: #a5a4a4;">Ludovic Lachance
                            <small>Développeur Full-Stack</small>
                        </h3>
                        <a target="_blank" href="https://www.linkedin.com/in/ludovic-lachance/" class="fa fa-linkedin"></a>
                        <a href="mailto:" class="fa fa-envelope"></a>
                        <p>Ludovic Lachance. 21 ans. Étudiant en informatique depuis 3 ans, j'ai appris à maîtriser plusieurs languages me permettant d'imbriquer dans un projet plusieurs parties écrites avec des techniques différentes communiquantes de façon asynchrome en temps réel. J'adore l'informatique, car ça me permet de comprendre le monde qui m'entoure de façons plus précises.</p>
                    </div>
                    <div class="col-lg-4 col-sm-6 text-center mb-4" style="margin: 0 auto;">
                        <img class="rounded-circle img-fluid d-block mx-auto"  height="300" width="300" src="{{asset('image/phil.jpg')}}" alt="">
                        <h3 style="color: #a5a4a4;">Philippe Simard
                            <small>Superviseur de projet</small>
                        </h3>
                        <a target="_blank" href="https://www.linkedin.com/in/philippesimard/" class="fa fa-linkedin"></a>
                        <a href="mailto:Philippe.simard@clg.qc.ca" class="fa fa-envelope"></a>
                        <p>En tant que superviseur de projet, Philippe est un excellent conseiller informatique qui suit le progrès et l'avancement du développement de LetsWork. En plus de nous donner de bonnes idées, M. Simard est un excellent coach qui nous permet toujours d'aller plus loin.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="bgimg-1">
        <div class="caption">
            <span class="border">Voilà! Amusez vous.</span>
            <div class="caption">
                <br>
                <br>
                <br>
                <a href="{{route('homepage.content')}}" style="text-decoration: none">Revenir à l'accueil</a>
            </div>
        </div>
    </div>

@endsection