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
            @if (count($skills) > 0)
                <div class="centre custom-container">
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
                    <div class="text-center">
                        {{$skills->render('pagination.paginate')}}
                    </div>
                </div>
            </div>
            @else
                @component('components.nothing')
                    @slot('message')
                        Il n'y a pas de compétences
                    @endslot
                @endcomponent
            @endif
        </div>
    </div>

@endsection