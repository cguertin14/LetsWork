@extends('layouts.master')

@section('styles')
    <style>
        body {
            background-color: #5d5d5d;
        }
        .footer {
            position: relative;
        }
    </style>
@endsection

@section('content')

    @include('include.tinyeditor')
    <div  style="width:85%;margin-left: auto;margin-right: auto">
        <h1 class="page-title">Demande d'absence</h1>
        <hr style="border-top: 1px solid #474747">
    </div>
    <div class="centre custom-table custom-container" style="padding: 5px;margin-bottom: 20px;">
        {!! Form::open(['method' => 'POST','action' => 'AbsenceController@store']) !!}
        <div style="margin: 2em">
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

            <div class="row layout">
                <div class="col-md-12">
                    <div class="form-group text-center centre">
                        {!! Form::label('reason', 'Raison de l\'absence', ['class' => 'section-title']); !!}
                        {!! Form::textarea('reason', null, ['class' => 'form-control']); !!}
                    </div>
                </div>
            </div>

            <div class="row layout">
                <div class="col-md-12">
                    <div class="form-group centre">
                        {!! Form::submit('Soumettre',['class' => 'btn purplebtn']) !!}
                    </div>
                </div>
            </div>

            {!! Form::close() !!}

            <div class="row layout">
                <div class="centre">
                    @include('include.errors')
                </div>

                @if (\Illuminate\Support\Facades\Session::has('errorAbsence'))
                    <div class="row centre">
                        <div class="alert alert-danger">
                            {{session('errorAbsence')}}
                        </div>
                    </div>
                @endif
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
                locale: 'fr-ca'
            });
            $('#datetimepicker2').datetimepicker({
                defaultDate: new Date(),
                format: 'YYYY-DD-MM HH:mm:ss',
                locale: 'fr-ca'
            });
        });
    </script>
@endsection