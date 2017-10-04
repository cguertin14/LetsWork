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
    <h1 class="title">Bonjour {{$jobofferuser->user->fullname}},</h1>
    <div class="col-md-6">
        <p class="message">
            Nous avons pris le temps d'analyser votre demande d'emploi et nous avons finalement décidé de vous donner une entrevue.
        </p>
        <p class="message">Merci et à bientôt!</p>
        <p class="message">L'équipe de <b>{{$jobofferuser->joboffer->company->name}}</b></p>
    </div>

@endsection