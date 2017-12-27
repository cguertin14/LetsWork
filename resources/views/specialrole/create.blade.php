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

    <div  style="width:85%;margin-left: auto;margin-right: auto">
        <h1 class="page-title">Création de poste</h1>
        <hr style="border-top: 1px solid #474747">
    </div>
    <div class="centre custom-table custom-container" style="padding: 5px;margin-bottom: 20px;">
        {!! Form::open(['method' => 'POST','action' => 'SpecialRoleController@store']) !!}
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


                    <div class="col-md-12">
                        <div class="form-group">
                            {!! Form::label('roles[]', 'Rôles',['class' => 'section-title']); !!}
                            {!! Form::select('roles[]',$roles,null,['class' => 'form-control selectpicker','multiple' => 'multiple','data-actions-box' => 'true']); !!}
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="form-group">
                            {!! Form::label('skills[]', 'Compétences',['class' => 'section-title']); !!}
                            {!! Form::select('skills[]',$skills,null,['class' => 'form-control selectpicker','multiple' => 'multiple','data-actions-box' => 'true']); !!}
                        </div>
                    </div>
                </div>
            </div>

            <div class="row layout" style="margin: 2em">
                <div class="centre">
                    <div class="col-md-12">
                        <div class="form-group">
                            {!! Form::submit('Créer le poste',['class' => 'btn purplebtn']) !!}
                        </div>
                    </div>
                </div>
            </div>
        {!! Form::close() !!}

        <div class="row layout" style="margin: 2em">
            <div class="centre">
                <div class="col-md-12" style="margin-top: 1em;">
                    <div class="form-group">
                        @include('include.errors')
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection