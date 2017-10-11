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
</style>
@endsection

@section('content')

<h1 class="page-title text-center">Modifier le calendrier</h1>
<hr class="separator">

<!--

    MODIFIER L'INTERFACE POUR LA FAITE FIT DANS UN MODAL AFIN DE CRÉER UN ÉVÉNEMENT

-->


@include('include.calendar-template')

<!--<div id="schedule">
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
@endsection