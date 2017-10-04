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
    <h1 class="title-absence">Donner une nouvelle plage horaire</h1>
    <hr class="separator">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
        {!! Form::open(['method' => 'POST','action' => 'DispoController@store']) !!}
            <div class="row">
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
        <div class="row">
            <div class="col-md-6">
            {!! Form::submit('Ajouter la plage horaire',['class' => 'btn purplebtn pull-left']) !!}
            </div>
        </div>
        {!! Form::close() !!}

            <br>

            <div class="row">
                <div class="col-md-12">
                    @include('include.errors')

                @if (\Illuminate\Support\Facades\Session::has('errorDispo'))
                    <div class="alert alert-danger">
                        <ul>
                        <li>{{session('errorDispo')}}</li>
                        </ul>
                    </div>
                @endif
                </div>
            </div>

        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $(function () {
            $('#datetimepicker1').datetimepicker({
                defaultDate: new Date(),
                format: 'YYYY-MM-DD HH:mm:ss',
                locale: 'fr-ca'
            });
            $('#datetimepicker2').datetimepicker({
                defaultDate: new Date(),
                format: 'YYYY-MM-DD HH:mm:ss',
                locale: 'fr-ca'
            });
        });
    </script>
@endsection