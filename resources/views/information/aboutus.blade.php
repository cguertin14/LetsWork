@extends('layouts.master')

@section('styles')
    <style>
        div>p {
            font-family: Tahoma;
            color: black;
        }

        p {
            text-align: justify;
            font-size: 1.4em;
            line-height: 1.2em;
        }
    </style>
@endsection

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-0 col-centered">
                <img width="80%" height="auto" src="{{asset("image/letswork.svg")}}" alt="">
            </div>
        </div>
        <br>
        <div class="row">
            <div class="col-md-0 col-centered">
                <h1 class="h1">
                    <b>À propos de Nous</b>
                </h1>
            </div>
        </div>
        <br>
        <div class="row">
            <div class="col-md-12">
                <div class="col-md-4 pull-left">
                    <h2 class="h2 pull-left">
                        <b>Charles Guertin</b>
                    </h2>
                    <img src="" alt="">
                </div>
                <div class="col-md-8">
                    <p>
                        {{\Faker\Factory::create()->text(2000)}}
                    </p>
                </div>
            </div>
        </div>
        <br>
        <div class="row">
            <div class="col-md-12">
                <div class="col-md-4 pull-right">
                    <h2 class="h2 pull-right" style="text-align: center">
                        <b>Ludovic Lachance</b>
                    </h2>
                    <img src="" alt="">
                </div>
                <div class="col-md-8">
                    <p>
                        {{\Faker\Factory::create()->text(2000)}}
                    </p>
                </div>
            </div>
        </div>
    </div>
@endsection