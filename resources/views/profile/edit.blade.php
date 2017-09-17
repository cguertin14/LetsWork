@extends('layouts.master')

@section('styles')
    <style>
        body {
            background-color: #5d5d5d;
        }
    </style>
@endsection

@section('content')
    <div class="col-md-12" style="height: 100%;">
        <div class="row">
            <div class="col-md-3">
                <h1 class="header">Mon profil</h1>
                <br>
                <div style="width:100%; height:70%">
                    <img width="150px" height="150px" src="http://www.garcard.com/images/garcard_symbol.png" style="border-radius: 50%">
                </div>
                <div class="employee">
                    <p>{{ $user->name }}</p>
                    @if($user->employees)
                        @foreach ($user->companies as $company)
                            <p>{{ $company->employees->special_role }}</p>
                            <p>{{ $company->name }}</p>
                        @endforeach
                    @endif
                </div>
            </div>
            <br>
            <div class="col-md-9" style="margin-top: 5%">
                {!! Form::model($user,['method' => 'PATCH', 'action' => 'ProfileController@update', $user->id]) !!}
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                {!! Form::label('name', 'Name', ['class' => 'section-title']) !!}
                                {!! Form::text('name', null, ['class' => 'form-control']) !!}
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                {!! Form::label('email', 'Adresse Courriel', ['class' => 'section-title']) !!}
                                {!! Form::text('email', null, ['class' => 'form-control']) !!}
                            </div>
                        </div>
                    </div>

                    <div class="row pull-bottom">
                        <div class="col-md-6">
                            <div class="form-group">
                                {!! Form::label('name', 'Name', ['class' => 'section-title']) !!}
                                {!! Form::text('name', null, ['class' => 'form-control']) !!}
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                {!! Form::label('name', 'Name', ['class' => 'section-title']) !!}
                                {!! Form::text('name', null, ['class' => 'form-control']) !!}
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        {!! Form::submit('Modifier le profil', ['class' => 'btn purplebtn pull-right']) !!}
                    </div>

                {!! Form::close() !!}
            </div>
        </div>
    </div>

@endsection