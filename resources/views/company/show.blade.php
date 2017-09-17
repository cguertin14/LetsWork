@extends('layouts.master')

@section('styles')
    <style>

    </style>
@endsection

@section('content')
    <div class="col-md-12">
        <div class="row">
            <div class="col-md">
                <h1 style="text-align: center" class="h1">{{$data['name']}}</h1>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <img style="width: 40%;height: auto" alt="logo">
            </div>
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