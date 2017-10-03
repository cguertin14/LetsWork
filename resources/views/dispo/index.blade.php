@extends('layouts.master')

@section('styles')
    <style>
        body {
            background-color: #5d5d5d;
        }

        div {
            color: #ffffff;
        }

        .input-group-addon:hover {
            cursor: pointer;
        }
    </style>
@endsection

@section('content')
    <h1 class="title-absence">Liste de mes disponibilités</h1>
    <hr class="separator">
    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            @php ($i = 1)
            @foreach($dispos as $dispo)
                @php($begin=\Carbon\Carbon::parse($dispo->begin))
                @php($end=\Carbon\Carbon::parse($dispo->end))
                <div class="row accordion-toggle" data-toggle="collapse" data-target="#accordion{{$i}}">{{$i}}</div>
                <div id="accordion{{$i}}" class="row accordion-body collapse">
                    <div class="col-md-5">{{\App\Tools\Helper::Day($dispo->begin)." ".$begin->hour.":".$begin->minute.":".$begin->second}}</div>
                    <div class="col-md-5">{{\App\Tools\Helper::Day($dispo->end)." ".$end->hour.":".$end->minute.":".$end->second}}</div>
                </div>
                @php ($i++)
            @endforeach
            <br>
            <a class="btn purplebtn" href="{{route("dispo.create")}}">Ajouter une plage horaire</a>
        </div>
    </div>
@endsection