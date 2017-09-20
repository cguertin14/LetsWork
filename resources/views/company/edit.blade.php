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
        {{Form::open(['action' => ['CompanyController@update', $data["id"]]])}}
        {{ method_field('PATCH') }}
        {{Form::hidden('user_id',$data['user_id'])}}
        <div class="row">
            <div class="col-lg-6">
                {{Form::text("name",$data["name"], array('class' => 'form-control',"placeholder"=>"Nom d'entreprise"))}}
            </div>
            <div class="col-lg-6">
                {{Form::label('logofile', 'Le logo de votre entreprise')}}
                {{Form::file('logo',array("id"=>"logofile"))}}
            </div>
        </div>
        <br>
        <div class="row">
            <div class="col-lg-6">
                {{Form::text("telephone",$data["telephone"], array('class' => 'form-control',"placeholder"=>"Telephone"))}}
            </div>
            <div class="col-lg-6">
                {{Form::text("email",$data["email"], array('class' => 'form-control',"placeholder"=>"Email"))}}
            </div>
        </div>
        <br>
        <div class="row">
            <div class="col-lg-6">
                {{Form::text("ville",$data["ville"], array('class' => 'form-control',"placeholder"=>"Ville"))}}
            </div>
            <div class="col-lg-6">
                {{Form::text("adresse",$data["adresse"], array('class' => 'form-control',"placeholder"=>"Adresse"))}}
            </div>
        </div>
        <br>
        <div class="row">
            <div class="col-lg-6">
                {{Form::text("zipcode",$data["zipcode"], array('class' => 'form-control',"placeholder"=>"Code postal"))}}
            </div>
            <div class="col-lg-6">
                {{Form::select('pays', $country_list, array_search($data["pays"],$country_list), array('class' => 'form-control custom-select'))}}
            </div>
        </div>
        <br>
        <div class="row">
            <div class="col-lg-6">
                {{Form::select('company_type_id', $companyTypes , array_search($data["company_type_id"],$companyTypes), array('class' => 'form-control custom-select'))}}
            </div>
        </div>
        <br>
        <div class="row">
            <div class="col-lg-12">
                {{Form::textarea("description", $data["description"] ,array('class' => 'form-control',"placeholder"=>"Description","rows"=>12))}}
            </div>
        </div>
        <br>
        {{Form::submit('Confirmer',array('class' => 'btn btn-primary purplebtn'))}}
        <div class="pull-right">
            {{Form::open(['action' => ['CompanyController@destroy', $data["id"]]])}}
            {{ method_field('DELETE') }}
            {{Form::hidden('user_id',$data['user_id'])}}
            {{Form::submit('Supprimer',array('class' => 'btn btn-primary purplebtn'))}}
            {{Form::close()}}
        </div>
        {{Form::close()}}
    </div>
    </div>
@endsection
