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
        <h1 class="page-title">Créer une compétence</h1>
        <hr class="separator">
    </div>
    <div class="centre custom-table custom-container" style="padding: 5px;margin-bottom: 20px;">
        {!! Form::open(['method' => 'POST','action' => 'SkillController@store']) !!}
        <div class="layout" style="margin: 2em">
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

        <div class="layout row" style="margin: 2em">
            <div class="centre">
                <div class="col-md-12">
                    <div class="form-group">
                        {!! Form::submit('Créer la compétence',['class' => 'btn purplebtn']) !!}
                    </div>
                </div>
            </div>
        </div>

        <br>

        <div class="layout row">
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