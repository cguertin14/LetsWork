@extends('layouts.master')

@section('styles')
    <style>
        body {
            background-color: #5d5d5d;
        }
    </style>
@endsection

@section('content')

    <h1 class="page-title">Toutes les demandes d'emplois</h1>
    <hr class="separator">

    <div class="col-md-12">
        <div class="row layout">
            @if (count($jobofferusers) > 0)
            <div class="centre custom-container" style="margin-bottom: 2em !important;">
                <table class="table custom-table" style="margin: 0px !important">
                    <thead>
                    <tr class="section-title">
                        <th>Nom de l'appliquant <span class="sort"></span></th>
                        <th>Poste <span class="sort"></span></th>
                        <th>Demande <span class="sort"></span></th>
                    </tr>
                    </thead>
                    <tbody>
                    @if($jobofferusers)
                        @php($i = 0)
                        @foreach($jobofferusers as $jobofferuser)
                            <tr data-toggle="collapse" data-target="#accordion{{$jobofferuser->id}}" class="accordion-toggle @if ($i % 2 == 0 ) section-index-2 @else section-index @endif">
                                <td>{{$jobofferuser->user->fullname}}</td>
                                <td>{{$jobofferuser->joboffer->specialrole->name}}</td>
                                <td>{{$jobofferuser->created_at->diffForHumans()}}</td>
                            </tr>
                            <tr>
                                <td colspan="4" class="hiddenRow">
                                    <div class="accordion-body collapse"  id="accordion{{$jobofferuser->id}}">
                                        <div style="height: 60px;vertical-align: middle;margin-top: 20px" class="col-md-12">
                                            <a class="btn purplebtn pull-right" href="{{route('jobofferuser.show',$jobofferuser->id)}}">
                                                Voir les détails
                                            </a>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            @php(++$i)
                        @endforeach
                    @endif
                    </tbody>
                </table>

                <div class="row">
                    <div class="text-center">
                        {{$jobofferusers->render('pagination.paginate')}}
                    </div>
                </div>

            </div>
            @else
                @component('components.nothing')
                    @slot('message')
                        Il n'y a pas de demandes d'emploi
                    @endslot
                @endcomponent
            @endif
        </div>
    </div>

@endsection

@section('scripts')
    <script>
        new Vue({
            el: '#table',
            data: {
                sortNormal:  'url("http://letswork.dev/image/sort.png")',
                sortUp:      'url("http://letswork.dev/image/sortup.png")',
                sortDown:    'url("http://letswork.dev/image/sortdown.png")'
            },
            computed: {},
            methods: {
                init: function() {
                    // Place correct images for sorting in header columns
                    @if (count($sesh) > 0)
                        let order = '{{$sesh['order']}}';
                        @if ($sesh['column'] === 'name')
                            $('#titleSort').css('background-image',order === 'ASC' ? this.sortUp : this.sortDown);
                        @elseif ($sesh['column'] === 'companyName')
                            $('#companySort').css('background-image',order === 'ASC' ? this.sortUp : this.sortDown);
                        @elseif ($sesh['column'] === 'companyCity')
                            $('#citySort').css('background-image',order === 'ASC' ? this.sortUp : this.sortDown);
                        @elseif ($sesh['column'] === 'created_at')
                            $('#publicationSort').css('background-image',order === 'ASC' ? this.sortUp : this.sortDown);
                        @endif
                    @endif
                },
                sortTitle: function() {
                    const order = $('#titleSort').css('background-image') === this.sortNormal ? 'ASC' :
                        ($('#titleSort').css('background-image') === this.sortUp ? 'DESC' : 'ASC');
                    $.ajax({
                        method: 'POST',
                        url: '{{route('joboffer.sort')}}',
                        data: { column: 'name', order: order, _token: '{{csrf_token()}}' },
                        success: function () {
                            location.reload();
                        }
                    });
                },
                sortCompany: function() {
                    const order = $('#companySort').css('background-image') === this.sortNormal ? 'ASC' :
                        ($('#companySort').css('background-image') === this.sortUp ? 'DESC' : 'ASC');
                    $.ajax({
                        method: 'POST',
                        url: '{{route('joboffer.sort')}}',
                        data: { column: 'companyName', order: order, _token: '{{csrf_token()}}' },
                        success: function () {
                            location.reload();
                        }
                    });
                },
                sortCity: function() {
                    const order = $('#citySort').css('background-image') === this.sortNormal ? 'ASC' :
                        ($('#citySort').css('background-image') === this.sortUp ? 'DESC' : 'ASC');
                    $.ajax({
                        method: 'POST',
                        url: '{{route('joboffer.sort')}}',
                        data: { column: 'companyCity', order: order, _token: '{{csrf_token()}}' },
                        success: function () {
                            location.reload();
                        }
                    });
                },
                sortPublication: function () {
                    const order = $('#publicationSort').css('background-image') === this.sortNormal ? 'ASC' :
                        ($('#publicationSort').css('background-image') === this.sortUp ? 'DESC' : 'ASC');
                    $.ajax({
                        method: 'POST',
                        url: '{{route('joboffer.sort')}}',
                        data: { column: 'created_at', order: order, _token: '{{csrf_token()}}' },
                        success: function () {
                            location.reload();
                        }
                    });
                }
            },
            created: function () {
                this.init();
            },
            updated: function () {

            },
            mounted: function () {

            }
        });
    </script>
@endsection