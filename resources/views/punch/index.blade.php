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
    </style>
@endsection

@section('content')
    <div id="app">
        <h1 class="title-absence white">Mes périodes de travail</h1>
        <hr class="separator">
        <div class="col-md-12">
            <div class="row layout">
                @if (count($punches) > 0)
                <div class="centre custom-container">
                    <table class="table custom-table"style="margin: 0px !important;">
                        <thead>
                        <tr class="section-title">
                            <th>Date de début <span class="sort"></span></th>
                            <th>Quand <span class="sort"></span></th>
                            <th>Durée <span class="sort"></span></th>
                        </tr>
                        </thead>
                        <tbody class="section">
                        @foreach($punches as $punch)
                            <tr style="cursor:default;">
                                @php(\Carbon\Carbon::setLocale('fr'))
                                <td>{{\Carbon\Carbon::createFromFormat('Y-m-d H:i:s',$punch->datebegin)->toDateString()}}</td>
                                <td>{{\Carbon\Carbon::createFromFormat('Y-m-d H:i:s',$punch->datebegin)->diffForHumans()}}</td>
                                @if($punch->dateend)
                                <td>{{\Carbon\Carbon::createFromFormat('Y-m-d H:i:s',$punch->dateend)->diffForHumans(\Carbon\Carbon::createFromFormat('Y-m-d H:i:s',$punch->datebegin),true)}}</td>
                                @else
                                <td>Période de travail non terminé</td>
                                @endif
                            </tr>
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

        <div class="col-md-12">
            <div class="row layout">
                <div class="centre custom-container custom-table" style="padding: 1em;margin-bottom: 2em">
                    <div class="text-center">
                        <h2 class="row page-title">Trier par</h2>
                        <br>
                        <button class="btn purplebtn" v-on:click="loadweek" style="margin-right: 1em">Semaine</button>
                        <button class="btn purplebtn" v-on:click="loadmonth">Mois</button>
                        <button class="btn purplebtn" v-on:click="loadyear" style="margin-left: 1em">Année</button>
                    </div>
                    <br>
                    <chart :chartdata="chartdata"></chart>
                </div>
            </div>
        </div>
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
                        type: 'line',

                        // The data for our dataset
                        data: this.chartdata,

                        // Configuration options go here
                        options: {
                            scales: {
                                yAxes: [{
                                    ticks: {
                                        // Include a h sign in the ticks
                                        callback: function (value, index, values) {
                                            return value.toFixed(2) + 'h';
                                        }
                                    }
                                }]
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
                        $("html, body").animate({ scrollTop: $(document).height() }, "fast");
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
                chartdata: null
            },
            methods: {
                loadweek: function () {
                    $.getJSON('/punches/lastweek',function (data) {
                        app.chartdata= data;
                    });
                },
                loadmonth: function () {
                    $.getJSON('/punches/lastmouth',function (data) {
                        app.chartdata= data;
                    });
                },
                loadyear: function () {
                    $.getJSON('/punches/lastyear',function (data) {
                        app.chartdata= data;
                    });
                }
            },
            created: function () {
                this.loadweek();
            }
        });
    </script>
@endsection