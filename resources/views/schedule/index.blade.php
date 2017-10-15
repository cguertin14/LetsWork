@extends('layouts.master')

@section('fonts')
<link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:400,600" rel="stylesheet">
@endsection

@section('styles')
<style>
h1.center {
    text-align: center;
}

td.spacing {
    padding: 0 2.7em 0 2.7em;
}

tbody > tr:nth-child(even) {
    background-color: #bfbfbf;
}

.single-event > a {
    color: #A2B9B2;
    text-decoration: none;
}

*, *::after, *::before {
    box-sizing: border-box;
}

div.cd-schedule, div.loading > * {
    font-size: 1.6rem !important;
    font-style: normal !important;
    font-family: "Source Sans Pro", sans-serif !important;;
    color: #222222 !important;
    background-color: white !important;
}

body {
    background-color: #5d5d5d;
}

div, span, applet, object, iframe,
h2, h3, h4, h5, h6, p, blockquote, pre, a {
    margin: 0;
    padding: 0;
    border: 0;
    font-size: 100%;
    font: inherit;
    vertical-align: baseline;
}

/* HTML5 display-role reset for older browsers */
article, aside, details, figcaption, figure,
footer, header, hgroup, menu, nav, section, main {
    display: block;
}

div.cd-schedule loading > * {
    line-height: 1 !important;
}

ol, ul {
    list-style: none !important;
}

blockquote, q {
    quotes: none !important;
}
</style>
@endsection

@section('content')
<!-- <button class="pull-left btn purplebtn">Précédant</button>
<button class="pull-right btn purplebtn">Suivant</button> -->
<h1 class="page-title text-center">Calendrier</h1>
<hr class="separator">

@include('include.calendar-template')

@endsection

@section('scripts')
<script>
    var calendar = new Vue({
        el: "#calendar",
        data: {
                days: ["Lundi", "Mardi", "Mercredi", "Jeudi", "Vendredi"],//, "Samedi", Dimanche"
                weekevents:
                {
                    "Lundi": [
                    {
                        "start": "12:00",
                        "end": "15:00",
                        "name": "Wawooo!!!",
                        "content": "Le premier evenement"
                    }, 
                    {"start": "1:00", "end": "8:32", "name": "Wawooo2!!!", "content": "Le deuxieme evenement"}
                    ],
                    "Mardi": [],
                    "Mercredi": [],
                    "Jeudi": [],
                    "Vendredi": []
                }
            },
            computed: {},
            methods: {
                thisdayhaveanevent: function (day) {
                    if (this.weekevents[day] != undefined)
                        return true;
                    return false;
                },
                getevent: function (day) {
                    return this.weekevents[day];
                },
                loadThisWeek: function () {
                    $.getJSON("", {}, function (data) {
                        weekevents = data;
                    });
                },
                loadNextWeek: function () {

                },
                loadLastWeek: function () {

                }
            },
            watch: {},
            updated: function () {
            },
            created: function () {
                this.loadThisWeek();
            }
        });
    </script>
    @endsection