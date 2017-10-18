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
                <div class="centre custom-container">
                    <table class="table custom-table">
                        <thead>
                        <tr class="section-title">
                            <th>Date de début</th>
                            <th>Date de fin</th>
                        </tr>
                        </thead>
                        <tbody class="section">
                        @foreach($punches as $punch)
                            <tr>
                                <td>{{$punch->datebegin}}</td>
                                <td>{{$punch->dateend}}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                <br>
            </div>
        </div>
        <button class="btn purplebtn" v-on:click="loadweek">La semaine</button>
        <button class="btn purplebtn" v-on:click="loadmonth">Le mois</button>
        <button class="btn purplebtn" v-on:click="loadyear">L'année</button>
        <chart :chartdata="chartdata"></chart>
    </div>
@endsection

@section('scripts')
    <script>
        Vue.component('chart', {
            props: ['chartdata'],
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