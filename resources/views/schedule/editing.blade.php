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

        div.cd-schedule,div.loading > *{
            font-size: 1.6rem !important;
            font-style: normal !important;
            font-family: "Source Sans Pro", sans-serif!important;;
            color: #222222 !important;
            background-color: white!important;
        }

        body {
            background-color: #5d5d5d;
        }


        div, span, applet, object, iframe,
        h2, h3, h4, h5, h6, p, blockquote, pre, a {
            margin: 0;
            padding: 0;
            border: 0;
            font-size:100%;
            font: inherit;
            vertical-align: baseline;
        }
        /* HTML5 display-role reset for older browsers */
        article, aside, details, figcaption, figure,
        footer, header, hgroup, menu, nav, section, main {
            display: block;
        }
        div.cd-schedule loading > * {
            line-height: 1!important;
        }
        ol, ul {
            list-style: none !important;
        }
        blockquote, q {
            quotes: none!important;
        }

        .parent {
            position: relative;
            height: 4.35em;
        }

        .parent .element {
            position: absolute;
            left: 50%;
            top: 50%;
            transform: translate(-50%, -50%);
        }
        [v-cloak] {
            display: none;
        }
</style>
<style>
    tr>td {
        padding-bottom: 1em;
    }
</style>
@endsection

@section('content')

<h1 class="page-title text-center">Modifier le calendrier</h1>
<hr class="separator">

<div class="modal fade" id="createScheduleModal" tabindex="-1" role="dialog" aria-hidden="true"></div>
<div class="modal fade" id="createEventModal" tabindex="-1" role="dialog" aria-hidden="true"></div>

<div class="custom-container custom-table" style="margin: 2em auto;max-width: 1400px;width: 90%">
    <table style="margin: 2em">
        <tbody id="tbody">
            <tr>
                <td class="col-xs-2">
                    <img style="cursor: pointer;display: inline-block" id="new-schedule" src="{{asset('image/purple_plus.png')}}" alt="" height="70px" width="70px">
                </td>
                <td class="col-xs-10">
                    <h1 class="page-title" style="font-size: 2em">Ajouter un horaire</h1>
                </td>
            </tr>
            @if(count(session('CurrentCompany')->schedules()->get()) > 0)
            <tr id="add-event-section" style="margin-top: 2em;background-color: transparent">
                <td class="col-xs-2">
                    <img style="cursor: pointer;display: inline-block" id="new-event" src="{{asset('image/purple_plus.png')}}" alt="" height="70px" width="70px">
                </td>
                <td class="col-xs-10">
                    <h1 class="page-title" style="font-size: 2em">Ajouter un événement</h1>
                </td>
            </tr>
            @endif
        </tbody>
    </table>
</div>

@include('include.calendar-template')
@endsection

@section('scripts')
    <script>
        var calendar = new Vue({
            el: "#calendar",
            data: {
                days: ["Lundi", "Mardi", "Mercredi", "Jeudi", "Vendredi"],//, "Samedi", "Dimanche"
                weekevents:
                    {
                        "Lundi": [
                        {
                            "begin": "12:00",
                            "end": "15:00",
                            "name": "Wawooo!!!",
                            "description": "Le premier evenement"
                        },
                        {"begin": "1:00", "end": "8:32", "name": "Wawooo2!!!", "description": "Le deuxieme evenement"}
                        ],
                        "Mardi": [{
                            "begin": "12:00",
                            "end": "15:00",
                            "name": "Wawooo!!!",
                            "description": "Le premier evenement"
                        }],
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
                    $.getJSON("{{route('schedule.thisweek')}}", function (data) {
                        this.weekevents = data;
                    });
                },
                loadNextWeek: function () {
                    $.getJSON("", {}, function (data) {
                        this.weekevents = data.weekevents;
                    });
                },
                loadLastWeek: function () {
                    $.getJSON("", {}, function (data) {
                        this.weekevents = data;
                    });
                }
            },
            watch: {},
            updated: function () {
            },
            created: function () {
                this.loadThisWeek();
            },
            mounted:function()
            {

            }
        });
    </script>
@endsection