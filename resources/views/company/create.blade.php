@php
    include resource_path("arrays/country.php");
@endphp

@extends('layouts.master')

@section('styles')
    <style>
        body{
            background-color: #474747;
        }
        select{
            height:36px !important;
        }
    </style>
@endsection

@section('content')
    <div class="outer">
        <div class="middle">
            <div class="center">
                <div class="container" style="width: 50%">
                    <div class="row">
                        <div class="col-md-8 col-md-offset-2">
                            <div class="panel panel-default">
                                <div class="panel-heading text-center">Creation d'entreprise</div>
                                <div class="panel-body">
                                    <form class="form-group" action="">
                                        <div class="row">
                                            <div class="col">
                                                <label for="logofile">Le logo de votre entreprise</label>
                                                <input id="logofile" name="logo" type="file" class="form-control-file">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col">
                                                <input name="telephone" type="text" class="form-control"
                                                       placeholder="Telephone">
                                            </div>
                                            <div class="col">
                                                <input name="email" type="text" class="form-control"
                                                       placeholder="Email">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col">
                                                <input name="ville" type="text" class="form-control"
                                                       placeholder="Ville">
                                            </div>
                                            <div class="col">
                                                <input name="adresse" type="text" class="form-control"
                                                       placeholder="Adresse">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col">
                                                <input name="zip" type="text" class="form-control"
                                                       placeholder="Code postal">
                                            </div>
                                            <div class="col">
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
                                        <button type="submit" class="btn btn-primary">Soumettre</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
@endsection