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

    <h1 class="title-absence" style="color: #ffffff;">Création de poste</h1>
    <hr style="border-top: 1px solid #474747">
    <div class="col-md-12">
        {!! Form::open(['method' => 'POST','action' => 'SpecialRoleController@store']) !!}
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
                            {!! Form::select('roles[]',$roles,null,['class' => 'form-control','multiple' => 'multiple']); !!}
                        </div>
                    </div>
                </div>
            </div>

            <div class="row layout">
                <div class="centre">
                    <div class="col-md-12">
                        <div class="form-group">
                            {!! Form::label('skills[]', 'Compétences',['class' => 'section-title']); !!}
                            {!! Form::select('skills[]',$skills,null,['class' => 'form-control','multiple' => 'multiple']); !!}
                        </div>
                    </div>
                </div>
            </div>

            <div class="row layout">
                <div class="centre">
                    <div class="col-md-12">
                        <div class="form-group">
                            {!! Form::submit('Créer le poste',['class' => 'btn purplebtn']) !!}
                        </div>
                    </div>
                </div>
            </div>
        {!! Form::close() !!}
    </div>

@endsection