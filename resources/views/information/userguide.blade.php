@extends('layouts.top')

@section('styles')
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
    body, html {
        height: 100%;
        margin: 0;
        font: 400 15px/1.8 "Lato", sans-serif;
        color: #777;
    }

    .header-img,.bgimg-1, .bgimg-2, .bgimg-3,
    .bgimg-4,.bgimg-5, .bgimg-6, .bgimg-7,
    .bgimg-7,.bgimg-8, .bgimg-9, .bgimg-10,
    .bgimg-11, .bgimg-12, .bgimg-13, .bgimg-14,
    .bgimg-15, .bgimg-16, .bgimg-17, .bgimg-18,
    .bgimg-19,.bgimg-20, .bgimg-21, .bgimg-22, .bgimg-23 {
        position: relative;
        opacity: 0.7;
        background-attachment: fixed;
        background-repeat: no-repeat;
        background-size: auto;
        background-position: 1% 1%;
    }

    .header-img {
        background-image: url("{{asset('image/howto.png')}}");
        min-height: 100%;
        background-position: center;
    }

    .bgimg-1 {
        background-image: url("{{asset('image/howto/homepage(not connected).png')}}");
        min-height: 500px;
    }

    .bgimg-2 {
        background-image: url("{{asset('image/howto/homepage(connected).png')}}");
        min-height: 500px;
    }

    .bgimg-3 {
        background-image: url("{{asset('image/howto/creation company.png')}}");
        min-height: 500px;
    }

    .bgimg-4 {
        background-image: url("{{asset('image/howto/creationpostes.png')}}");
        min-height: 500px;
    }

    .bgimg-5 {
        background-image: url("{{asset('image/howto/creationoffreemploi.png')}}");
        min-height: 500px;
    }

    .bgimg-6 {
        background-image: url("{{asset('image/howto/demandeemploi.png')}}");
        min-height: 500px;
    }

    .bgimg-7 {
        background-image: url("{{asset('image/howto/depotcv.png')}}");
        min-height: 500px;
    }

    .bgimg-8 {
        background-image: url("{{asset('image/howto/donnerdispo.png')}}");
        min-height: 500px;
    }

    .bgimg-9 {
        background-image: url("{{asset('image/howto/heures de travaille.png')}}");
        min-height: 500px;
    }

    .bgimg-10 {
        background-image: url("{{asset('image/howto/top1.png')}}");
        min-height: 500px;
        background-position: center !important;
    }

    .bgimg-11 {
        background-image: url("{{asset('image/howto/editer le profil.png')}}");
        min-height: 500px;
    }

    .bgimg-12 {
        background-image: url("{{asset('image/howto/applyoffer.png')}}");
        min-height: 500px;
    }

    .bgimg-13 {
        background-image: url("{{asset('image/howto/inscription.png')}}");
        min-height: 500px;
    }

    .bgimg-14 {
        background-image: url("{{asset('image/howto/login.png')}}");
        min-height: 500px;
    }

    .bgimg-15 {
        background-image: url("{{asset('image/howto/list offre emploi.png')}}");
        min-height: 500px;
    }

    .bgimg-16 {
        background-image: url("{{asset('image/howto/list_company.png')}}");
        min-height: 500px;
    }

    .bgimg-17 {
        background-image: url("{{asset('image/howto/listposte.png')}}");
        min-height: 500px;
    }

    .bgimg-18 {
        background-image: url("{{asset('image/howto/voir list.png')}}");
        min-height: 500px;
    }

    .bgimg-19 {
        background-image: url("{{asset('image/howto/top2.png')}}");
        background-position: center !important;
        min-height: 500px;
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
        .header-img,.bgimg-1, .bgimg-2, .bgimg-3,
        .bgimg-4,.bgimg-5, .bgimg-6, .bgimg-7,
        .bgimg-7,.bgimg-8, .bgimg-9, .bgimg-10,
        .bgimg-11, .bgimg-12, .bgimg-13, .bgimg-14,
        .bgimg-15, .bgimg-16, .bgimg-17, .bgimg-18,
        .bgimg-19,.bgimg-20, .bgimg-21, .bgimg-22, .bgimg-23 {
            background-attachment: scroll;
        }
    }


</style>
@endsection

@section('contenu')

    <div class="header-img">
        <div class="caption">
            <span class="border">LetsWork • Guide de l'utilisateur</span>
        </div>
    </div>

    <div style="color: #777;background-color:white;text-align:center;padding:50px 80px;text-align: justify;">
        <h3 style="text-align:center;">Page d'accueil</h3>
        <br>
        <p>Depuis la page d'accueil, vous pouvez accéder facilement à la recherche d'entreprises ainsi qu'à la création d'entreprises.  Cela vous permet de commencer à utiliser Let’s Work le plus vite possible.  Vous avez aussi accès à l'aide à l’utilisateur par l'onglet "À propos" situé en haut à droite de la fenêtre.  Les options d'inscription et de connexion ont aussi un onglet dans la barre du haut.</p>
    </div>

    <div class="bgimg-1"></div>

    <div style="position:relative;">
        <div style="color:#ddd;background-color:#282E34;text-align:center;padding:50px 80px;text-align: justify;">
            <h3 style="text-align:center;color: #ffffff;">Page de bienvenue</h3>
            <br>
            <p>Depuis la page de bienvenue du site web Let’s Work, vous avez accès à l'intégralité des fonctionnalités offertes par Let’s Work.
                La barre verticale de gauche permet d'atteindre les fonctionnalités reliées aux entreprises, le but principal de Let’s Work.
                La barre horizontale permet d'accéder rapidement aux options de votre compte ainsi qu’à vos heures de travail.</p>
        </div>
    </div>

    <div class="bgimg-2"></div>

    <div style="color: #777;background-color:white;text-align:center;padding:50px 80px;text-align: justify;">
        <h3 style="text-align:center;">Création d'entreprise</h3>
        <br>
        <p class="text-center">Étant un utilisateur de Let’s Work, vous avez le privilège de vous créer un compte de gestion d'entreprise d'où vous pourrez gérer toutes les futures interactions que vous aurez avec vos employés.</p>
    </div>

    <div class="bgimg-3"></div>

    <div style="position:relative;">
        <div style="color:#ddd;background-color:#282E34;text-align:center;padding:50px 80px;text-align: justify;">
            <h3 style="text-align:center;color: #ffffff;">Création de poste</h3>
            <br>
            <p>Ici, vous pourrez créer un poste à partir des compétences que vous aurez préalablement créées.  Ce poste peut être associé à un certain rôle de l'entreprise pour permettre aux futurs gestionnaires de votre entreprise d'accéder à différentes parties du site web, ce qui facilite la gestion des employés.</p>
        </div>
    </div>

    <div class="bgimg-4"></div>

    <div style="color: #777;background-color:white;text-align:center;padding:50px 80px;text-align: justify;">
        <h3 style="text-align:center;">Création d'offre d'emploi</h3>
        <br>
        <p class="text-center">Après avoir créé le poste qu'un employé occupera, vous pourrez créer une offre d'emploi reliée à celui-ci.</p>
    </div>

    <div class="bgimg-5"></div>

    <div style="position:relative;">
        <div style="color:#ddd;background-color:#282E34;text-align:center;padding:50px 80px;text-align: justify;">
            <h3 style="text-align:center;color: #ffffff;">Demandes d'emploi</h3>
            <br>
            <p class="text-center">Lorsqu'un individu applique sur une des offres d'emploi, vous pourrez le voir dans la fenêtre des demandes d'emploi.  Vous pourrez voir le C.V. ainsi que les coordonnées de l'individu en question pour pouvoir facilement le rejoindre.</p>
        </div>
    </div>

    <div class="bgimg-6"></div>

    <div style="color: #777;background-color:white;text-align:center;padding:50px 80px;text-align: justify;">
        <h3 style="text-align:center;">Dépôt du curriculum vitae</h3>
        <br>
        <p class="text-center">Vous pouvez facilement déposer votre C.V. sur le site web pour le transmettre aux entreprises de votre choix.  Le C.V. est à tout moment interchangeable.</p>
    </div>

    <div class="bgimg-7"></div>

    <div style="position:relative;">
        <div style="color:#ddd;background-color:#282E34;text-align:center;padding:50px 80px;text-align: justify;">
            <h3 style="text-align:center;color: #ffffff;">Donner ses Disponibilités</h3>
            <br>
            <p class="text-center">Lorsque vous serez engagé(e) dans une entreprise, n’oubliez pas de transmettre vos disponibilités de travail pour que votre patron puisse savoir quand vous pourrez travailler.</p>
        </div>
    </div>

    <div class="bgimg-8"></div>

    <div style="color: #777;background-color:white;text-align:center;padding:50px 80px;text-align: justify;">
        <h3 style="text-align:center;">Périodes de travail</h3>
        <br>
        <p class="text-center">Vous pouvez ici voir combien d'heures vous avez travaillées durant la dernière semaine, le dernier mois ou la dernière année.  Toutes les périodes de travail sont aussi visibles clairement.</p>
    </div>

    <div class="bgimg-9"></div>

    <div style="position:relative;">
        <div style="color:#ddd;background-color:#282E34;text-align:center;padding:50px 80px;text-align: justify;">
            <h3 style="text-align:center;color: #ffffff;">Système de 'punch'</h3>
            <br>
            <p class="text-center">Vous pouvez facilement commencer votre chiffre de travail par l'onglet, "Mon Travail", situé dans la barre de menu horizontale.</p>
        </div>
    </div>

    <div class="bgimg-10"></div>

    <div style="color: #777;background-color:white;text-align:center;padding:50px 80px;text-align: justify;">
        <h3 style="text-align:center;">Modifier le profil</h3>
        <br>
        <p class="text-center">Vous pouvez mettre une photo à votre profil pour permettre une meilleure reconnaissance lors des interactions sur le site web.  Par exemple, sur le chat et sur les nouvelles d'entreprises.</p>
    </div>

    <div class="bgimg-11"></div>

    <div style="position:relative;">
        <div style="color:#ddd;background-color:#282E34;text-align:center;padding:50px 80px;text-align: justify;">
            <h3 style="text-align:center;color: #ffffff;">Appliquer sur une offre d'emploi</h3>
            <br>
            <p class="text-center">Vous pouvez facilement appliquer sur une offre d'emploi si vous avez fourni votre CV.</p>
        </div>
    </div>

    <div class="bgimg-12"></div>

    <div style="color: #777;background-color:white;text-align:center;padding:50px 80px;text-align: justify;">
        <h3 style="text-align:center;">Inscription</h3>
        <br>
        <p class="text-center">Il est très simple de s'inscrire en quelques secondes sur LetsWork</p>
    </div>

    <div class="bgimg-13"></div>

    <div style="position:relative;">
        <div style="color:#ddd;background-color:#282E34;text-align:center;padding:50px 80px;text-align: justify;">
            <h3 style="text-align:center;color: #ffffff;">Connexion</h3>
            <br>
            <p class="text-center">En entrant votre adresse courriel reliée à votre compte ainsi que votre mot de passe, vous pouvez facilement vous connecter à LetsWork.</p>
        </div>
    </div>

    <div class="bgimg-14"></div>

    <div style="color: #777;background-color:white;text-align:center;padding:50px 80px;text-align: justify;">
        <h3 style="text-align:center;">Voir les offres d'emploi</h3>
        <br>
        <p class="text-center">En tant qu'utilisateur, il est très simple pour vous de voir les offres d'emploi.</p>
    </div>

    <div class="bgimg-15"></div>

    <div style="position:relative;">
        <div style="color:#ddd;background-color:#282E34;text-align:center;padding:50px 80px;text-align: justify;">
            <h3 style="text-align:center;color: #ffffff;">Voir les compagnies</h3>
            <br>
            <p class="text-center">Pour n'importe quel utilisateur, il est très simple de voir les compagnies présentes sur le site.</p>
        </div>
    </div>

    <div class="bgimg-16"></div>

    <div style="color: #777;background-color:white;text-align:center;padding:50px 80px;text-align: justify;">
        <h3 style="text-align:center;">Voir les postes (Compagnie)</h3>
        <br>
        <p class="text-center">En tant que Compagnie, vous êtes en mesure de pouvoir consulter les postes de votre entreprise.</p>
    </div>

    <div class="bgimg-17"></div>

    <div style="position:relative;">
        <div style="color:#ddd;background-color:#282E34;text-align:center;padding:50px 80px;text-align: justify;">
            <h3 style="text-align:center;color: #ffffff;">Voir les disponibilités</h3>
            <br>
            <p class="text-center">En tant qu'employé d'une entreprise, vous pouvez voir les disponibilités que vous avez données.</p>
        </div>
    </div>

    <div class="bgimg-18"></div>

    <div style="color: #777;background-color:white;text-align:center;padding:50px 80px;text-align: justify;">
        <h3 style="text-align:center;">Se déconnecter</h3>
        <br>
        <p class="text-center">En cliquant sur l'onglet de votre profil de la barre du haut, vous pouvez modifier votre profil ou vous déconnecter facilement.</p>
    </div>

    <div class="bgimg-19"></div>

    <div style="position:relative;">
        <div style="color:#ddd;background-color:#282E34;text-align:center;padding:50px 80px;text-align: justify;">
            <h3 style="text-align:center;color: #ffffff;">Fin</h3>
            <br>
            <p class="text-center">Voilà! C'était la documentation de LetsWork. Si vous avez besoin de plus de détails, n'hésitez pas à nous écrire au <a href="mailto:support@letswork.com">support@letswork.com</a>.</p>
        </div>
    </div>

    <div class="header-img">
        <div class="caption">
            <a href="{{route('information.aboutus')}}" style="text-decoration: none"><span class="fa fa-arrow-left"></span>Revenir à la page À Propos</a>
                <br>
                <br>
                <a href="{{route('homepage.content')}}" style="text-decoration: none"><span class="fa fa-arrow-left"></span>Revenir à l'accueil</a>
        </div>
    </div>

@endsection