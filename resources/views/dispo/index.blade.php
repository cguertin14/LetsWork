@extends('layouts.master')

@section('styles')
    <style>
        body {
            background-color: #5d5d5d;
        }

        .white {
            color: #ffffff;
        }
    </style>
@endsection

@section('content')
    <h1 class="title-absence white">Liste de mes disponibilités</h1>
    <hr class="separator">
    <div class="col-md-12">
        <div class="row layout">
            @if (count($dispos) > 0)
            <div class="centre custom-container">
                <table class="table custom-table">
                    <thead>
                    <tr class="section-title">
                        <th>Date de début</th>
                        <th>Date de fin</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($dispos as $dispo)
                        @php($begin=\Carbon\Carbon::parse($dispo->begin))
                            @php($end=\Carbon\Carbon::parse($dispo->end))
                                <tr class="section-index">
                                    <td>{{\App\Tools\Helper::Day($begin)." à ".$begin->hour.":".$begin->minute.":".$begin->second}}</td>
                                    <td>{{\App\Tools\Helper::Day($end)." à ".$end->hour.":".$end->minute.":".$end->second}}</td>
                                    <td>
                                        <div class="">
                                            {{Form::open(['method' => 'DELETE','action' => ['DispoController@destroy',$dispo->id]])}}
                                            {{Form::submit('Supprimer',['class' => 'btn btn-danger confirm_action',"c_m_text"=>"Voulez-vous vraiment supprimer cette disponibilité?"])}}
                                            {{Form::close()}}
                                        </div>
                                        <div class="">
                                            <a class="btn purplebtn" href="{{route("dispo.edit",$dispo->id)}}">
                                                Modifier
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                    </tbody>
                </table>
            </div>
            @else
                @component('components.nothing')
                    @slot('message')
                        Il n'y a pas de disponibilités
                    @endslot
                @endcomponent
            @endif
            @if(\Illuminate\Support\Facades\Auth::user()->isOwner())
            <br>
            <a class="btn purplebtn" href="{{route("dispo.create")}}">Ajouter une disponibilité</a>
            @endif
        </div>
@endsection