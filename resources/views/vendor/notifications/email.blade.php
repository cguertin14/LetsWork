@extends('layouts.top')

@section('styles')

    <style>
        .title {
            color: #000000;
        }

        .message {
            color: #000000;
        }

        p, span, a {
            font-family: Ubuntu,sans-serif;
        }
    </style>
@endsection

@section('content')
    <h1 style="font-weight:700; font-size: 35px; color:#552ad6;font-family: Montserrat,sans-serif">LetsWork</h1>
    <h2 class="title">Bonjour,</h2>
    <div class="col-md-6" >
        <p class="message">
            @foreach($introLines as $lines)
                {{ $lines }}
            @endforeach
        </p>

        <b><a style="text-decoration: none;margin-bottom: 15px;" class="btn purplebtn" href="{{ $actionUrl }}" >Réinitialiser mon mot de passe.</a></b>

        <p class="message">
            @foreach($outroLines as $lines)
                {{ $lines }}
            @endforeach
        </p>
        <p class="message">Merci et à bientôt!</p>
        <p class="message">L'équipe de <b>{{ config('app.name') }}</b></p>
    </div>

@endsection