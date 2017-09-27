@extends('layouts.master')

@section('styles')
    <style>
        body {
            background-color: #5d5d5d;
        }
    </style>
@endsection

@section('content')

    <h1 class="page-title">Toutes les compétences</h1>
    <hr class="separator">

    <div class="layout">
        <div class="col-md-12">
            <div class="centre">
                <table class="table custom-table">
                    <thead>
                    <tr class="section-title">
                        <th>Nom</th>
                        <th>Description</th>
                    </tr>
                    </thead>
                    <tbody class="section">
                    @if($skills)
                        @foreach($skills as $skill)
                            <tr class="clickable-section" data-href="{{route('skill.edit',$skill->slug)}}">
                                <td>{{$skill->name}}</td>
                                <td>{{$skill->description}}</td>
                            </tr>
                        @endforeach
                    @endif
                    </tbody>
                </table>

                <div class="row">
                    <div class="col-sm-6 col-sm-offset-5">
                        {{$skills->render('pagination.paginate')}}
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection