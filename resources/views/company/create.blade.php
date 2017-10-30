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

    <h1 class="h1" style="color: white">Création d'entreprise</h1>
    <hr class="separator">
    <div class="col-md-12">
        <div class="row layout">
            <div class="centre">
                {!! Form::open(['method' => 'POST','action' => 'CompanyController@uploadphoto','class' => 'dropzone','id' => 'files']) !!}
                <div class="row">
                    <div class="text-center">
                        <div class="row dz-default dz-message">
                            <img src="{{asset('image/purple_plus.png')}}" width="10%" height="10%" alt="">
                        </div>
                        <div class="row dz-default dz-message">
                            <strong>Changer la photo de l'entreprise</strong>
                        </div>
                    </div>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
        <br>
        {!! Form::open(['method' => 'POST','action' => 'CompanyController@store']) !!}
        <div class="row layout">
            <div class="centre">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="form-group">
                            {!! Form::label('name', 'Nom',['class' => 'section-title']) !!}
                            {!! Form::text('name', null, ['class' => 'form-control']) !!}
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            {!! Form::label('telephone', 'Téléphone',['class' => 'section-title']) !!}
                            {!! Form::text('telephone', null, ['class' => 'form-control']) !!}
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-6">
                        <div class="form-group">
                            {!! Form::label('email', 'Adresse Courriel',['class' => 'section-title']) !!}
                            {!! Form::text('email', null, ['class' => 'form-control']) !!}
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            {!! Form::label('ville', 'Ville',['class' => 'section-title']) !!}
                            {!! Form::text('ville', null, ['class' => 'form-control']) !!}
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-6">
                        <div class="form-group">
                            {!! Form::label('adresse', 'Adresse',['class' => 'section-title']) !!}
                            {!! Form::text('adresse', null, ['class' => 'form-control']) !!}
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            {!! Form::label('zipcode', 'Code Postal',['class' => 'section-title']) !!}
                            {!! Form::text('zipcode', null, ['class' => 'form-control']) !!}
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-6">
                        <div class="form-group">
                            {!! Form::label('pays', 'Pays',['class' => 'section-title']) !!}
                            {!! Form::select('pays', $country_list,0, array('class' => 'form-control custom-select')) !!}
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            {!! Form::label('company_type_id', 'Type de compagnie',['class' => 'section-title']) !!}
                            {!! Form::select('company_type_id', $companyTypes ,0, ['class' => 'form-control custom-select']) !!}
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            {!! Form::label('description', 'Description',['class' => 'section-title']) !!}
                            {!! Form::textarea('description', null, ['class' => 'form-control']) !!}
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="form-group">
                            {!! Form::submit('Créer l\'entreprise',['class' => 'btn purplebtn']) !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {!! Form::close() !!}

        <div class="row layout">
            <div class="centre">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="form-group">
                            @include('include.errors')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        Dropzone.autoDiscover = false;
        $("#files").dropzone({
            url: '{{route('company.uploadphoto')}}',
            acceptedFiles: "image/jpeg,image/png,image/gif",
            maxFiles: 1,
            maxfilesexceeded: function(file) {
                this.removeAllFiles();
                this.addFile(file);
            }
        });
    </script>
@endsection