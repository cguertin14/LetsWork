@extends('layouts.master')

@section('styles')
    <style>
        @if(!\Illuminate\Support\Facades\Auth::check())
            body {
                background-image: url({{asset('image/WelcomePage.jpg')}});
                background-position: 0 40px;
            }
        @endif
    </style>
@endsection

@section('content')
    @if(!\Illuminate\Support\Facades\Auth::check())
        <div class="outer">
            <div class="middle">
                <div class="inner">
                    <div class="container">
                        <div class="text-center" style="margin-bottom: 20%">
                            <p class="title1">Cherchez, appliquez <br> et travaillez</p>
                            <p class="title2">
                                Grâce à une application web polyvalente <br> permettant la gestion de votre milieu <br> de travail
                            </p>
                            <div class="form-group" style="margin-top: 40px">
                                <a href="">
                                    <button type="button" class="btn btn-enterprise">
                                        Commencer à chercher les entreprises
                                    </button>
                                </a>
                            </div>
                            <a href="" class="link">ou créez votre propre entreprise</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
@endsection