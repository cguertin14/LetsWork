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
<div  style="width:85%;margin-left: auto;margin-right: auto">
    <h1 class="page-title">Dépôt du curriculum vitae</h1>
    <hr class="separator">
</div>

<div class="layout">
    <div class="centre custom-table custom-container" style="padding: 5px;margin-bottom: 20px;">
        <div style="margin: 2em">
            {!! Form::open(['method' => 'POST','action' => 'CvController@store','id' => 'create_cv','files' => true]) !!}
            <div class="form-group">
                {!! Form::button('Choisir le fichier PDF...',['id' => 'uploadbtn','class' => 'btn purplebtn']) !!}
                {!! Form::file('file',['style' => 'display:none;','id' => 'uploader','accept' => 'application/pdf','name' => 'file']); !!}
                {!! Form::submit('',['id' => 'submit','class' => 'btn purplebtn','onclick' => 'return CheckFile();','style' => 'display:none;']) !!}
            </div>
            <hr class="separator">
            {!! Form::close() !!}
            <!--  PDF READER  -->
            <div class="pdf-container" id="cv_file"></div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        sendCV();
        @if (\Illuminate\Support\Facades\Auth::user()->cv)
        getUserCV();
        @else
        PDFObject.embed('{{asset('/files/cv-example.pdf')}}','#cv_file');
        @endif
        $("#uploadbtn").click(function () {
            $("#uploader").trigger("click");
        });
        $("#uploader").change(function () {
            $("#submit").trigger("click");
        });
    });
</script>
@endsection