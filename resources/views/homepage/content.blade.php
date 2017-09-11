@extends('layouts.master')

@section('styles')
    <style>
        body {
            background-image: url({{asset('image/WelcomePage.jpg')}});
            background-position: 0 40px;
             /*background-color: #474747;*/
        }
    </style>
@endsection

@section('content')
    <div class="container" style="margin-top: 150px">
        <div class="pull-left" style="width: 50%">
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

@endsection