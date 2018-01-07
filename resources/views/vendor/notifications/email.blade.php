@extends('layouts.top')

@section('styles')

    <style>
        .title {
            color: #000000;
        }

        body {
            background-color: white;
        }

        .message {
            color: #000000;
        }

        p, span, a {
            font-family: Ubuntu,sans-serif;
        }

        .footer {
            visibility: hidden;
            display: none;
        }

        .purplebtn {
            background-color: #552AD6 !important;
            color: white;
            font-size: 17px !important;
            font-family: 'Montserrat',sans-serif;
            font-weight: 900 !important;
        }

        .purplebtn:focus {
            background-color: #552AD6 !important;
            color: white !important;
        }

        .btn {
            display: inline-block;
            margin-bottom: 0;
            text-align: center;
            vertical-align: middle;
            -ms-touch-action: manipulation;
            touch-action: manipulation;
            cursor: pointer;
            background-image: none;
            border: 1px solid transparent;
            white-space: nowrap;
            padding: 6px 12px;
            line-height: 1.6;
            border-radius: 4px;
            -webkit-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            user-select: none;
            font-size: 17px !important;
            font-family: 'Montserrat',sans-serif;
            font-weight: 900 !important;
        }

        .purplebtn:hover {
            color: #ffffff !important;
            background-color:#4200D6 !important;
        }
    </style>
@endsection

@section('contenu')
    <h1 style="font-weight:700; font-size: 35px; color:#552ad6;font-family: Ubuntu,sans-serif">LetsWork</h1>
    <h2 class="title">Bonjour,</h2>
    <div class="col-md-6" >
        <p class="message">
            @foreach($introLines as $lines)
                {{ $lines }}
            @endforeach
        </p>

        <a style="text-decoration: none" class="btn purplebtn" href="{{ $actionUrl }}" >Réinitialiser mon mot de passe.</a>

        <br>
        <br>

        <p class="message">
            @foreach($outroLines as $lines)
                {{ $lines }}
            @endforeach
        </p>
        <p class="message">Merci et à bientôt!</p>
        <p class="message">L'équipe de <b>{{ config('app.name') }}</b></p>
    </div>

@endsection