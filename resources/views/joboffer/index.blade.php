@extends('layouts.master')

@section('styles')
    <style>
        body {
            background-color: #5d5d5d;
        }
    </style>
@endsection

@section('content')

    <h1 class="page-title">Toutes les offres d'emplois</h1>
    <hr class="separator">

    <div class="col-md-12">
        <div class="row layout">
            <div class="centre">
                <table class="table custom-table">
                    <thead>
                        <tr class="section-title">
                            <th>Titre</th>
                            <th>Compagnie</th>
                            <th>Ville</th>
                            <th>Publication</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($jobOffers as $jobOffer)
                        <tr data-toggle="collapse" data-target="#accordion{{$jobOffer->id}}" class="accordion-toggle section-index">
                            <td>{{$jobOffer->name}}</td>
                            <td>{{$jobOffer->company->name}}</td>
                            <td>{{$jobOffer->company->ville}}</td>
                            <td>{{$jobOffer->created_at->diffForHumans()}}</td>
                        </tr>
                        <tr>
                            <td colspan="4" class="hiddenRow">
                                <div class="accordion-body collapse"  id="accordion{{$jobOffer->id}}">
                                    <table class="table">
                                        <tr>
                                            <td class="list-group-item">
                                                @component('components.section-index')
                                                    @slot('title')
                                                        Adresse:
                                                    @endslot
                                                    @slot('content')
                                                        <a href="https://www.google.ca/maps/place/{{$jobOffer->company->adresse}}" target="_blank">
                                                            {{$jobOffer->company->adresse}}
                                                        </a>
                                                    @endslot
                                                @endcomponent
                                            </td>
                                            <td class="list-group-item">
                                                @component('components.section-index')
                                                    @slot('title')
                                                        Poste:
                                                    @endslot
                                                    @slot('content')
                                                        {{$jobOffer->specialrole->name}}
                                                    @endslot
                                                @endcomponent
                                            </td>
                                            <td class="list-group-item">
                                                @component('components.section-index')
                                                    @slot('title')
                                                        Postes disponibles:
                                                    @endslot
                                                    @slot('content')
                                                        {{$jobOffer->job_count}}
                                                    @endslot
                                                @endcomponent
                                            </td>
                                            <td class="list-group-item">
                                                @component('components.section-index')
                                                    @slot('title')
                                                        Description:
                                                    @endslot
                                                    @slot('content')
                                                        <textarea style="resize: none;" class="form-control" disabled cols="20" rows="8">{{$jobOffer->description}}</textarea>
                                                    @endslot
                                                @endcomponent
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

                <div class="row">
                    <div class="col-sm-6 col-sm-offset-5">
                        {{$jobOffers->render()}}
                    </div>
                </div>

            </div>
        </div>
    </div>

@endsection