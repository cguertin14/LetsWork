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
        .footer {
            position: relative;
        }
    </style>
    <style>
        tr>td {
            padding-bottom: 1em;
        }
        .modal-backdrop {
            background-color: rgba(255,255,255,0.5);
        }
        .leftTable {
            width: 100%;
            margin:2em auto;
            margin-left: 15em;
        }
        .rightTable {
            margin: 2em;
            width: 45%;
        }
        @media (max-width:1900px) {
            .leftTable {
                width: 100%;
                margin:2em auto;
                margin-left: 10em;
            }
            .rightTable {
                margin: 2em;
                width: 55%;
            }
        }
        @media (max-width:1700px) {
            .leftTable {
                width: 100%;
                margin:2em auto;
                margin-left: 5em;
            }
            .rightTable {
                margin: 2em;
                width: 65%;
            }
        }
        @media (max-width:1045px) {
            .rightTable {
                margin: 2em;
                width: 100%;
            }
        }
        @media (max-width:1000px) {
            .leftTable {
                width: 100%;
                margin:2em auto;
            }
            .rightTable {
                margin: 2em;
                width: 70%;
            }
        }
    </style>
@endsection

@section('content')

    <div  style="width:85%;margin-left: auto;margin-right: auto">
        <h1 class="page-title">Visualiser le calendrier</h1>
        <hr class="separator">
    </div>

    <div class="modal fade" id="createScheduleModal" tabindex="-1" role="dialog" aria-hidden="true"></div>
    <div class="modal fade" id="createEventModal" tabindex="-1" role="dialog" aria-hidden="true"></div>
    <div class="modal fade" id="loading" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="vertical-alignment-helper">
            <div class="modal-dialog vertical-align-center" role="document">
                <div class="modal-content">
                    <div class="modal-body" style="background-color: #262626">
                        <img src="{{asset('image/loading.gif')}}" alt="" style="height: 100%;width:100%;background-color: #262626;display:block">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div style="margin:2em !important">
        <div class="container custom-container custom-table" style="margin:2em auto!important;max-width:1400px!important;width: 90%!important;">
            <div class="col-md-12">
                <div class="col-md-6" id="firstSection" style="float: left;">
                    <table class="leftTable custom-table" id="firstTable">
                        <tbody id="tbody">
                        <tr>
                            <td class="col-xs-12" style="vertical-align: middle">
                                <h1 class="page-title" style="font-size: 2em">Voir les événements par date</h1>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
                <div class="col-md-6" id="secondSection">
                    <table class="rightTable" style="table-layout: fixed!important;">
                        <tbody>
                        <tr>
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
        var place = new PlacerHoraire();
        var calendarVue = new Vue({
            el: "#calendar",
            data: {
                days: ["Dimanche","Lundi", "Mardi", "Mercredi", "Jeudi", "Vendredi","Samedi"],
                colors: ['event-1','event-2','event-3','event-4'],
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
                sort: function(data) {
                    var newEvents = [],
                        self = this;
                    for (var day in data.weekevents) {
                        data.weekevents[day].forEach(function (event) {
                            event.color = self.colors[Math.floor(Math.random() * self.colors.length)];
                        });
                    }
                    for (var day in data.weekevents) {
                        data.weekevents[day].forEach(function (event) {
                            var dateEnd = event.end.split(" ");
                            if (dateEnd.length > 1) {
                                // Get ending time from event ending date
                                var end = dateEnd[1];
                                // Create new event with same properties but starting the next day
                                var newEvent = JSON.parse(JSON.stringify(event));
                                // Set event to end at midnignt to allow new event to start the next day
                                event.end = '23:59';
                                // Set new event begin and end attributes
                                newEvent.begin = '00:00';
                                newEvent.end = end;

                                var curr = new Date(dateEnd[0]),
                                    first = curr.getDate() - curr.getDay(), // First day is the day of the month - the day of the week
                                    last = first + 6,                       // last day is the first day + 6
                                    lastDayOfTheWeek = new Date(curr.setDate(last)).getDay();

                                // Get date from event ending date
                                var eventEndingDate = new Date(dateEnd[0]);
                                var eventEndingDay = eventEndingDate.getDay() + 1;
                                for (var newDay = self.getDateFromDayInCurrentCalendarDate(day).getDay() + 1; newDay <= lastDayOfTheWeek; ++newDay) {
                                    if (self.getDateFromDayInCurrentCalendarDate(self.getStringDayFromNumberDay(newDay)) < eventEndingDate) {
                                        newEvent.end = '23:59';
                                        var nextDay = self.getStringDayFromNumberDay(newDay);
                                        if (newEvents[nextDay] === undefined) newEvents[nextDay] = [];
                                        newEvents[nextDay].push(newEvent);
                                    } else if (newDay === eventEndingDay) {
                                        var LastDayEvent = JSON.parse(JSON.stringify(newEvent));
                                        LastDayEvent.end = end;
                                        var nextDay = self.getStringDayFromNumberDay(newDay);
                                        if (newEvents[nextDay] === undefined) newEvents[nextDay] = [];
                                        newEvents[nextDay].push(LastDayEvent);
                                    }
                                }
                            }
                        });
                    }

                    // Put new events in main array of data (weekevents).
                    for (var day in newEvents) {
                        newEvents[day].forEach(function (event) {
                            data.weekevents[day].push(event);
                        });
                    }
                    self.weekevents = data.weekevents;
                },
                getScheduleTimestamp: function(time) {
                    //accepts hh:mm format - convert hh:mm to timestamp
                    time = time.replace(/ /g,'');
                    var timeArray = time.split(':');
                    var timeStamp = parseInt(timeArray[0])*60 + parseInt(timeArray[1]);
                    return timeStamp;
                },
                getNextDayFromStringDay: function(day) {
                    switch (day) {
                        case 'Lundi': return 'Mardi';     break;
                        case 'Mardi': return 'Mercredi';  break;
                        case 'Mercredi': return 'Jeudi';  break;
                        case 'Jeudi': return 'Vendredi';  break;
                        case 'Vendredi': return 'Samedi'; break;
                        case 'Samedi': return 'Dimanche'; break;
                        case 'Dimanche': return 'Lundi';  break;
                    }
                },
                getStringDayFromNumberDay: function(day) {
                    switch (day) {
                        case 0: return 'Dimanche';     break;
                        case 1: return 'Lundi';        break;
                        case 2: return 'Mardi';        break;
                        case 3: return 'Mercredi';     break;
                        case 4: return 'Jeudi';        break;
                        case 5: return 'Vendredi';     break;
                        case 6: return 'Samedi';       break;
                    }
                },
                getDateFromDayInCurrentCalendarDate: function(day) {
                    var date = new Date(myCalendar.getDate(false));
                    switch (day) {
                        case 'Dimanche': return new Date(date.setDate(date.getDate() - date.getDay()/* + 0*/)); break;
                        case 'Lundi':    return new Date(date.setDate(date.getDate() - date.getDay() + 1));     break;
                        case 'Mardi':    return new Date(date.setDate(date.getDate() - date.getDay() + 2));     break;
                        case 'Mercredi': return new Date(date.setDate(date.getDate() - date.getDay() + 3));     break;
                        case 'Jeudi':    return new Date(date.setDate(date.getDate() - date.getDay() + 4));     break;
                        case 'Vendredi': return new Date(date.setDate(date.getDate() - date.getDay() + 5));     break;
                        case 'Samedi':   return new Date(date.setDate(date.getDate() - date.getDay() + 6));     break;
                    }
                },
                loadFromDate: function(date) {
                    var self = this;
                    self.weekevents = [];

                    var modal = $('#loading');
                    modal.modal();

                    $.ajax({
                        method: 'GET',
                        url: '/schedule/week/' + date,
                        success: function (data) {
                            // Sort data to place events that last for 2 days or more
                            let canBeDone = false;
                            for (var k in data.weekevents) {
                                if (data.weekevents[k].length > 0) {
                                    canBeDone = true;
                                    break;
                                }
                            }
                            if (canBeDone)
                                self.sort(data);
                            modal.modal('hide');
                        }
                    });
                }
            },
            created: function () {},
            updated: function () {
                place.load();
            },
            mounted: function() {
                this.loadFromDate(new Date().format('yyyy-mm-dd'));
            },
            beforeMount: function() {}
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