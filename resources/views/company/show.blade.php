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
                <img class="img-rounded" src="https://www.w3schools.com/css/trolltunga.jpg"
                     style="width: 100%;height: auto ;background-color: black" alt="logo">
            </div>
        </div>
        <div class="container">
            <div class="col-sm-8 col-md-12">
                <p class="h3">{{$data['description']}}</p>
            </div>
            @if(count($joboffers)>0)
                <div class="col-sm-8 col-md-12">
                    @foreach($joboffers as $joboffer)
                        <div class="col-sm-8 col-md-12">
                            <div>{{$joboffer->job_count.' ~ '.$joboffer->name}}</div>
                            <p>{{$joboffer->description}}</p>
                        </div>
                    @endforeach
                </div>
            @endif
            <div class="col-md-12">
                <p class="h4">
                    <span data-toggle="tooltip" title="Email">{{  $data['email'].", "}}</span>
                    <span data-toggle="tooltip" title="Numero de telephone">{{  $data['telephone'].", "}}</span>
                    <span data-toggle="tooltip" title="Adresse civique">{{  $data['adresse'].", "}}</span>
                    <span data-toggle="tooltip" title="Ville">{{  $data['ville'].", "}}</span>
                    <span data-toggle="tooltip" title="Code postale">{{  $data['zipcode'].", "}}</span>
                    <span data-toggle="tooltip" title="Pays">{{  $data['pays']}}</span>
                </p>
            </div>
        </div>
    </div>
@endsection