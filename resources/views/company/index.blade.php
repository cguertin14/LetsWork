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
                            Lien vers {{substr($compagny["name"],0,25)."..."}}
                    @endslot
                    @slot('cardbody')
                            {{ substr($compagny["description"],0,155)."..." }}
                    @endslot
                @endcomponent
            @endforeach
        </div>
@endsection