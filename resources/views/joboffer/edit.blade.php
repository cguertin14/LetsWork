@extends('layouts.master')

@section('styles')
    <style>
        body {
            background-color: #5d5d5d;
        }
        .footer {
            position: relative;
        }
    </style>
@endsection

@section('content')

    @include('include.tinyeditor')
    <div class="page-title-header">
        <h1 class="page-title">Modifier une offre d'emploi</h1>
        <hr class="separator">
    </div>

    <div class="centre custom-table custom-container" style="padding: 5px;margin-bottom: 20px;">
        <div class="layout" style="margin: 2em">
        {!! Form::model($jobOffer,['method' => 'PATCH','action' => ['JobOfferController@update',$jobOffer->slug]]) !!}
        {!! Form::hidden('company_id',$jobOffer->company_id) !!}
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
            </div>
        </div>

        <div class="row layout">
            <div class="centre">
                <div class="col-md-12">
                    <div>
                        {!! Form::submit('Modifier l\'offre d\'emploi ',['class' => 'btn purplebtn pull-left']) !!}
                    </div>
                    {!! Form::close() !!}

                    {!! Form::open(['method' => 'DELETE','action' => ['JobOfferController@destroy',$jobOffer->slug]]) !!}
                        {!! Form::submit('Supprimer l\'offre d\'emploi',['class' => 'btn btn-danger pull-right confirm_action','c_m_text' => 'Voulez-vous vraiment supprimer cettre offre d\'emploi?','style' => 'font-size:17px !important']) !!}
                    {!! Form::close() !!}
                </div>
            </div>
        </div>

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