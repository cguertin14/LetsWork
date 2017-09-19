@php
    include resource_path("arrays/country.php");
@endphp

@extends('layouts.master')

@section('styles')
    <style>
        body {
            background-color: #5d5d5d;
        }

        select {
            height: 36px !important;
        }

        label, input {
            color: white;
        }
    </style>
@endsection

@section('content')

    @include('include.tinyeditor')

    <div class="col-md-12">
        <h1 class="h1" style="color: white">Création d'entreprise</h1>
        {{Form::open(array('action' => 'CompanyController@store'))}}
        <div class="row">
            <div class="col-lg-6">
                {{Form::text("name","", array('class' => 'form-control',"placeholder"=>"Nom d'entreprise"))}}
            </div>
            <div class="col-lg-6">
                {{Form::label('logofile', 'Le logo de votre entreprise')}}
                {{Form::file('logo',array("id"=>"logofile"))}}
            </div>
        </div>
        <br>
        <div class="row">
            <div class="col-lg-6">
                {{Form::text("telephone","", array('class' => 'form-control',"placeholder"=>"Telephone"))}}
            </div>
            <div class="col-lg-6">
                {{Form::text("email","", array('class' => 'form-control',"placeholder"=>"Email"))}}
            </div>
        </div>
        <br>
        <div class="row">
            <div class="col-lg-6">
                {{Form::text("ville","", array('class' => 'form-control',"placeholder"=>"Ville"))}}
            </div>
            <div class="col-lg-6">
                {{Form::text("adresse","", array('class' => 'form-control',"placeholder"=>"Adresse"))}}
            </div>
        </div>
        <br>
        <div class="row">
            <div class="col-lg-6">
                {{Form::text("zipcode","", array('class' => 'form-control',"placeholder"=>"Code postal"))}}
            </div>
            <div class="col-lg-6">
                {{Form::select('pays', $country_list,0, array('class' => 'form-control custom-select'))}}
            </div>
        </div>
        <br>
        <div class="row">
            <div class="col-lg-6">
                {{Form::select('company_type_id', $companyTypes ,0, array('class' => 'form-control custom-select'))}}
            </div>
        </div>
        <br>
        <div class="row">
            <div class="col-lg-12">
            {{Form::textarea("description", "" ,array('class' => 'form-control',"placeholder"=>"Description","rows"=>12))}}
            </div>
        </div>
        <br>
        {{Form::submit('Soumettre',array('class' => 'btn btn-primary purplebtn'))}}
        {{Form::close()}}
    </div>
    </div>
@endsection
