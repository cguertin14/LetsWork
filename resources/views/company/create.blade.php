@php
    include resource_path("arrays/country.php");
@endphp

@extends('layouts.master')

@section('styles')
    <style>
        body {
            background-color: #474747;
        }

        select {
            height: 36px !important;
        }
        label, input{
            color: white;
        }
    </style>
@endsection

@section('content')
    <div class="col-md-8">
        <h1 class="h1" style="color: white">Creation d'entreprise</h1>
        <form class="form-group" action="">
            <div class="row">
                <div class="col-md-6">
                    <input name="nom" type="text" class="form-control"
                           placeholder="Nom d'entreprise">
                </div>
                <div class="col-md-6">
                    {{--@component("include/dropzone")--}}
                    {{--@slot("action")--}}
                    {{--#--}}
                    {{--@endslot--}}
                    {{--@slot("name")--}}
                    {{--file--}}
                    {{--@endslot--}}
                    {{--@endcomponent--}}
                    <label for="logofile">Le logo de votre entreprise</label>
                    <input id="logofile" name="logo" type="file" class="form-control-file">
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-md-6">
                    <input name="telephone" type="text" class="form-control"
                           placeholder="Telephone">
                </div>
                <div class="col-md-6">
                    <input name="email" type="text" class="form-control"
                           placeholder="Email">
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-md-6">
                    <input name="ville" type="text" class="form-control"
                           placeholder="Ville">
                </div>
                <div class="col-md-6">
                    <input name="adresse" type="text" class="form-control"
                           placeholder="Adresse">
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-md-6">
                    <input name="zip" type="text" class="form-control"
                           placeholder="Code postal">
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <select class="form-control custom-select" name="pays" id="selecteurpays">
                            <option selected>Choisissez un pays</option>
                            @foreach($country_list as $pays)
                                <option value="{{$pays}}">{{$pays}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            <button type="submit" class="btn btn-primary purplebtn">Soumettre</button>
        </form>
    </div>
    </div>
@endsection
