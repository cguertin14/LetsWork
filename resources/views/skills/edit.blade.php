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

    <h1 class="page-title">Modifier une compétence</h1>
    <hr class="separator">
    <div class="col-md-12">
        {!! Form::model($skill,['method' => 'PATCH','action' => ['SkillController@update',$skill->slug]]) !!}
        <div class="row layout">
            <div class="centre">
                <div class="col-md-12">
                    <div class="form-group">
                        {!! Form::label('name', 'Nom', ['class' => 'section-title']) !!}
                        {!! Form::text('name', null, ['class' => 'form-control']) !!}
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="form-group">
                        {!! Form::label('description', 'Description ', ['class' => 'section-title']) !!}
                        {!! Form::textarea('description', null, ['class' => 'form-control']) !!}
                    </div>
                </div>
            </div>
        </div>

        <div class="row layout">
            <div class="centre">
                <div class="col-md-12">
                    <div>
                        {!! Form::submit('Modifier la compétence',['class' => 'btn purplebtn pull-left']) !!}
                    </div>

                    {!! Form::close() !!}

                    {!! Form::open(['method' => 'DELETE','action' => ['SkillController@destroy',$skill->slug]]) !!}
                        {!! Form::submit('Supprimer la compétence',['class' => 'btn btn-danger pull-right confirm_action','c_m_text' => 'Voulez-vouz vraiment supprimer cette compétence?','style' => 'font-size:17px !important']) !!}
                    {!! Form::close() !!}
                </div>
            </div>
        </div>

        <br>

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