@extends('layouts.master')

@section('styles')
    <style>
        body {
            background-color: #5d5d5d;
        }
    </style>
@endsection

@section('content')

    <h1 class="page-title">Toutes les demandes d'emplois</h1>
    <hr class="separator">

    <div class="col-md-12">
        <div class="row layout">
            <div class="centre custom-container">
                <table class="table custom-table">
                    <thead>
                    <tr class="section-title">
                        <th>Nom de l'appliquant</th>
                        <th>Poste</th>
                        <th>Demande</th>
                    </tr>
                    </thead>
                    <tbody>
                    @if($jobofferusers)
                        @foreach($jobofferusers as $jobofferuser)
                            <tr data-toggle="collapse" data-target="#accordion{{$jobofferuser->id}}" class="accordion-toggle section-index">
                                <td>{{$jobofferuser->user->fullname}}</td>
                                <td>{{$jobofferuser->joboffer->specialrole->name}}</td>
                                <td>{{$jobofferuser->created_at->diffForHumans()}}</td>
                            </tr>
                            <tr>
                                <td colspan="4" class="hiddenRow">
                                    <div class="accordion-body collapse"  id="accordion{{$jobofferuser->id}}">
                                        <div style="height: 60px;vertical-align: middle;margin-top: 20px" class="col-md-12">
                                            <a class="btn purplebtn pull-right" href="{{route('jobofferuser.show',$jobofferuser->id)}}">
                                                Voir les détails
                                            </a>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    @endif
                    </tbody>
                </table>

                <div class="row">
                    <div class="col-sm-6 col-sm-offset-5">
                        {{$jobofferusers->render('pagination.paginate')}}
                    </div>
                </div>

            </div>
        </div>
    </div>

@endsection