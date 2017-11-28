@extends('layouts.master')

@section('styles')
    <style>
        body {
            background-color: #5d5d5d;
        }
    </style>
@endsection

@section('content')

    @include('include.tinyeditor')

    <div  style="width:85%;margin-left: auto;margin-right: auto">
        <h1 class="page-title">Créer une offre d'emploi</h1>
        <hr class="separator">
    </div>

    <div class="col-md-12">
        {!! Form::open(['method' => 'POST','action' => 'JobOfferController@store']) !!}
        <div class="row layout">
            <div class="centre">
                <div class="col-md-12">
                    <div class="form-group">
                        {!! Form::label('name', 'Titre de l\'offre d\'emploi', ['class' => 'section-title']) !!}
                        {!! Form::text('name', null, ['class' => 'form-control']) !!}
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="form-group">
                        {!! Form::label('special_role_id', 'Nom du poste', ['class' => 'section-title']) !!}
                        {!! Form::select('special_role_id', $specialRoles,null, ['class' => 'form-control']) !!}
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="form-group">
                        {!! Form::label('job_count', 'Nombre de postes disponibles', ['class' => 'section-title']) !!}
                        {!! Form::number('job_count', null, ['class' => 'form-control','min' => '1']) !!}
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="form-group">
                        {!! Form::label('description', 'Description de l\'offre d\'emploi', ['class' => 'section-title']) !!}
                        {!! Form::textarea('description', null, ['class' => 'form-control']) !!}
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="form-group">
                        {!! Form::submit('Créer l\'offre d\'emploi ',['class' => 'btn purplebtn']) !!}
                    </div>
                </div>
            </div>
        </div>
        {!! Form::close() !!}

        <div class="row layout">
            <div class="centre">
                <div class="col-md-12">
                    <div class="form-group">
                        @include('include.errors')
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection