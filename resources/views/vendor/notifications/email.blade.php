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

        .footer {
            visibility: hidden;
        }
    </style>
@endsection

@section('contenu')
    <h1 class="title">Bonjour,</h1>
    <div class="col-md-6">
        <p class="message">
            @foreach($introLines as $lines)
                {{ $lines }}
            @endforeach
            <b><a href="{{ $actionUrl }}" class="link">Réinitialiser mon mot de passe.</a></b>
        </p>
        <p class="message">
            @foreach($outroLines as $lines)
                {{ $lines }}
            @endforeach
        </p>
        <p class="message">Merci et à bientôt!</p>
        <p class="message">L'équipe de <b>{{ config('app.name') }}</b></p>
    </div>

@endsection