@extends('layouts.master')

@section('styles')
    <style>

    </style>
@endsection

@section('content')
        <div>
            @foreach($compagnies as $compagny)
                @component('components.accordion-card')
                    @slot('cardname')
                        {{ $compagny["name"] }}
                    @endslot
                    @slot('cardlink')
                            /company/{{ $compagny["name"] }}
                    @endslot
                    @slot('cardlinktext')
                            Lien vers {{$compagny["name"]}}
                    @endslot
                    @slot('cardbody')
                            {{ $compagny["description"] }}
                    @endslot
                @endcomponent
            @endforeach
        </div>
@endsection