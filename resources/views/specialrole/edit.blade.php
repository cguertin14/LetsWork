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
        <h1 class="page-title">Modifier un poste</h1>
        <hr style="border-top: 1px solid #474747">
    </div>
    <div class="centre custom-table custom-container" style="padding: 5px;margin-bottom: 20px;">
        {!! Form::model($specialRole,['method' => 'PATCH','action' => ['SpecialRoleController@update',$specialRole->slug]]) !!}
        {!! Form::hidden('company_id',$specialRole->company_id) !!}
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
                        {!! Form::select('roles[]',$roles,$specialRole->roles->pluck('id'),['class' => 'form-control selectpicker','multiple' => 'multiple','data-actions-box' => 'true']); !!}
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="form-group">
                        {!! Form::label('skills[]', 'Compétences',['class' => 'section-title']); !!}
                        {!! Form::select('skills[]',$skills,$specialRole->skills->pluck('id'),['class' => 'form-control selectpicker','multiple' => 'multiple','data-actions-box' => 'true']); !!}
                    </div>
                </div>
            </div>
        </div>

        <div class="layout"  style="margin: 2em">
            <div class="centre">
                <div class="col-md-12">
                    <div>
                        {!! Form::submit('Modifier le poste',['class' => 'btn purplebtn pull-left']) !!}
                    </div>

        {!! Form::close() !!}

        {!! Form::open(['method' => 'DELETE','action' => ['SpecialRoleController@destroy',$specialRole->slug]]) !!}
                    {!! Form::submit('Supprimer le poste',['class' => 'btn btn-danger pull-right confirm_action','style' => 'font-size:17px !important','c_m_text' => 'Voulez-vous vraiment supprimer ce poste?']) !!}
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