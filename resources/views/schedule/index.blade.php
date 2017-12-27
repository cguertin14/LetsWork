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
    <script type="text/javascript" src="{{ asset('js/schedule.js') }}"></script>
@endsection