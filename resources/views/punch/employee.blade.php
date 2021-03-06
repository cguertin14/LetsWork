@extends('layouts.master')

@section('styles')
    <style>
        body {
            background-color: #5d5d5d;
        }

        canvas {
            background-color: white;
        }

        .white {
            color: #ffffff;
        }

        [v-cloak] {
            display: none;
        }

        .footer {
            position: relative;
        }
    </style>
@endsection

@section('content')
    <div id="app">
        <div class="modal fade" id="getPunchModal" tabindex="-1" role="dialog" aria-hidden="true"></div>

        <div class="page-title-header">
            <h1 class="page-title">
                Périodes de travail de {{$employee->user->fullname}}
                <div class="form-group pull-right">
                    <button class="btn purplebtn" v-on:click="scrolldown">Voir les graphiques</button>
                </div>
            </h1>
            <hr class="separator">
        </div>
        <div class="col-md-12">
            <div class="row layout">
                @if (count($punches) > 0)
                    <div class="centre custom-container">
                        <table class="table custom-table" style="margin: 0px !important;">
                            <thead>
                            <tr class="section-title">
                                <th>Début <span id="sortDateDebut" v-on:click="sortDateDebut()" class="sort"></span></th>
                                <th>Fin <span id="sortDateFin" v-on:click="sortDateFin()" class="sort"></span></th>
                                <th>Durée <span id="sortDuration" v-on:click="sortDuration()" class="sort"></span></th>
                            </tr>
                            </thead>
                            <tbody class="section">
                            @php($i = 0)
                            @foreach($punches as $punch)
                                <tr class="@if ($i % 2 == 0 ) section-index-2 @else section-index @endif" v-on:click="getPunch({{$punch->id}})">
                                    @php(\Carbon\Carbon::setLocale('fr'))
                                    <td>{{\Carbon\Carbon::parse($punch->datebegin)->toDateTimeString()}}</td>
                                    @if($punch->dateend)
                                        <td>{{\Carbon\Carbon::parse($punch->dateend)->toDateTimeString()}}</td>
                                        <td>{{round(\Carbon\Carbon::parse($punch->dateend)->diffInMinutes(\Carbon\Carbon::createFromFormat('Y-m-d H:i:s',$punch->datebegin)) / 60,2)}} heure(s)</td>
                                        {{--->diffForHumans(\Carbon\Carbon::createFromFormat('Y-m-d H:i:s',$punch->datebegin),true)--}}
                                    @else
                                        <td>Période de travail non terminée</td>
                                        <td>Période de travail non terminée</td>
                                    @endif
                                </tr>
                                @php(++$i)
                            @endforeach
                            </tbody>
                        </table>
                        <div class="row">
                            <div class="text-center">
                                {{$punches->render('pagination.paginate')}}
                            </div>
                        </div>
                    </div>
                @else
                    @component('components.nothing')
                        @slot('message')
                            Il n'y a pas de périodes de travail
                        @endslot
                    @endcomponent
                @endif
                <br>
            </div>
        </div>
        @if (count($punches) > 0)
        <div class="col-md-12" id="chart">
            <div class="row layout" style="margin-bottom: -40px">
                <div class="centre custom-container custom-table" style="padding: 1em;margin-bottom: 1em">
                    <div class="text-center">
                        <h2 class="row page-title">Trier par</h2>
                        <br>
                        <button class="btn purplebtn" v-on:click="loadweek" style="margin-right: 1em">Semaine</button>
                        <button class="btn purplebtn" v-on:click="loadtwoweeks" style="margin-right: 1em">Deux Semaines</button>
                        <button class="btn purplebtn" v-on:click="loadmonth">Mois</button>
                        <button class="btn purplebtn" v-on:click="loadyear" style="margin-left: 1em">Année</button>
                    </div>
                    <br>
                    <chart :chartdata="chartdata"></chart>
                </div>
            </div>
        </div>
        @endif
    </div>
@endsection

@section('scripts')
    <script>
        Vue.component('chart', {
            props: ['chartdata'],
            data: function () {
                return {
                    isRecreated: false
                };
            },
            template: '<canvas id="chartid" v-cloak></canvas>',
            methods: {
                load: function () {
                    $('#chartid').replaceWith($('<canvas id="chartid" v-cloak></canvas>'));
                    let ctx = document.getElementById('chartid').getContext('2d');
                    new Chart(ctx, {
                            // The type of chart we want to create
                            type: 'bar',

                            // The data for our dataset
                            data: this.chartdata,

                            // Configuration options go here
                            options: {
                                responsive: true,
                                legend: {
                                    position: 'top',
                                },
                                title:{
                                    display: true,
                                    text: 'Les heures travaillées de {{$employee->user->fullname}}'
                                },
                                scales: {
                                    yAxes: [
                                        {
                                            ticks: {
                                                // Include a h sign in the ticks
                                                callback: function (value, index, values) {
                                                    return value.toFixed(2) + 'h';
                                                }
                                            }
                                        }
                                    ]
                                }
                            }
                        });
                }
            },
            watch: {
                chartdata: function (newVal) { // watch it
                    this.chartdata = newVal;
                    this.load();
                    if (this.isRecreated)
                        $("html, body").animate({ scrollTop: $("#chart").offset().top - 65 }, 300);
                    this.isRecreated = true;
                }
            },
            mounted: function () {
                this.load();
            }
        });

        var app = new Vue({
            el: '#app',
            data: {
                chartdata: null,
                sortNormal:  'url("{{env('APP_URL')}}/image/sort.png")',
                sortUp:      'url("{{env('APP_URL')}}/image/sortup.png")',
                sortDown:    'url("{{env('APP_URL')}}/image/sortdown.png")'
            },
            methods: {
                scrolldown: function () {
                    $("html, body").animate({ scrollTop: $("#chart").offset().top - 65 }, 1000);
                },
                init: function () {
                    // Place correct images for sorting in header columns
                    @if (count($sesh) > 0)
                        let order = '{{$sesh['order']}}';
                        @if (strpos($sesh['column'],'datebegin') !== false)
                            $('#sortDateDebut').css('background-image',order === 'ASC' ? this.sortUp : this.sortDown);
                        @elseif (strpos($sesh['column'],'dateend') !== false)
                            $('#sortDateFin').css('background-image',order === 'ASC' ? this.sortUp : this.sortDown);
                        @elseif (strpos($sesh['column'],'duration') !== false)
                            $('#sortDuration').css('background-image',order === 'ASC' ? this.sortUp : this.sortDown);
                        @endif
                    @endif
                },
                getPunch: function($id) {
                    let modal = $('#getPunchModal');
                    $.ajax({
                        method: 'GET',
                        url: '/punch/' + $id,
                        success: function (view) {
                            modal.html(view);
                            modal.on('hidden.bs.modal', function () {
                                $(this).empty();
                            });
                            modal.modal();
                        }
                    })
                },
                sortDateDebut: function () {
                    // TODO
                    const order = $('#sortDateDebut').css('background-image') === this.sortNormal ? 'ASC' :
                        ($('#sortDateDebut').css('background-image') === this.sortUp ? 'DESC' : 'ASC');
                    $.ajax({
                        method: 'POST',
                        url: '{{route('punches.sortEmployee')}}',
                        data: { column: 'datebegin', order: order, _token: '{{csrf_token()}}', employee_id: {{$employee->id}} },
                        success: function (view) {
                            location.reload();
                        }
                    });
                },
                sortDateFin: function () {
                    // TODO
                    const order = $('#sortDateFin').css('background-image') === this.sortNormal ? 'ASC' :
                        ($('#sortDateFin').css('background-image') === this.sortUp ? 'DESC' : 'ASC');
                    $.ajax({
                        method: 'POST',
                        url: '{{route('punches.sortEmployee')}}',
                        data: { column: 'dateend', order: order, _token: '{{csrf_token()}}', employee_id: {{$employee->id}} },
                        success: function () {
                            location.reload();
                        }
                    });
                },
                sortDuration: function () {
                    // TODO
                    const order = $('#sortDuration').css('background-image') === this.sortNormal ? 'ASC' :
                        ($('#sortDuration').css('background-image') === this.sortUp ? 'DESC' : 'ASC');
                    $.ajax({
                        method: 'POST',
                        url: '{{route('punches.sortEmployee')}}',
                        data: { column: 'duration', order: order, _token: '{{csrf_token()}}', employee_id: {{$employee->id}} },
                        success: function () {
                            location.reload();
                        }
                    });
                },
                loadweek: function () {
                    $.getJSON('/punches/lastweek/{{$employee->id}}',function (data) {
                        app.chartdata = data;
                    });
                },
                loadtwoweeks: function() {
                    $.getJSON('/punches/lasttwoweeks/{{$employee->id}}',function (data) {
                        app.chartdata = data;
                    });
                },
                loadmonth: function () {
                    $.getJSON('/punches/lastmonth/{{$employee->id}}',function (data) {
                        app.chartdata = data;
                    });
                },
                loadyear: function () {
                    $.getJSON('/punches/lastyear/{{$employee->id}}',function (data) {
                        app.chartdata = data;
                    });
                }
            },
            created: function () {
                this.init();
                this.loadweek();
            }
        });
    </script>
@endsection