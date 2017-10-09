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
            color: #A2B9B2 !important;
            text-decoration: none !important;
        }
        body {
            font-size: 1.6rem !important;
            font-family: "Source Sans Pro", sans-serif!important;
            color: #222222!important;
            background-color: white!important;
        }
        html {
            font-size: 62.5% !important;
        }
        html, body, div, span, applet, object, iframe,
        h1, h2, h3, h4, h5, h6, p, blockquote, pre,
        a, abbr, acronym, address, big, cite, code,
        del, dfn, em, img, ins, kbd, q, s, samp,
        small, strike, strong, sub, sup, tt, var,
        b, u, i, center,
        dl, dt, dd, ol, ul, li,
        fieldset, form, label, legend,
        table, caption, tbody, tfoot, thead, tr, th, td,
        article, aside, canvas, details, embed,
        figure, figcaption, footer, header, hgroup,
        menu, nav, output, ruby, section, summary,
        time, mark, audio, video {
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
        body {
            line-height: 1!important;
        }
        ol, ul {
            list-style: none !important;
        }
        blockquote, q {
            quotes: none!important;
        }
        blockquote:before, blockquote:after,
        q:before, q:after {
            content: ''!important;
            content: none!important;
        }
        table {
            border-collapse: collapse!important;
            border-spacing: 0!important;
        }
    </style>
@endsection

@section('content')
    <div class="cd-schedule loading">
        <div class="timeline">
            <ul id="hour-container"></ul>
        </div> <!-- .timeline -->

        <div class="events">
            <ul>
                <li class="events-group">
                    <div class="top-info"><span>Lundi</span></div>

                    <ul>
                        <li class="single-event" data-start="09:30" data-end="10:30" data-content="event-abs-circuit" data-event="event-1">
                            <a href="#0">
                                <em class="event-name">Abs Circuit</em>
                            </a>
                        </li>

                        <li class="single-event" data-start="11:00" data-end="12:30" data-content="allomartine" data-event="event-2">
                            <a href="#0">
                                <em class="event-name">Rowing Workout</em>
                            </a>
                        </li>

                        <li class="single-event" data-start="14:00" data-end="15:15"  data-content="event-yoga-1" data-event="event-3">
                            <a href="#0">
                                <em class="event-name">Yoga Level 1</em>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="events-group">
                    <div class="top-info"><span>Mardi</span></div>

                    <ul>
                        <li class="single-event" data-start="10:00" data-end="11:00"  data-content="event-rowing-workout" data-event="event-2">
                            <a href="#0">
                                <em class="event-name">Rowing Workout</em>
                            </a>
                        </li>

                        <li class="single-event" data-start="11:30" data-end="13:00"  data-content="event-restorative-yoga" data-event="event-4">
                            <a href="#0">
                                <em class="event-name">Restorative Yoga</em>
                            </a>
                        </li>

                        <li class="single-event" data-start="13:30" data-end="15:00" data-content="event-abs-circuit" data-event="event-1">
                            <a href="#0">
                                <em class="event-name">Abs Circuit</em>
                            </a>
                        </li>

                        <li class="single-event" data-start="15:45" data-end="16:45"  data-content="event-yoga-1" data-event="event-3">
                            <a href="#0">
                                <em class="event-name">Yoga Level 1</em>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="events-group">
                    <div class="top-info"><span>Mercredi</span></div>

                    <ul>
                        <li class="single-event" data-start="09:00" data-end="10:15" data-content="event-restorative-yoga" data-event="event-4">
                            <a href="#0">
                                <em class="event-name">Restorative Yoga</em>
                            </a>
                        </li>

                        <li class="single-event" data-start="10:45" data-end="11:45" data-content="event-yoga-1" data-event="event-3">
                            <a href="#0">
                                <em class="event-name">Yoga Level 1</em>
                            </a>
                        </li>

                        <li class="single-event" data-start="12:00" data-end="13:45"  data-content="event-rowing-workout" data-event="event-2">
                            <a href="#0">
                                <em class="event-name">Rowing Workout</em>
                            </a>
                        </li>

                        <li class="single-event" data-start="13:45" data-end="15:00" data-content="event-yoga-1" data-event="event-3">
                            <a href="#0">
                                <em class="event-name">Yoga Level 1</em>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="events-group">
                    <div class="top-info"><span>Jeudi</span></div>

                    <ul>
                        <li class="single-event" data-start="09:30" data-end="10:30" data-content="event-abs-circuit" data-event="event-1">
                            <a href="#0">
                                <em class="event-name">Abs Circuit</em>
                            </a>
                        </li>

                        <li class="single-event" data-start="12:00" data-end="13:45" data-content="event-restorative-yoga" data-event="event-4">
                            <a href="#0">
                                <em class="event-name">Restorative Yoga</em>
                            </a>
                        </li>

                        <li class="single-event" data-start="15:30" data-end="16:30" data-content="event-abs-circuit" data-event="event-1">
                            <a href="#0">
                                <em class="event-name">Abs Circuit</em>
                            </a>
                        </li>

                        <li class="single-event" data-start="17:00" data-end="18:30"  data-content="event-rowing-workout" data-event="event-2">
                            <a href="#0">
                                <em class="event-name">Rowing Workout</em>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="events-group">
                    <div class="top-info"><span>Vendredi</span></div>

                    <ul>
                        <li class="single-event" data-start="10:00" data-end="11:00"  data-content="event-rowing-workout" data-event="event-2">
                            <a href="#0">
                                <em class="event-name">Rowing Workout</em>
                            </a>
                        </li>

                        <li class="single-event" data-start="12:30" data-end="14:00" data-content="event-abs-circuit" data-event="event-1">
                            <a href="#0">
                                <em class="event-name">Abs Circuit</em>
                            </a>
                        </li>

                        <li class="single-event" data-start="15:45" data-end="16:45"  data-content="event-yoga-1" data-event="event-3">
                            <a href="#0">
                                <em class="event-name">Yoga Level 1</em>
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>

        <div class="event-modal">
            <header class="header">
                <div class="content">
                    <span class="event-date"></span>
                    <h3 class="event-name"></h3>
                </div>

                <div class="header-bg"></div>
            </header>

            <div class="body">
                <div class="event-info"></div>
                <div class="body-bg"></div>
            </div>

            <a href="#0" class="close">Close</a>
        </div>

        <div class="cover-layer"></div>
    </div> <!-- .cd-schedule -->
    <div id="carbonads-container">
        <div class="carbonad">
            <script async type="text/javascript" src="//cdn.carbonads.com/carbon.js?zoneid=1673&serve=C6AILKT&placement=codyhouseco" id="_carbonads_js"></script>
        </div>
        <a href="#0" class="close-carbon-adv">Close</a>
    </div> <!-- #carbonads-container -->

   <!--
    <div id="schedule">
        <div>
            <div class="col-md-1 pull-left"><h1>@{{ ctime.toLocaleTimeString() }}</h1></div>
        </div>
        <table>
            <thead>
                <tr>
                    <td class="spacing"><h1 class="center">Heures</h1></td>
                    <td class="spacing" v-for="d in days"><h1 class="center">@{{d}}</h1></td>
                </tr>
            </thead>
            <tbody id="tbody">
                <tr id="line" style="border-top:medium red solid; position:absolute;top: -50px; width:100%;"></tr>
                <tr v-for="h in 25">
                    <td class="spacing">
                        <h3 class="center pull-right" style="position: relative;top: -1.4em">@{{ h-1 +":00" }}</h3>
                    </td>
                    <td class="spacing" v-for="d in days" :data-day="d" :data-hour="h" :data-date="new Date()"><h3
                                class="center"></h3></td>
                </tr>
            </tbody>
        </table>
    </div>
    -->
@endsection

@section('scripts')
    <script>
        for (var i=0; i<=23;++i)
            $("#hour-container").append("<li><span>" + (i < 10 ? "0" + i : i) + ":00</span></li>" + "<li><span>" +
                (i < 10 ? "0" + i : i) + ":30</span></li>");
    </script>
    <script>
        //        var schedule = new Vue({
//            el: "#schedule",
//            data: {
//                days: ["Lundi", "Mardi", "Mercredi", "Jeudi", "Vendredi", "Samedi", "Dimanche"],
//                ctime: new Date()
//            },
//            computed: {},
//            methods: {
//                getCurrentDay: function () {
//                    return this.days[new Date().getDay() - 1];
//                }
//            },
//            watch: {},
//            updated: function () {
//            },
//            created: function () {
//            }
//        });
//
//        function ratio(height, sec) {
//            return Number(height) / Number(24 * 60 * 60) * sec;
//        }
//
//        function sec(time) {
//            return time.getHours() * 60 * 60 + time.getMinutes() * 60 + time.getSeconds();
//        }
//
//        var setime = setInterval(function () {
//            schedule.ctime = new Date();
//            var tbody = document.querySelector("thead>tr>td.spacing");
//            var style = window.getComputedStyle ? getComputedStyle(tbody, null) : tbody.currentStyle;
//            var pos = style.height;
//            pos = Number(pos.replace("px", "")) + 60;
//            var td = document.querySelector("tbody>tr>td.spacing");
//            style = window.getComputedStyle ? getComputedStyle(td, null) : td.currentStyle;
//            var tdheight = style.height;
//            tdheight = Number(tdheight.replace("px", ""));
//
//            $("#line").css("top", pos + ratio(tdheight * 24, sec(schedule.ctime)) + "px");
//        }, 500);
    </script>
    <script>
        (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
            (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
            m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
        })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

        ga('create', 'UA-48014931-1', 'codyhouse.co');
        ga('send', 'pageview');

        jQuery(document).ready(function($){
            $('.close-carbon-adv').on('click', function(event){
                event.preventDefault();
                $('#carbonads-container').hide();
            });
        });
    </script>
@endsection