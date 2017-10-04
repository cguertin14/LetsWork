@extends('layouts.master')

@section('styles')
    <style>
        body {
            background-color: #5d5d5d;
        }

        .white {
            color: #ffffff;
        }

        .accordion-toggle:hover {
            cursor: pointer;
        }
    </style>
@endsection

@section('content')
    <h1 class="title-absence white">Liste de mes disponibilités</h1>
    <hr class="separator">
    <div class="row">
        <div class="col-md-4 col-md-offset-2 white">
            @php ($i = 1)
                @foreach($dispos as $dispo)
                    @php($begin=\Carbon\Carbon::parse($dispo->begin))
                        @php($end=\Carbon\Carbon::parse($dispo->end))
                            <div class="row">
                                <div class="accordion-toggle pull-left" data-toggle="collapse" data-target="#accordion{{$i}}">
                                <div> Disponibilite #{{$i}}      </div>                              <div class="col-md-7">
                                    Du {{\App\Tools\Helper::Day($dispo->begin)." à ".$begin->hour.":".$begin->minute.":".$begin->second}}
                                    au {{\App\Tools\Helper::Day($dispo->end)." à ".$end->hour.":".$end->minute.":".$end->second}}</div></div>
                                <div id="accordion{{$i}}" class="row accordion-body collapse">
                                    {{Form::open(['method' => 'DELETE','action' => ['DispoController@destroy',$dispo->id]])}}
                                    {{Form::submit('Supprimer',['class' => 'btn btn-danger confirm_action',"c_m_text"=>"Voulez-vous vraiment supprimer cette disponibilité?"])}}
                                    {{Form::close()}}
                                </div>
                            </div>
                        @php ($i++)
                @endforeach
                <br>
                <a class="btn purplebtn" href="{{route("dispo.create")}}">Ajouter une plage horaire</a>
        </div>
    </div>
@endsection