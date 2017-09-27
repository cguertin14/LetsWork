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

    <h1 class="title-absence" style="color: #ffffff;">Modifier un poste</h1>
    <hr style="border-top: 1px solid #474747">
    <div class="col-md-12">
        {!! Form::model($specialRole,['method' => 'PATCH','action' => ['SpecialRoleController@update',$specialRole->slug]]) !!}
        {!! Form::hidden('company_id',$specialRole->company_id) !!}
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
                    <div class="form-group">
                        {!! Form::label('roles[]', 'Rôles',['class' => 'section-title']); !!}
                        {!! Form::select('roles[]',$roles,$specialRole->roles->pluck('id'),['class' => 'form-control selectpicker','multiple' => 'multiple','data-actions-box' => 'true']); !!}
                    </div>
                </div>
            </div>
        </div>

        <div class="row layout">
            <div class="centre">
                <div class="col-md-12">
                    <div class="form-group">
                        {!! Form::label('skills[]', 'Compétences',['class' => 'section-title']); !!}
                        {!! Form::select('skills[]',$skills,$specialRole->skills->pluck('id'),['class' => 'form-control selectpicker','multiple' => 'multiple','data-actions-box' => 'true']); !!}
                    </div>
                </div>
            </div>
        </div>

        <div class="row layout">
            <div class="centre">
                <div class="col-md-12">
                    <div>
                        {!! Form::submit('Modifier le poste',['class' => 'btn purplebtn pull-left']) !!}
                    </div>

        {!! Form::close() !!}

        {!! Form::open(['method' => 'DELETE','action' => ['SpecialRoleController@destroy',$specialRole->slug]]) !!}
                    <div>
                        {!! Form::submit('Supprimer le poste',['class' => 'btn btn-danger pull-right','style' => 'font-size:17px !important']) !!}
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