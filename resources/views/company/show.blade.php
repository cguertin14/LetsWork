@extends('layouts.master')

@section('styles')
    <style>

    </style>
@endsection

@section('content')
    <div class="col-md-12">
        <div class="row">
            <div class="col-md-12">
                <h1 style="text-align: center" class="h1">{{$data['name']}}</h1>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div style="width:100%; height:70%" class="col-sm-offset-5">
                    <img id="image" width="200px" height="200px" src="{{asset('image/default-profile.png')}}" style="border-radius: 50%">
                </div>
            </div>
        </div>
        <div class="container">
            <div class="col-sm-8 col-md-12">
                <p class="h3">{!!$data['description']!!}</p>
            </div>
            @if(count($joboffers)>0)
                <div class="col-sm-8 col-md-12">
                    @foreach($joboffers as $joboffer)
                        <div class="col-sm-8 col-md-12" style="background-color: #5d5d5d;color:white;">
                            <div>{{$joboffer->job_count.' offres d\'emploi pour le poste de '.$joboffer->name}}</div>
                            <p>{{$joboffer->description}} <a href="{{route('joboffer.show',$joboffer->slug)}}" class="btn purplebtn pull-right">Voir l'offre d'emploi pour le poste de {{$joboffer->specialrole->name}}</a></p>
                        </div>
                    @endforeach
                </div>
            @endif
            <div class="col-md-12">
                <p class="h4">
                    <span data-toggle="tooltip" title="Email">{{  $data['email'].", "}}</span>
                    <span data-toggle="tooltip" title="Numero de telephone">{{  $data['telephone'].", "}}</span>
                    <span data-toggle="tooltip" title="Adresse civique">{{  $data['adresse'].", "}}</span>
                    <span data-toggle="tooltip" title="Ville">{{  $data['ville'].", "}}</span>
                    <span data-toggle="tooltip" title="Code postale">{{  $data['zipcode'].", "}}</span>
                    <span data-toggle="tooltip" title="Pays">{{  $data['pays']}}</span>
                </p>
            </div>
        </div>
    </div>
    @if(\Illuminate\Support\Facades\Auth::id()==$data['user_id'])
        <a href="{{route('company.edit',$data['name'])}}" class="btn purplebtn">Editer</a>
    @endif
    <br><br>
@endsection

@section('scripts')
    <script>
@if($data['photo'])
    $('#image').attr('src',"data:image/png;base64," +'{{$data['photo']}}');
@endif
    </script>
@endsection