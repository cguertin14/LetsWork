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
</style>
@endsection

@section('content')

<div class="parent">
    @if (\Illuminate\Support\Facades\Auth::user()->isOwner())
        <div class="element" style="display: inline-block">
            <h1 class="page-title text-center">Modifier le calendrier</h1>
        </div>
        <div class="element" style="cursor: pointer;display: inline-block;margin-left: 16em" id="new-event">
            <img src="{{asset('image/purple_plus.png')}}" alt="" height="70px" width="70px">
        </div>
    @else
        <h1 class="page-title text-center">Modifier le calendrier</h1>
    @endif

</div>
<hr class="separator">

<div class="modal fade" id="createEventModal" tabindex="-1" role="dialog" aria-hidden="true"></div>

@include('include.calendar-template')
@endsection

@section('scripts')
<script>

</script>
@endsection