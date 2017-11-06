@extends('layouts.master')

@section('fonts')
<link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:400,600" rel="stylesheet">
@endsection

@section('styles')
<style>
        .event-info {
            width: 102%;
        }
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

<div style="margin:2em !important">
    <div class="container custom-container custom-table" style="margin:2em auto!important;max-width:1400px!important;width: 90%!important;">
        <div class="col-md-12">
            <div class="col-md-6" id="firstSection">
                <table  style="margin:2em auto;" id="firstTable">
                    <tbody id="tbody">
                        <tr>
                            <td class="col-xs-2">
                                <img style="cursor: pointer;display: inline-block" id="new-schedule" src="{{asset('image/purple_plus.png')}}" alt="" height="70px" width="70px">
                            </td>
                            <td class="col-xs-10">
                                <h1 class="page-title" style="font-size: 2em">Ajouter un horaire</h1>
                            </td>
                        </tr>
                        <tr id="add-event-section" style="margin-top: 2em;background-color: transparent">
                            @if(count(session('CurrentCompany')->schedules()->get()) > 0)
                                <td class="col-xs-2">
                                    <img style="cursor: pointer;display: inline-block" id="new-event" src="{{asset('image/purple_plus.png')}}" alt="" height="70px" width="70px">
                                </td>
                                <td class="col-xs-10">
                                    <h1 class="page-title" style="font-size: 2em">Ajouter un événement</h1>
                                </td>
                            @endif
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="col-md-6" id="secondSection" style="width: 320px;float: right;">
            <table style="margin: 2em">
                <tbody>
                    <tr style="float: right;">
                        <td>
                            <div id="calendarPicker" style="position:relative;height: 250px"></div>
                        </td>
                    </tr>
                </tbody>
            </table>
            </div>
        </div>
    </div>
</div>



<div class="col-md-12">
    <div class="col-md-12">
        @include('include.calendar-template')
    </div>
</div>
@endsection

@section('scripts')
<script type="text/javascript" src="{{asset('js/main.js')}}"></script>
<script>
        var place = new placerhoraire();
        var calendarVue = new Vue({
            el: "#calendar",
            data: {
                days: ["Lundi", "Mardi", "Mercredi", "Jeudi", "Vendredi"],
                weekevents: []
            },
            computed: {},
            methods: {
                thisdayhaveanevent: function (day) {
                    return this.weekevents[day] !== 'undefined';
                },
                getevent: function (day) {
                    return this.weekevents[day];
                },
                loadThisWeek: function () {
                    var self = this;
                    $.ajax({
                        method: 'GET',
                        url: '/schedule/thisweek',
                        success: function (data) {
                            self.weekevents = data.weekevents;
                        }
                    });
                },
                loadFromDate: function(date) {
                    var self = this;
                    self.weekevents = [];
                    $.ajax({
                        method: 'GET',
                        url: '/schedule/week/' + date,
                        success: function (data) {
                            self.weekevents = data.weekevents;
                        }
                    });
                }
            },
            created: function () {
            },
            updated: function () {
                place.load();
            },
            mounted: function() {
                this.loadThisWeek();
            },
            beforeMount: function() {
            },
            ready:function(){
            }
        });
    </script>
<script>
    // add once, make sure dhtmlxcalendar.js is loaded
    dhtmlXCalendarObject.prototype.langData["fr"] = {
        // date format
        dateformat: "%Y.%m.%d",
        // full names of months
        monthesFNames: [
            "Janvier","Février","Mars","Avril","Mai","Juin","Juillet",
            "Août","Septembre","Octobre","Novembre","Décembre"
        ],
        // short names of months
        monthesSNames: [
            "Janv","Févr","Mar","Avr","Mai","Juin",
            "Juill","Août","Sept","Oct","Nov","Déc"
        ],
        // full names of days
        daysFNames: [
            "Dimanche","Lundi","Mardi","Mercredi",
            "Jeudi","Vendredi","Samedi"
        ],
        // short names of days
        daysSNames: [
            "Dim","Lun","Mar","Mer",
            "Jeu","Ven","Sam"
        ],
        // starting day of a week. Number from 1(Monday) to 7(Sunday)
        weekstart: 1,
        // the title of the week number column
        weekname: "s"
    };
    // init calendar
    var myCalendar = new dhtmlXCalendarObject('calendarPicker');
    myCalendar.loadUserLanguage('fr');
    myCalendar.setDate(new Date());
    myCalendar.hideTime();

    // Set onTimeChange event to reload calendar with new data from server
    // with the selected date
    myCalendar.attachEvent('onBeforeChange',function(date) {
        var dateToSend = date.format('yyyy-mm-dd');
        calendarVue.loadFromDate(dateToSend);
        return true;
    });

    // Show calendar
    myCalendar.show();

    $('#firstSection').height($('#secondSection').height());
    var tableMarginTop = Math.round( ($('#firstSection').height() - $('#firstTable').height()) / 2 );
    $('#firstTable').css('margin-top', tableMarginTop);
</script>
@endsection