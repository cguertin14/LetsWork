@php

@endphp

@extends('layouts.master')

@section('styles')
    <style>

    </style>
@endsection

@section('content')
    <a href="{{action('ConfirmationController@dovalidate')}}" class="btn purplebtn">Valider</a>
    <a href="{{action('ConfirmationController@docancel')}}" class="btn purplebtn">Annuler</a>
@endsection
