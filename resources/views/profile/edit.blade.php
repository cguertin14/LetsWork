@extends('layouts.master')

@section('styles')
    <style>
        body {
            background-color: #5d5d5d;
        }
    </style>
@endsection

@section('content')
    <div class="row layout">
        <div class="col-md-12 text-center">
            <h1 class="header">Mon profil</h1>
            <br>
            <div style="width:100%; height:70%">
                <img id="image" width="150px" height="150px" src="http://www.garcard.com/images/garcard_symbol.png" style="border-radius: 50%">
            </div>
            <div class="employee">
                <p>{{ $user->fullname }}</p>
                @if($user->employees)
                    @foreach ($user->companies as $company)
                        <p>{{ $company->employees->special_role }}</p>
                        <p>{{ $company->name }}</p>
                    @endforeach
                @endif
            </div>
        </div>
        <br>
        <div class="col-md-12" style="margin-top: 5%;">
            <div class="centre">
                {!! Form::model($user,['method' => 'PATCH', 'action' => 'ProfileController@update', $user->id]) !!}
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            {!! Form::label('first_name', 'Prénom', ['class' => 'section-title']) !!}
                            {!! Form::text('first_name', null, ['class' => 'form-control']) !!}
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            {!! Form::label('last_name', 'Nom de famille', ['class' => 'section-title']) !!}
                            {!! Form::text('last_name', null, ['class' => 'form-control']) !!}
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            {!! Form::label('email', 'Adresse Courriel', ['class' => 'section-title']) !!}
                            {!! Form::text('email', null, ['class' => 'form-control']) !!}
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            {!! Form::label('phone_number', 'Téléphone', ['class' => 'section-title']) !!}
                            {!! Form::text('phone_number', null, ['class' => 'form-control phone-number']) !!}
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