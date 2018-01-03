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
        <div class="page-title-header">
            <h1 class="page-title">Mes périodes de travail</h1>
            <hr class="separator">
        </div>
        <div class="col-md-12">
            <div class="row layout">
                @if (count($punches) > 0)
                <div class="centre custom-container">
                    <table class="table custom-table"style="margin: 0px !important;">
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
                            <tr style="cursor:default;" class="@if ($i % 2 == 0 ) section-index-2 @else section-index @endif">
                                @php(\Carbon\Carbon::setLocale('fr'))
                                <td>{{\Carbon\Carbon::parse($punch->datebegin)->toDateTimeString()}}</td>
                                @if($punch->dateend)
                                    <td>{{\Carbon\Carbon::parse($punch->dateend)->toDateTimeString()}}</td>
                                    <td>{{\Carbon\Carbon::parse($punch->dateend)->diffForHumans(\Carbon\Carbon::createFromFormat('Y-m-d H:i:s',$punch->datebegin),true)}}</td>
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
            <div class="row layout">
                <div class="centre custom-container custom-table" style="padding: 1em;margin-bottom: 2em">
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
                    var ctx = document.getElementById('chartid').getContext('2d');
                    var chart = new Chart(ctx, {
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
                                text: 'Mes heures travaillées'
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
                        $("html, body").animate({ scrollTop: $("#chart").offset().top - 65 }, 1000);
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
                sortDateDebut: function () {
                    // TODO
                    const order = $('#sortDateDebut').css('background-image') === this.sortNormal ? 'ASC' :
                                 ($('#sortDateDebut').css('background-image') === this.sortUp ? 'DESC' : 'ASC');
                    $.ajax({
                        method: 'POST',
                        url: '{{route('punches.sort')}}',
                        data: { column: 'datebegin', order: order, _token: '{{csrf_token()}}' },
                        success: function () {
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
                        url: '{{route('punches.sort')}}',
                        data: { column: 'dateend', order: order, _token: '{{csrf_token()}}' },
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
                        url: '{{route('punches.sort')}}',
                        data: { column: 'duration', order: order, _token: '{{csrf_token()}}' },
                        success: function () {
                            location.reload();
                        }
                    });
                },
                loadweek: function () {
                    $.getJSON('/punches/lastweek/{{\App\Tools\Helper::CEmployee()->id}}',function (data) {
                        app.chartdata = data;
                    });
                },
                loadtwoweeks: function() {
                    $.getJSON('/punches/lasttwoweeks/{{\App\Tools\Helper::CEmployee()->id}}',function (data) {
                        app.chartdata = data;
                    });
                },
                loadmonth: function () {
                    $.getJSON('/punches/lastmonth/{{\App\Tools\Helper::CEmployee()->id}}',function (data) {
                        app.chartdata = data;
                    });
                },
                loadyear: function () {
                    $.getJSON('/punches/lastyear/{{\App\Tools\Helper::CEmployee()->id}}',function (data) {
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