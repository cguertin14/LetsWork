@extends('layouts.master')

@section('styles')
    <style>
        body {
            background-color: #5d5d5d;
        }

        .white {
            color: #ffffff;
        }
    </style>
@endsection

@section('content')
    <h1 class="title-absence white">Liste de mes periodes de travaille</h1>
    <hr class="separator">
    <div class="col-md-12">
        <div class="row layout">
            <div class="centre custom-container">
                <table class="table custom-table">
                    <thead>
                    <tr class="section-title">
                        <th>Date de début</th>
                        <th>Date de fin</th>
                    </tr>
                    </thead>
                    <tbody class="section">
                    @foreach($punches as $punch)
                    <tr>
                        <td>{{$punch->datebegin}}</td>
                        <td>{{$punch->dateend}}</td>
                    </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            <br>
            <a class="btn purplebtn" href="{{route("dispo.create")}}">Ajouter une plage horaire</a>
        </div>
@endsection

@section('scripts')
    <script>

    </script>
@endsection