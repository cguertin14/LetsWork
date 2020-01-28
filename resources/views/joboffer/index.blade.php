@extends('layouts.master')

@section('styles')
    <style>
        body {
            background-color: #5d5d5d;
        }
        .list-group-item {
            background-color: #8c8c8c !important;
        }
        .footer {
            position: relative;
        }
    </style>
@endsection

@section('content')

    <div  style="width:85%;margin-left: auto;margin-right: auto">
        <h1 class="page-title">Toutes les offres d'emplois</h1>
        <hr class="separator">
    </div>

    <div class="col-md-12">
        <div class="row layout">
            @if ($jobOffers->count() > 0)
            <div class="centre custom-container">
                <table id="headerTable" class="table custom-table" style="margin: 0px !important;">
                    <thead>
                        <tr class="section-title">
                            <th>Trier par</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody id="headerBody">
                        <tr>
                            @php $sorts = ['Ville','Compagnie'] @endphp
                            @foreach($sorts as $sort)
                            <td class="text-center">
                                <div class="form-group" style="margin: 0;">
                                    <section style="display: inline-flex">
                                        <!-- .slideTwo -->
                                        <div class="slideTwo">
                                            <input @if ($sort === 'Ville') @if(array_key_exists('cities',$sesh)) checked  @endif @else @if(array_key_exists('names',$sesh)) checked @endif @endif type="checkbox" v-model="@if ($sort === 'Ville') cityChecked @else companyChecked @endif" v-on:change="@if ($sort === 'Ville') cityChanged() @else companyChanged() @endif" value="None" id="sort{{$sort}}" name="check"/>
                                            <label for="sort{{$sort}}"></label>
                                        </div>
                                        <!-- end .slideTwo -->
                                    </section>
                                    <label class="text-center section-title" style="font-style: normal;margin-left: 0.5em;color: white;">{{$sort}}</label>
                                </div>
                            </td>
                            @endforeach
                        </tr>
                        <tr id="sortRow"  @if (! array_key_exists('cities',$sesh) && ! array_key_exists('names',$sesh)) style="display: none" @endif>
                            <td id="cities" class="text-center" @if(!array_key_exists('cities',$sesh)) style="display: none;" @endif>
                                {!! Form::open(['method' => 'POST','action' => 'JobOfferController@sort']) !!}
                                <div class="form-group" style="margin: 0;">
                                    @php
                                        $citiesSorted = array_key_exists('citiesSorted',$sesh) ? $sesh['citiesSorted'] : null
                                    @endphp
                                    {!! Form::select('cities[]',$cities,$citiesSorted,['class' => 'form-control selectpicker', 'data-actions-box' => 'true','multiple' => 'multiple','id' => 'citiesSelect','required' => 'required']) !!}
                                </div>
                                <div class="form-group" style="margin-top: 1em">
                                    {!! Form::submit('Trier',['class' => 'btn purplebtn pull-left']) !!}
                                </div>
                                {!! Form::close() !!}
                            </td>
                            <td id="names" class="text-center" @if(!array_key_exists('names',$sesh)) style="display: none;" @endif>
                                {!! Form::open(['method' => 'POST','action' => 'JobOfferController@sort']) !!}
                                <div class="form-group" style="margin: 0;">
                                    @php
                                        $namesSorted = array_key_exists('namesSorted',$sesh) ? $sesh['namesSorted'] : null
                                    @endphp
                                    {!! Form::select('names[]',$names,$namesSorted,['class' => 'form-control selectpicker', 'data-actions-box' => 'true','required' => 'required','multiple' => 'multiple','id' => 'namesSelect']) !!}
                                </div>
                                <div class="form-group" style="margin-top: 1em">
                                    {!! Form::submit('Trier',['class' => 'btn purplebtn pull-left']) !!}
                                </div>
                                {!! Form::close() !!}
                            </td>
                            <td id="space" @if (! array_key_exists('cities',$sesh) && ! array_key_exists('names',$sesh)) style="display: none" @endif>
                                @if (array_key_exists('cities',$sesh) || array_key_exists('names',$sesh))
                                {!! Form::open(['method' => 'POST','action' => 'JobOfferController@unsort']) !!}
                                <div class="form-group" style="margin: 0">
                                    {!! Form::submit('Réinitialiser',['class' => 'btn btn-danger pull-right','style' => 'font-size:17px !important']) !!}
                                </div>
                                {!! Form::close() !!}
                                @endif
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <br>
            <div class="centre custom-container" style="margin-bottom: 2em">
                <table id="table" class="table custom-table" style="margin: 0px !important;">
                    <thead>
                        <tr class="section-title">
                            <th>Titre <span id="titleSort" v-on:click="sortTitle()" class="sort"></span></th>
                            <th>Compagnie <span id="companySort" v-on:click="sortCompany()" class="sort"></span></th>
                            <th>Ville <span id="citySort" v-on:click="sortCity()" class="sort"></span></th>
                            <th>Publication <span id="publicationSort" v-on:click="sortPublication()" class="sort"></span></th>
                        </tr>
                    </thead>
                    <tbody>
                        @php($i = 0)
                        @foreach($jobOffers as $jobOffer)
                        <tr data-toggle="collapse" data-target="#accordion{{$jobOffer->id}}" class="accordion-toggle @if ($i % 2 == 0 ) section-index-2 @else section-index @endif">
                            <td>{{$jobOffer->name}}</td>
                            <td>{{$jobOffer->company->name}}</td>
                            <td>{{$jobOffer->company->ville}}</td>
                            <td>{{$jobOffer->created_at->diffForHumans()}}</td>
                        </tr>
                        <tr>
                            <td colspan="4" class="hiddenRow">
                                <div class="accordion-body collapse"  id="accordion{{$jobOffer->id}}">
                                    <table class="table" style="margin: 0px !important;">
                                        <tr>
                                            <td class="list-group-item">
                                                @component('components.section-index')
                                                    @slot('title')
                                                        Adresse:
                                                    @endslot
                                                    @slot('content')
                                                        <a style="color:white!important;text-decoration: none" href="https://www.google.ca/maps/place/{{$jobOffer->company->adresse}}" target="_blank">
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
                                                        <textarea style="resize: none; background-color: #707070;color: #dbdbdb;" class="form-control" disabled>{{$jobOffer->description}}</textarea>
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
                                                        @if($jobOffer->users->where('id',\Illuminate\Support\Facades\Auth::user()->id)->first() == null)
                                                            <a class="btn purplebtn" href="{{route('joboffer.show',$jobOffer->slug)}}">
                                                                Soumettre ma candidature
                                                            </a>
                                                        @else
                                                            <button class="btn btn-warning" disabled>
                                                                En Attente
                                                            </button>
                                                        @endif
                                                    </div>
                                                @endif
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </td>
                        </tr>
                        @php(++$i)
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

@section('scripts')
    <script>
        // Header table Vue
        new Vue({
            el: '#headerTable',
            data: {
                cityChecked: @if(array_key_exists('cities',$sesh)) true, @else false, @endif
                companyChecked: @if(array_key_exists('names',$sesh)) true, @else false, @endif
            },
            computed: {},
            methods: {
                cityChanged: function () {
                    if (this.cityChecked) {
                        // Disable other checkbox
                        this.companyChecked = false;
                        // Show cities in select
                        this.showCities();
                    } else {
                        this.hideCities();
                    }
                },
                companyChanged: function () {
                    if (this.companyChecked) {
                        // Disable other checkbox
                        this.cityChecked = false;
                        // Show companies in select
                        this.showCompanies();
                    } else {
                        this.hideCompanies();
                    }
                },
                hideCities: function () {
                    $('#space').stop().fadeOut(700);
                    $('#cities').stop().fadeOut(700);
                    $('#sortRow').stop().slideUp(1500);
                },
                hideCompanies: function () {
                    $('#space').stop().fadeOut(700);
                    $('#names').stop().fadeOut(700);
                    $('#sortRow').stop().slideUp(1200);
                },
                showCities: function() {
                    $('#space').fadeIn();
                    // Show new Select with cities in it
                    if ($('#sortRow').is(':visible')) {
                        if ($('#names').is(':visible')) {
                            $('#names').fadeOut(500,function () {
                                $('#cities').fadeIn();
                            })
                        } else {
                            $('#cities').fadeIn();
                        }
                    } else {
                        $('#sortRow').stop().slideDown(1200);
                        if ($('#names').is(':visible')) {
                            $('#names').fadeOut(500,function () {
                                $('#cities').fadeIn();
                            })
                        } else {
                            $('#cities').stop().fadeIn();
                        }
                    }
                },
                showCompanies: function () {
                    $('#space').fadeIn();
                    // Show new Select with companies in it
                    if ($('#sortRow').is(':visible')) {
                        if ($('#cities').is(':visible')) {
                            $('#cities').fadeOut(500,function () {
                                $('#names').fadeIn();
                            })
                        } else {
                            $('#names').fadeIn();
                        }
                    } else {
                        $('#sortRow').stop().slideDown(1200);
                        if ($('#cities').is(':visible')) {
                            $('#cities').fadeOut(500,function () {
                                $('#names').stop().fadeIn();
                            })
                        } else {
                            $('#names').stop().fadeIn();
                        }
                    }
                },
            }
        });

        // Main table Vue
        new Vue({
            el: '#table',
            data: {
                sortNormal:  'url("{{env('APP_URL')}}/image/sort.png")',
                sortUp:      'url("{{env('APP_URL')}}/image/sortup.png")',
                sortDown:    'url("{{env('APP_URL')}}/image/sortdown.png")'
            },
            computed: {},
            methods: {
                init: function() {
                    // Place correct images for sorting in header columns
                    @if (array_key_exists('order',$sesh))
                        @if (count($sesh) > 0)
                            let order = '{{$sesh['order']}}';
                            @if ($sesh['column'] === 'names,name' || $sesh['column'] === 'name' || $sesh['column'] === 'cities,name')
                                $('#titleSort').css('background-image',order === 'ASC' ? this.sortUp : this.sortDown);
                            @elseif (strpos($sesh['column'],'companyName') !== false)
                                $('#companySort').css('background-image',order === 'ASC' ? this.sortUp : this.sortDown);
                            @elseif (strpos($sesh['column'],'companyCity') !== false)
                                $('#citySort').css('background-image',order === 'ASC' ? this.sortUp : this.sortDown);
                            @elseif (strpos($sesh['column'],'created_at') !== false)
                                $('#publicationSort').css('background-image',order === 'ASC' ? this.sortUp : this.sortDown);
                            @endif
                        @endif
                    @endif
                },
                sortTitle: function() {
                    const order = $('#titleSort').css('background-image') === this.sortNormal ? 'ASC' :
                                  ($('#titleSort').css('background-image') === this.sortUp ? 'DESC' : 'ASC');
                    $.ajax({
                        method: 'POST',
                        url: '{{route('joboffer.sort')}}',
                        data: { column: 'name', order: order, _token: '{{csrf_token()}}' },
                        success: function () {
                            location.reload();
                        }
                    });
                },
                sortCompany: function() {
                    const order = $('#companySort').css('background-image') === this.sortNormal ? 'ASC' :
                                  ($('#companySort').css('background-image') === this.sortUp ? 'DESC' : 'ASC');
                    $.ajax({
                        method: 'POST',
                        url: '{{route('joboffer.sort')}}',
                        data: { column: 'companyName', order: order, _token: '{{csrf_token()}}' },
                        success: function () {
                            location.reload();
                        }
                    });
                },
                sortCity: function() {
                    const order = $('#citySort').css('background-image') === this.sortNormal ? 'ASC' :
                                  ($('#citySort').css('background-image') === this.sortUp ? 'DESC' : 'ASC');
                    $.ajax({
                        method: 'POST',
                        url: '{{route('joboffer.sort')}}',
                        data: { column: 'companyCity', order: order, _token: '{{csrf_token()}}' },
                        success: function () {
                            location.reload();
                        }
                    });
                },
                sortPublication: function () {
                    const order = $('#publicationSort').css('background-image') === this.sortNormal ? 'ASC' :
                                  ($('#publicationSort').css('background-image') === this.sortUp ? 'DESC' : 'ASC');
                    $.ajax({
                        method: 'POST',
                        url: '{{route('joboffer.sort')}}',
                        data: { column: 'created_at', order: order, _token: '{{csrf_token()}}' },
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