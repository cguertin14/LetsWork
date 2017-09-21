@extends('layouts.master')

@section('styles')
    <style>
        body {
            background-color: #5d5d5d;
        }

        .title-absence {
            color: #ffffff;
        }
    </style>
@endsection

@section('content')

    @include('include.tinyeditor')

    <h1 class="title-absence">Demande d'absence</h1>
    <hr style="border-top: 1px solid #474747">
    <div class="col-md-12">
        {!! Form::open(['method' => 'POST','action' => 'AbsenceController@store']) !!}
            <div class="row layout">
                <div class="centre">
                    <div class="col-md-6">
                        <div class="form-group">
                            {!! Form::label('begin', 'Date de début', ['class' => 'section-title']); !!}
                            {!! Form::date('begin', null, ['class' => 'form-control']); !!}
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            {!! Form::label('end', 'Date de fin', ['class' => 'section-title']); !!}
                            {!! Form::date('end', null, ['class' => 'form-control']); !!}
                        </div>
                    </div>
                </div>
            </div>

            <br>
            <br>

            <div class="row layout">
                <div class="form-group text-center centre">
                    {!! Form::label('reason', 'Raison de l\'absence', ['class' => 'section-title']); !!}
                    {!! Form::textarea('reason', null, ['class' => 'form-control']); !!}
                </div>
            </div>

            <div class="row layout">
                <div class="centre">
                    <div class="form-group">
                        {!! Form::submit('Soumettre',['class' => 'btn purplebtn']) !!}
                    </div>
                </div>
            </div>

        {!! Form::close() !!}
    </div>


@endsection