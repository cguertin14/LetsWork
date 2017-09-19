@extends('layouts.top')

@section('styles')
    <style>
        body {
            background-color: red !important;
        }
    </style>
@endsection

@section('contenu')

    <div class="outer">
        <div class="middle">
            <div class="inner">
                <div class="row text-center">
                    <p class="big-warning">Oups!</p>
                    <p class="small-warning">On dirait bien qu'il y a eu une erreur!</p>
                </div>
            </div>
        </div>
    </div>

@endsection