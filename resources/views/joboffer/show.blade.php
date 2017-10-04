@extends('layouts.master')

@section('styles')
    <style>
        body {
            background-color: #5d5d5d;
        }
    </style>
@endsection

@section('content')

    <table style="width: 100%;">
        <tbody>
            <tr>
                <td style="vertical-align: middle">
                    <div class="pull-left">
                        <h1 class="page-title">Appliquer sur une offre d'emploi</h1>
                    </div>
                </td>
                <td>
                    @if (\Illuminate\Support\Facades\Auth::user()->cv)
                    <div class="pull-right" style="margin-top: 10px">
                    {!! Form::open(['method' => 'POST','action' => ['JobOfferController@apply',$joboffer->slug]]) !!}
                        <div class="col-md-12">
                            <div class="col-md-6">
                            {!! Form::submit('Appliquer',['class' => 'btn purplebtn','style' => 'width:200px']); !!}
                            </div>
                            <div class="col-md-6">
                            <a id="cancel" href="{{URL::previous()}}" class="btn btn-warning" style="font-size: 17px;width:200px">Annuler</a>
                            </div>
                        </div>
                    {!! Form::close() !!}
                    </div>
                    @endif
                </td>
            </tr>
        </tbody>
    </table>
    <hr class="separator">

    <div class="col-md-12">
        <div class="row layout">
            <div class="centre custom-table custom-container" style="margin-bottom: 20px;">
                <table style="width: 100%">
                    <tbody style="width: 100%">
                        <tr>
                            <td class="col-md-12 title" style="font-size: 30px;padding: 30px">
                                <div class="col-md-12">
                                    <div id="header">
                                        <div id="section1">
                                            @if($joboffer->company->photo)
                                            {{--Place in layout company photo--}}
                                            <div class="row">
                                                <img height="100px" width="100px" style="border-radius: 50%" src="data:image/png;base64,{{$joboffer->company->photo}}" alt="">
                                            </div>
                                            @endif
                                            <div class="row">{{$joboffer->company->name}}</div>
                                            <div class="row information" style="margin-top: 10px">
                                                <a class="page-title" href="https://www.google.ca/maps/place/{{$joboffer->company->adresse}}" target="_blank">{{$joboffer->company->adresse}}</a>
                                            </div>
                                            <div class="row information" style="margin-top: 10px">
                                                <a class="page-title" href="mailto:{{$joboffer->company->email}}">{{$joboffer->company->email}}</a>
                                            </div>
                                            <div class="row information" style="margin-top: 10px">
                                                <p>{{$joboffer->company->telephone}}</p>
                                            </div>
                                            <div class="row">
                                                <hr class="separator">
                                            </div>
                                        </div>
                                        <div id="section2">
                                            <div class="row">{{$joboffer->specialrole->name}}</div>
                                            <div class="row">
                                                <hr class="separator">
                                            </div>
                                        </div>
                                        <div>
                                            <div class="row">{{$joboffer->specialrole->description}}</div>
                                            <div class="row">
                                                <hr class="separator">
                                            </div>
                                        </div>
                                    </div>
                                    <div id="content">
                                        <div class="content-header">
                                            <div class="row">
                                                <table style="width: 100%">
                                                    <tbody>
                                                        <tr>
                                                            <td>Lettre de Présentation</td>
                                                            <td>
                                                                {!! Form::open(['method' => 'POST','action' => 'JobOfferController@lettre','id' => 'create_letter','files' => true]) !!}
                                                                <div class="form-group pull-right">
                                                                    {!! Form::button('Choisir le fichier PDF...',['id' => 'uploadbtn','class' => 'btn purplebtn']) !!}
                                                                    {!! Form::file('file',['style' => 'display:none;','id' => 'uploader','accept' => 'application/pdf','name' => 'file']); !!}
                                                                    {!! Form::submit('',['id' => 'submit','class' => 'btn purplebtn','onclick' => 'return CheckFile();','style' => 'display:none;']) !!}
                                                                </div>
                                                                {!! Form::close() !!}
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                        <div class="row"><hr class="separator"></div>
                                        <div id="letter_file" class="pdf-container">

                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

@endsection

@section('scripts')
    <script>
        $(document).ready(function () {
            @if(!\Illuminate\Support\Facades\Auth::user()->cv)
                    alert('Vous devez déposez votre cv en ligne pour pouvoir postuler sur un emploi!');
            @endif
            sendLetter();
            $("#uploadbtn").click(function () {
                $("#uploader").trigger("click");
            });
            $("#uploader").change(function () {
                $("#submit").trigger("click");
            });
            PDFObject.embed('{{asset('/files/letter-example.pdf')}}','#letter_file');
        });
    </script>
@endsection