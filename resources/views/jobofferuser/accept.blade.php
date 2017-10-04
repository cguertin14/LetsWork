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
    <h1 class="title">Bonjour {{$user->name}},</h1>
    <div class="col-md-6">
        <p class="message">
            Nous avons pris le temps d'analyser votre demande d'emploi et nous avons finalement décidé que vous aurez chance de faire parti de notre équipe.
        </p>
        <p class="message">Merci et à bientôt!</p>
        <p class="message">L'équipe de <b>{{ config('app.name') }}</b></p>
    </div>

@endsection