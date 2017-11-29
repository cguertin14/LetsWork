@extends('layouts.master')

@section('styles')
    <style>
        body {
            background-color: #5d5d5d;
        }
        .footer {
            position: relative;
        }
        .info > tr > td {
            font-size: 1.2em;
        }
    </style>
@endsection

@section('content')
    <div>
        <div class="row">
            <div class="col-md-12 text-center">
                <img id="image" width="200px" height="200px" src="{{asset('image/default-profile.png')}}" style="border-radius: 50%">
            </div>
            <div class="col-md-12">
                <h3 style="font-size:2.5em;text-align: center;font-family: Montserrat,sans-serif;color: white">{{$data['name']}}</h3>
            </div>
            @if(\Illuminate\Support\Facades\Auth::id()==$data['user_id'])
                <div class="col-md-12 text-center">
                    <a href="{{route('company.edit',$data['slug'])}}" class="btn btn-warning">Modifier l'entreprise</a>
                </div>
            @endif
        </div>
        <br>
        <div class="row layout" style="overflow-x: hidden">
            <div class="centre custom-container">
                <table class="table custom-table" style="margin: 0">
                    <thead>
                        <tr class="section-title">
                            <th>Adresse courriel</th>
                            <th>Téléphone</th>
                            <th>Adresse civique</th>
                            <th>Ville</th>
                            <th>Code postal</th>
                            <th>Pays</th>
                        </tr>
                    </thead>
                    <tbody class="info">
                        <tr>
                            <td style="overflow: hidden">
                                <p style="color:white;">
                                    <a data-toggle="tooltip" title="Email" href="mailto:{{  $data['email']}}" style="text-decoration: none;color:white!important;">{{  $data['email']}}</a>
                                </p>
                            </td>
                            <td style="overflow: hidden">
                                <p style="color: white;">
                                    <span data-toggle="tooltip" title="Numero de telephone">{{  $data['telephone']}}</span>
                                </p>
                            </td>
                            <td style="overflow: hidden">
                                <p style="color: white">
                                    <span data-toggle="tooltip" title="Adresse civique">{{  $data['adresse']}}</span>
                                </p>
                            </td>
                            <td style="overflow: hidden">
                                <p style="color: white">
                                    <span data-toggle="tooltip" title="Ville">{{  $data['ville']}}</span>
                                </p>
                            </td>
                            <td style="overflow: hidden">
                                <p style="color: white">
                                    <span data-toggle="tooltip" title="Code postale">{{  $data['zipcode']}}</span>
                                </p>
                            </td>
                            <td style="overflow: hidden">
                                <p style="color: white">
                                    <span data-toggle="tooltip" title="Pays">{{  $data['pays']}}</span>
                                </p>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <br>
            <div class="centre custom-container">
                <table class="table custom-table" style="margin: 0">
                    <thead>
                        <tr class="section-title">
                            <th>Description</th>
                        </tr>
                    </thead>
                    <tbody class="info">
                        <tr>
                            <td>
                                <div class="col-sm-8 col-md-12">
                                    <p style="color:white;">{!!$data['description']!!}</p>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <br>
            @if(count($joboffers)>0)
            <div class="centre custom-container" style="margin-bottom: 2em">
                    <table id="table" class="table custom-table" style="margin: 0px !important">
                    <thead>
                        <tr class="section-title">
                            <th>Offres d'emplois <span id="offersSort" v-on:click="sortOffers()" class="sort"></span></th>
                            <th>Poste <span id="posteSort" v-on:click="sortPoste()" class="sort"></span></th>
                            <th>Description <span id="descriptionSort" v-on:click="sortDescription()" class="sort"></span></th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody class="section">
                        @php($i = 0)
                        @foreach($joboffers as $joboffer)
                            <tr class="clickable-section @if ($i % 2 == 0 ) section-index-2 @else section-index @endif" data-href="@if($data['user_id'] == \Illuminate\Support\Facades\Auth::id()) {{route('joboffer.edit',$joboffer->slug)}} @else {{route('joboffer.show',$joboffer->slug)}} @endif">
                                <td>
                                    <div class="col-sm-8 col-md-12">
                                        <div class="col-sm-8 col-md-12">
                                            <div>{{$joboffer->job_count}}</div>
                                        </div>
                                    </div>
                                </td>
                                <td>{{$joboffer->name}}</td>
                                <td>{{$joboffer->description}} </td>
                                <td>
                                    <a v-on:click="connect()"  href="@if($data['user_id'] == \Illuminate\Support\Facades\Auth::id()) {{route('joboffer.edit',$joboffer->slug)}} @else {{route('joboffer.show',$joboffer->slug)}} @endif" class="btn @if (\Illuminate\Support\Facades\Auth::check() && $data['user_id'] == \Illuminate\Support\Facades\Auth::id()) btn-warning @elseif(\Illuminate\Support\Facades\Auth::check()) purplebtn @else btn-danger @endif pull-right">@if($data['user_id'] == \Illuminate\Support\Facades\Auth::id()) Modifier l'offre d'emploi @else Voir l'offre d'emploi @endif</a>
                                </td>
                            </tr>
                        @php(++$i)
                        @endforeach
                    </tbody>
                </table>

                <div class="text-center">
                    {{$joboffers->render('pagination.paginate')}}
                </div>
            </div>
            @else
                @component('components.nothing')
                    @slot('message')
                        Il n'y a pas d'offres d'emplois pour cette entreprise
                    @endslot
                @endcomponent
            @endif
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        @if($data['photo'])
            $('#image').attr('src',"data:image/png;base64," +'{{$data['photo']}}');
        @endif
        @if(count($joboffers) == 0)
        $('.footer').css('position','absolute');
        @endif
        new Vue({
           el: '#table',
           data: {
               sortNormal:  'url("http://letswork.dev/image/sort.png")',
               sortUp:      'url("http://letswork.dev/image/sortup.png")',
               sortDown:    'url("http://letswork.dev/image/sortdown.png")'
           },
           methods: {
               connect: function () {
                   @if(!\Illuminate\Support\Facades\Auth::check())
                        alert('Attention, Vous devez vous créer un compte pour appliquer sur une offre d\'emploi!');
                   @endif
               },
               init: function () {
                   // Place correct images for sorting in header columns
                   @if (array_key_exists('order',$sesh))
                       @if (count($sesh) > 0)
                           let order = '{{$sesh['order']}}';
                           @if (strpos($sesh['column'],'job_count') !== false)
                                $('#offersSort').css('background-image',order === 'ASC' ? this.sortUp : this.sortDown);
                           @elseif (strpos($sesh['column'],'name') !== false)
                                $('#posteSort').css('background-image',order === 'ASC' ? this.sortUp : this.sortDown);
                           @elseif (strpos($sesh['column'],'description') !== false)
                                $('#descriptionSort').css('background-image',order === 'ASC' ? this.sortUp : this.sortDown);
                           @endif
                       @endif
                   @endif
               },
               sortOffers: function () {
                   const order = $('#offersSort').css('background-image') === this.sortNormal ? 'ASC' :
                                ($('#offersSort').css('background-image') === this.sortUp ? 'DESC' : 'ASC');
                   $.ajax({
                       method: 'POST',
                       url: '{{route('company.sort',$data->slug)}}',
                       data: { column: 'job_count', order: order, _token: '{{csrf_token()}}' },
                       success: function () {
                           location.reload();
                       }
                   });
               },
               sortPoste: function () {
                   const order = $('#posteSort').css('background-image') === this.sortNormal ? 'ASC' :
                                ($('#posteSort').css('background-image') === this.sortUp ? 'DESC' : 'ASC');
                   $.ajax({
                       method: 'POST',
                       url: '{{route('company.sort',$data->slug)}}',
                       data: { column: 'name', order: order, _token: '{{csrf_token()}}' },
                       success: function () {
                           location.reload();
                       }
                   });
               },
               sortDescription: function () {
                   const order = $('#descriptionSort').css('background-image') === this.sortNormal ? 'ASC' :
                                ($('#descriptionSort').css('background-image') === this.sortUp ? 'DESC' : 'ASC');
                   $.ajax({
                       method: 'POST',
                       url: '{{route('company.sort',$data->slug)}}',
                       data: { column: 'description', order: order, _token: '{{csrf_token()}}' },
                       success: function () {
                           location.reload();
                       }
                   });
               }
           },
           created: function () {
               this.init();
           }
        });
    </script>
@endsection