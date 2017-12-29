@extends('layouts.top')

@section('styles')
    <style>
        .footer {
            position: relative;
            visibility: visible;
        }
        .caption > a {
            font-family: 'Ubuntu',sans-serif;
            font-weight: 600;
        }

        .caption > .border {
            font-family: 'Ubuntu',sans-serif;
            font-weight: 600;
        }

        .headerText > h3 {
            font-family: 'Montserrat',sans-serif;
            font-weight: 600;
        }

        .headerText > h3 > small {
            font-family: 'Montserrat',sans-serif;
            font-weight: 700;
        }

        .headerText > h2 {
            font-family: 'Montserrat',sans-serif;
        }

        .headerText > p {
            font-size: 1.2em;
            font-family: 'Ubuntu',sans-serif;
        }
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

    <div class="headerText" style="color: #777;background-color:white;text-align:center;padding:50px 80px;text-align: justify;">
        <h3 style="text-align:center;">Qu'est-ce que LetsWork?</h3>
        <br>
        <p style="text-align: justify">Notre projet est une application web destinée aux entreprises et aux particuliers voulant un ou des employés. Notre application fournit à ces derniers des outils permettant de gérer l’embauche et la gestion d’employés (incluant le système d’absences, de congés, de paies, de consultation d’horaires, de fabrication d’horaires, et bien plus). Les employeurs utilisant notre application pourront créer une page de promotion pour leurs entreprises où figureront leurs offres d’emplois. Les visiteurs parcourant ces pages auront la possibilité d’appliquer directement en ligne sans se connecter, en remplissant un formulaire. L’employeur recevra dans son centre de notifications la demande d'emploi et pourra choisir s’il l’accepte ou pas. Le visiteur recevra, suivant la réponse de l’employeur, une réponse par email lui offrant de se créer un compte pour continuer sa demande d’emploi. De plus, notre application web peut être utilisée pour la recherche d'emploi et pour simplement travailler plus facilement, donc pour un employé ou un simple utilisateur.</p>
    </div>

    <div class="bgimg-3"></div>

    <div style="position:relative;">
        <div class="headerText"  style="color: #777;background-color:white;text-align:center;padding:50px 80px;text-align: justify;">
            <h3 style="text-align:center;">Qu'est-ce que LetsWork permet de faire?</h3>
            <br>
            <h2>Expérience utilisateur</h2>
            <br>
            <p>Pour ce qui est des fonctionnalités de l’application, tout d’abord un utilisateur du site web arrivera sur la page d’accueil qui contiendra des annonces d’entreprises embauchant. À ce moment, l’usager pourra soit se connecter, s’inscrire (en tant qu’entreprise ou employé), envoyer une demande d’emploi ou consulter les informations d’une entreprise. Ensuite, une fois connecté, si l’utilisateur est un employé, il pourra consulter son horaire ainsi celui de ses collègues, communiquer avec son supérieur, communiquer avec un autre employé (par exemple pour échanger des heures de travail), faire des demandes d’absences/congés, avoir un système de punch et finalement avoir un calendrier avec tous les congés, absences, heures travaillées par intervalles de temps, etc.</p>
            <br>
            <br>
            <br>
            <h2 style="text-align: right">Patron de compagnie</h2>
            <br>
            <p style="text-align: right;text-justify: auto">Du côté du Manager (patron), ce dernier peut fabriquer une page de présentation pour son entreprise et ajouter des emplois disponible à celle-ci. Il peut aussi consulter ses notifications de demandes d’emplois dans la barre des tâches. La barre des tâches lui permet de prioriser ce qu’il doit faire pour ensuite effectuer la gestion de ses employés. Par exemple, engager un autres employé pour répondre aux besoins minimum de son entreprise. Il peut aussi fabriquer l’horaire des employés à l'aide d'un clic. L’employeur indiquera le nombre d'employés minimum qu’il a besoin à des heures spécifiques et le nombre d’heures minimum de chaque employé. À partir de cela, l’application fabriquera un horaire de travail selon les besoins de l’employeur, les disponibilités des employés, le rôle de chaque employé, les congés demandés ainsi que d’autres paramètres au choix de l’employeur. Par exemple, Sam ne peut pas travailler en même temps que Joe puisque ces derniers ne s’entendent pas bien.</p>
        </div>
    </div>

    <div class="bgimg-4"></div>

    <div style="position:relative;">
        <div class="headerText"  style="color:#ddd;background-color:#282E34;text-align:center;padding:50px 80px;text-align: justify;">
            <h3 style="text-align:center;color: #ffffff;">Qui fait partie de notre équipe?</h3>
            <br>
            <br>
            <!-- Team Members Row -->
            <div class="text-center">
                <div class="row" style="width: 100%;">
                    <div class="col-lg-6 col-sm-6 text-center mb-4 headerText" style="margin: 0 auto;">
                        <img class="rounded-circle img-fluid d-block mx-auto" height="300" width="300" src="{{asset('image/charles.jpg')}}" alt="">
                        <h3 style="color: #a5a4a4;font-weight: 800">Charles Guertin</h3>
                        <h3 style="margin: 0;"><small>Développeur Full-Stack</small></h3>
                        <br>
                        <a target="_blank" href="https://www.linkedin.com/in/charles-guertin-495b6520/" class="fa fa-linkedin"></a>
                        <a href="mailto:charlesguertin@live.ca" class="fa fa-envelope"></a>
                        <br>
                        <br>
                        <p>Je suis un jeune développeur passionné d'informatique. J'adore apprendre de nouvelles technologies, utiliser des environnements de travail rapides, travailler en temps réel (Client/Serveur). Travailler en équipe et bien communiquer est une priorité pour moi, car sinon, un projet ne peut pas avoir de succès. Mon but principal est de toujours me dépasser afin d'être le meilleur développeur possible.</p>
                    </div>
                    <div class="col-lg-6 col-sm-6 text-center mb-4 headerText" style="margin: 0 auto;">
                        <img class="rounded-circle img-fluid d-block mx-auto"  height="300" width="300"  src="{{asset('image/ludo.jpg')}}" alt="">
                        <h3 style="color: #a5a4a4;font-weight: 800">Ludovic Lachance</h3>
                        <h3 style="margin: 0;"><small>Développeur Full-Stack</small></h3>
                        <br>
                        <a target="_blank" href="https://www.linkedin.com/in/ludovic-lachance/" class="fa fa-linkedin"></a>
                        <a href="mailto:ludovic.lachance@gmail.com" class="fa fa-envelope"></a>
                        <br>
                        <br>
                        <p>Ludovic Lachance. Étudiant en informatique depuis 3 ans, j'ai appris à maîtriser plusieurs languages me permettant d'imbriquer dans un projet plusieurs parties écrites avec des techniques différentes communiquantes de façon asynchrome en temps réel. J'adore l'informatique, car ça me permet de comprendre le monde qui m'entoure de façons plus précises.</p>
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
                {{--<a href="{{route('information.userguide')}}" style="text-decoration: none">Guide de l'utilisateur<span class="fa fa-arrow-right"></span></a>--}}
                {{--<br>--}}
                <a href="{{route('homepage.content')}}" style="text-decoration: none"><span class="fa fa-arrow-left"></span>Revenir à l'accueil</a>
            </div>
        </div>
    </div>

@endsection