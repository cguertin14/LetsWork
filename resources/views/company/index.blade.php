@extends('layouts.master')

@section('styles')
    <style>

    </style>
@endsection

@section('content')
        <div id="accordion" role="tablist" aria-multiselectable="true">
            @foreach($compagnies as $compagny)
                @component('components.accordion-card')
                    @slot('cardname')
                            {{ $compagny["id"] }}
                    @endslot
                    @slot('cardlink')
                            {{ $compagny["name"] }}
                    @endslot
                    @slot('idaccordion')
                            accordion
                    @endslot
                    @slot('cardbody')
                            {{ $compagny["description"] }}
                    @endslot
                @endcomponent
            @endforeach
        </div>
@endsection