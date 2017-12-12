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
    <div class="col-md-6">
        <p class="message">
            Après mures réflexions, nous avons finalement décidé que vous aurez la chance de faire partie de notre équipe en tant que <b>{{$jobofferuser->joboffer->specialrole->name}}</b>.
        </p>
        <p class="message">Merci et à bientôt!</p>
        <br>
        <p class="message">L'équipe de <b>{{$jobofferuser->joboffer->company->name}}</b></p>
        <a href="mailto:{{$jobofferuser->joboffer->company->email}}">{{$jobofferuser->joboffer->company->email}}</a>
        <p class="message">{{$jobofferuser->joboffer->company->telephone}}</p>
    </div>

@endsection