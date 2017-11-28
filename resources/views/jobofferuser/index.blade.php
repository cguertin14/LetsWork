@extends('layouts.master')

@section('styles')
    <style>
        body {
            background-color: #5d5d5d;
        }
    </style>
@endsection

@section('content')

    <div  style="width:85%;margin-left: auto;margin-right: auto">
        <h1 class="page-title">Toutes les demandes d'emplois</h1>
        <hr class="separator">
    </div>

    <div class="col-md-12">
        <div class="row">
            @if (count($jobofferusers) > 0)
            <div class="centre custom-container" style="margin-bottom: 2em !important;">
                <table id="table" class="table custom-table" style="margin: 0px !important">
                    <thead>
                    <tr class="section-title">
                        <th>Nom de l'appliquant <span v-on:click="sortFullName()" id="fullnameSort" class="sort"></span></th>
                        <th>Poste voulu <span v-on:click="sortPoste()" id="posteSort" class="sort"></span></th>
                        <th>Demande <span v-on:click="sortPublication()" id="dateSort" class="sort"></span></th>
                    </tr>
                    </thead>
                    <tbody>
                    @if($jobofferusers)
                        @php($i = 0)
                        @foreach($jobofferusers as $jobofferuser)
                            <tr data-toggle="collapse" data-target="#accordion{{$jobofferuser->id}}" class="accordion-toggle section-index">
                                <td>{{$jobofferuser->user->name}}</td>
                                <td>{{$jobofferuser->joboffer->specialrole->name}}</td>
                                <td>{{$jobofferuser->created_at->diffForHumans()}}</td>
                            </tr>
                            <tr>
                                <td colspan="3" class="hiddenRow">
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
                        @if ($sesh['column'] === 'fullname')
                            $('#fullnameSort').css('background-image',order === 'ASC' ? this.sortUp : this.sortDown);
                        @elseif ($sesh['column'] === 'poste')
                            $('#posteSort').css('background-image',order === 'ASC' ? this.sortUp : this.sortDown);
                        @elseif ($sesh['column'] === 'created_at')
                            $('#dateSort').css('background-image',order === 'ASC' ? this.sortUp : this.sortDown);
                        @endif
                    @endif
                },
                sortFullName: function() {
                    const order = $('#fullnameSort').css('background-image') === this.sortNormal ? 'ASC' :
                                  ($('#fullnameSort').css('background-image') === this.sortUp ? 'DESC' : 'ASC');
                    $.ajax({
                        method: 'POST',
                        url: '{{route('jobofferuser.sort')}}',
                        data: { column: 'fullname', order: order, _token: '{{csrf_token()}}' },
                        success: function () {
                            location.reload();
                        }
                    });
                },
                sortPoste: function() {
                    const order = $('#posteSort').css('background-image') === this.sortNormal ? 'ASC' :
                                  ($('#posteSort').css('background-image') === this.sortUp ? 'DESC' : 'ASC');
                    $.ajax({
                        method: 'POST',
                        url: '{{route('jobofferuser.sort')}}',
                        data: { column: 'poste', order: order, _token: '{{csrf_token()}}' },
                        success: function () {
                            location.reload();
                        }
                    });
                },
                sortPublication: function () {
                    const order = $('#dateSort').css('background-image') === this.sortNormal ? 'ASC' :
                                  ($('#dateSort').css('background-image') === this.sortUp ? 'DESC' : 'ASC');
                    $.ajax({
                        method: 'POST',
                        url: '{{route('jobofferuser.sort')}}',
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