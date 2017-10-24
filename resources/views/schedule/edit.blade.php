@extends('layouts.master')

@section('styles')
<style>
    h1.center {
        text-align: center;
    }

    td.spacing {
        padding: 0 2.7em 0 2.7em;
    }

    tbody > tr:nth-child(even) {
        background-color: #bfbfbf;
    }

    .single-event > a {
        color: #A2B9B2;
        text-decoration: none;
    }

    *, *::after, *::before {
        box-sizing: border-box;
    }

    div.cd-schedule,div.loading > *{
        font-size: 1.6rem !important;
        font-style: normal !important;
        font-family: "Source Sans Pro", sans-serif!important;;
        color: #222222 !important;
        background-color: white!important;
    }

    body {
        background-color: #5d5d5d;
    }


    div, span, applet, object, iframe,
    h2, h3, h4, h5, h6, p, blockquote, pre, a {
        margin: 0;
        padding: 0;
        border: 0;
        font-size:100%;
        font: inherit;
        vertical-align: baseline;
    }
    /* HTML5 display-role reset for older browsers */
    article, aside, details, figcaption, figure,
    footer, header, hgroup, menu, nav, section, main {
        display: block;
    }
    div.cd-schedule loading > * {
        line-height: 1!important;
    }
    ol, ul {
        list-style: none !important;
    }
    blockquote, q {
        quotes: none!important;
    }
</style>
@endsection

@section('content')

    <!-- Formulaire de création d'événement -->
    {!! Form::model($scheduleelement,['method' => 'PATCH','action' => ['ScheduleController@update',$scheduleelement->slug],'class' => 'form-horizontal','id' => 'updateForm']) !!}
    <div class="row">
        <div class="col-md-12" id="container">
            <div class="col-md-6">
                <div class="form-group">
                    {!! Form::label('schedule_id', 'Horaire', ['class' => 'section-title']); !!}
                    {!! Form::select('schedule_id',$schedules,null,['class' => 'form-control','required']); !!}
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    {!! Form::label('name', 'Nom', ['class' => 'section-title']); !!}
                    {!! Form::text('name',null,['class' => 'form-control','placeholder' => 'Nom','required']); !!}
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    {!! Form::label('description', 'Description', ['class' => 'section-title']); !!}
                    {!! Form::textarea('description',null,['class' => 'form-control','placeholder' => 'Description','required','rows' => 3,'style' => 'resize:none']); !!}
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    {!! Form::label('begin', 'Date de début', ['class' => 'section-title']); !!}
                    <div class='input-group date' id='begin'>
                        {!! Form::text('begin', null, ['class' => 'form-control','required']); !!}
                        <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    {!! Form::label('end', 'Date de fin', ['class' => 'section-title']); !!}
                    <div class='input-group date' id='end'>
                        {!! Form::text('end', null, ['class' => 'form-control','required']); !!}
                        <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    {!! Form::label('special_role_id', 'Type d\'employé voulu', ['class' => 'section-title']); !!}
                    {!! Form::select('special_role_id',$specialRoles,null,['class' => 'form-control','required','id' => 'special_role']); !!}
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <section style="display: inline-flex">
                        <!-- .slideTwo -->
                        <div class="slideTwo">
                            <input type="checkbox" value="None" id="specific_user_checkbox" name="check"/>
                            <label for="specific_user_checkbox"></label>
                        </div>
                        <!-- end .slideTwo -->
                    </section>
                    <label class="text-center section-title" style="margin-left: 0.5em">Employé spécifique</label>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group pull-right">
                    {!! Form::submit('Modifier',['class' => 'btn purblebtn','style' => 'display:none','id' => 'submit']) !!}
                </div>
            </div>
        </div>
    </div>
    {!! Form::close() !!}

@endsection