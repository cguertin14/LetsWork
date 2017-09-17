@extends('layouts.master')

@section('styles')
    <style>

    </style>
@endsection

@section('content')
    <div class="col-md-12">
        <div class="row">
            <div class="col-md-12">
                <h1 style="text-align: center" class="h1">{{$data['name']}}</h1>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <img src="https://www.w3schools.com/css/trolltunga.jpg" style="width: 100%;height: auto ;background-color: black" alt="logo">
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="row">
                    <h4 class="h4">{{$data['adresse']}}</h4>
                </div>
                <div class="row">
                    <h4 class="h4">{{$data['ville']}}</h4>
                </div>
            </div>
        </div>
    </div>
@endsection