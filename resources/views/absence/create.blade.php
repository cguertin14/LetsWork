@extends('layouts.master')

@section('styles')
    <style>
        body {
            background-color: #5d5d5d;
        }

        .title-absence {
            color: #ffffff;
        }

        .input-group-addon:hover {
            cursor: pointer;
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
                            <div class='input-group date' id='datetimepicker1'>
                                {!! Form::text('begin', null, ['class' => 'form-control']); !!}
                                <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-calendar"></span>
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            {!! Form::label('end', 'Date de fin', ['class' => 'section-title']); !!}
                            <div class='input-group date' id='datetimepicker2'>
                                {!! Form::text('end', null, ['class' => 'form-control']); !!}
                                <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-calendar"></span>
                                </span>
                            </div>
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

        <div class="row layout">
            <div class="centre">
                @include('include.errors')
            </div>
        </div>
    </div>


@endsection

@section('scripts')
    <script>
        $(function () {
            $('#datetimepicker1').datetimepicker({
                defaultDate: new Date(),
                format: 'YYYY-DD-MM HH:mm:ss',
            });
            $('#datetimepicker2').datetimepicker({
                defaultDate: new Date(),
                format: 'YYYY-DD-MM HH:mm:ss',
            });
        });
    </script>
@endsection