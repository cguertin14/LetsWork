@extends('layouts.top')

@section('styles')
    <style>
        .title {
            color: #000000;
        }

        .message {
            color: #000000;
        }

        body {
            background-color: white;
        }
    </style>
@endsection

@section('contenu')
    <h2 class="title">Bonjour {{$jobofferuser->user->fullname}},</h2>
    <br>
    <div class="col-md-6">
        <p class="message">
            Nous avons pris le temps d'analyser votre demande d'emploi pour le poste de <b>{{$jobofferuser->joboffer->specialrole->name}}</b> et nous avons finalement décidé que vous n'aurez pas la chance de faire parti de notre équipe.
        </p>
        <p class="message">Merci et à bientôt!</p>
        <p class="message">L'équipe de <b>{{$jobofferuser->joboffer->company->name}}</b></p>
        <p class="message">{{$jobofferuser->joboffer->company->telephone}}</p>
    </div>

@endsection