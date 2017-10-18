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
            @if (count($jobOffers) > 0)
            <div class="centre custom-container">
                <table class="table custom-table" style="margin: 0px !important;">
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
                                                        Compétences:
                                                    @endslot
                                                    @slot('content')
                                                            @foreach($jobOffer->specialrole->skills as $skill)
                                                                @if($skill !== $jobOffer->specialrole->skills->get(count($jobOffer->specialrole->skills->toArray()) - 1))
                                                                    {{$skill->name . ","}}
                                                                @else
                                                                    {{$skill->name}}
                                                                @endif
                                                            @endforeach
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
                                                        <textarea style="resize: none;" class="form-control" disabled>{{$jobOffer->description}}</textarea>
                                                    @endslot
                                                @endcomponent
                                            </td>
                                            <td class="list-group-item" style="text-align: right">
                                                @if(\Illuminate\Support\Facades\Auth::user()->isOwner())
                                                    <div>
                                                        <a class="btn purplebtn" href="{{route('joboffer.edit',$jobOffer->slug)}}">
                                                            Modifier l'offre
                                                        </a>
                                                    </div>
                                                @else
                                                    <div>
                                                        <a class="btn purplebtn" href="{{route('joboffer.show',$jobOffer->slug)}}">
                                                            Soumettre ma candidature
                                                        </a>
                                                    </div>
                                                @endif
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
                    <div class="text-center">
                        {{$jobOffers->render('pagination.paginate')}}
                    </div>
                </div>
            </div>
            @else
                @component('components.nothing')
                    @slot('message')
                        Il n'y a pas d'offres d'emploi
                    @endslot
                @endcomponent
            @endif
        </div>
    </div>

@endsection