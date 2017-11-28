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

    <div class="page-title-header">
        <table style="width: 100%;">
            <tbody>
                <tr>
                    <td style="vertical-align: middle">
                        <div class="pull-left">
                            <h1 class="page-title">Détails d'une demande d'emploi</h1>
                        </div>
                    </td>
                    <td>
                        <div class="pull-right" style="margin-top: 13px">
                            <div class="col-md-12">
                                @if($jobofferuser->interview)
                                    <div class="col-md-6">
                                        {!! Form::open(['method' => 'POST','action' => ['JobOfferUserController@accept',$jobofferuser->id]]) !!}
                                        {!! Form::submit('Accepter',['class' => 'btn btn-success','style' => 'width:200px']); !!}
                                        {!! Form::close() !!}
                                    </div>
                                @else
                                    <div class="col-md-6">
                                        {!! Form::open(['method' => 'POST','action' => ['JobOfferUserController@interview',$jobofferuser->id]]) !!}
                                        {!! Form::submit('Donner une entrevue',['class' => 'btn btn-info','style' => 'width:200px']); !!}
                                        {!! Form::close() !!}
                                    </div>
                                @endif
                                <div class="col-md-6">
                                    {!! Form::open(['method' => 'DELETE','action' => ['JobOfferUserController@refuse',$jobofferuser->id]]) !!}
                                    {!! Form::submit('Refuser',['class' => 'btn btn-danger','style' => 'width:200px']); !!}
                                    {!! Form::close() !!}
                                </div>
                            </div>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
        <hr class="separator">
    </div>

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
                                        @if($jobofferuser->user->photo)
                                        <div class="row"><img height="50px" width="50px" style="border-radius: 50%" src="data:image/png;base64,{{$jobofferuser->user->photo->source}}" alt=""></div>
                                        @endif
                                        <div class="row">{{$jobofferuser->user->fullname}}</div>
                                        <div class="row information" style="margin-top: 10px">
                                            <a class="page-title" href="mailto:{{$jobofferuser->user->email}}">{{$jobofferuser->user->email}}</a>
                                        </div>
                                        <div class="row information" style="margin-top: 10px">
                                            <p class="page-title">{{$jobofferuser->user->phone_number}}</p>
                                        </div>
                                        <div class="row">
                                            <hr class="separator">
                                        </div>
                                    </div>
                                </div>
                                <div id="content">
                                    <div class="content-header">
                                        @if ($jobofferuser->letter)
                                            <div class="col-md-12">
                                                <div class="row">
                                                    <div class="col-md-6 pull-left">Lettre de Présentation</div>
                                                    <div class="col-md-6 pull-right">Curriculum vitae</div>
                                                </div>
                                            </div>
                                            <br>
                                        @else
                                            <div class="row">Curriculum vitae</div>
                                            <div class="row">
                                                <hr class="separator">
                                            </div>
                                        @endif
                                    </div>
                                    @if ($jobofferuser->letter)
                                        <div class="col-md-12">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div id="letter_file" class="pdf-container">

                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div id="cv_file" class="pdf-container">

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @else
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div id="cv_file" class="pdf-container">

                                                </div>
                                            </div>
                                        </div>
                                    @endif
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
            $("#uploadbtn").click(function () {
                $("#uploader").trigger("click");
            });
            $("#uploader").change(function () {
                $("#submit").trigger("click");
            });
            PDFObject.embed('data:application/pdf;base64,{{$jobofferuser->user->cv}}','#cv_file');
            @if($jobofferuser->letter)
            PDFObject.embed('data:application/pdf;base64,{{$jobofferuser->letter}}','#letter_file');
            @endif
        });
    </script>
@endsection