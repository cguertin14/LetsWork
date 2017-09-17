@extends('layouts.master')

@section('styles')
    <style>

    </style>
@endsection

@section('content')
    <div class="col-md-12">
        <div id="accordion" role="tablist">
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
                            {{ $compagny["name"] }}
                    @endslot
                @endcomponent
            @endforeach
        </div>
    </div>
@endsection