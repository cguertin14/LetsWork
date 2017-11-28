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
    <div  style="width:85%;margin-left: auto;margin-right: auto">
        <h1 class="page-title">Liste de mes disponibilités</h1>
        <hr class="separator">
    </div>
    <div class="col-md-12">
        <div class="row layout">
            @if (count($dispos) > 0)
            <div class="centre custom-container">
                <table id="table" class="table custom-table" style="margin: 0">
                    <thead>
                    <tr class="section-title">
                        <th>Date de début <span v-on:click="sortBegin()" id="beginSort" class="sort"></span></th>
                        <th>Date de fin <span v-on:click="sortEnd()" id="endSort" class="sort"></span></th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    @php($i = 0)
                    @foreach($dispos as $dispo)
                        @php($begin=\Carbon\Carbon::parse($dispo->begin))
                        @php($end=\Carbon\Carbon::parse($dispo->end))
                        <tr class="@if ($i % 2 == 0 ) section-index-2 @else section-index @endif" style="cursor: default">
                            <td>{{\App\Tools\Helper::Day($begin)." à ".$begin->hour.":".$begin->minute.":".$begin->second}}</td>
                            <td>{{\App\Tools\Helper::Day($end)." à ".$end->hour.":".$end->minute.":".$end->second}}</td>
                            <td>
                                <div class="pull-right" style="margin-right: 2em">
                                    {{Form::open(['method' => 'DELETE','action' => ['DispoController@destroy',$dispo->id]])}}
                                    {{Form::submit('Supprimer',['class' => 'btn btn-danger confirm_action',"c_m_text"=>"Voulez-vous vraiment supprimer cette disponibilité?"])}}
                                    {{Form::close()}}
                                </div>
                            </td>
                        </tr>
                        @php(++$i)
                    @endforeach
                    </tbody>
                </table>

                <div class="row">
                    <div class="text-center">
                        {{$dispos->render('pagination.paginate')}}
                    </div>
                </div>
            </div>
            @else
                @component('components.nothing')
                    @slot('message')
                        Il n'y a pas de disponibilités
                    @endslot
                @endcomponent
            @endif
        </div>
    </div>
@endsection

@section('scripts')
    @if (count($dispos) > 0)
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
                        @if ($sesh['column'] === 'begin')
                            $('#beginSort').css('background-image',order === 'ASC' ? this.sortUp : this.sortDown);
                        @elseif ($sesh['column'] === 'end')
                            $('#endSort').css('background-image',order === 'ASC' ? this.sortUp : this.sortDown);
                        @endif
                    @endif
                },
                sortBegin: function() {
                    const order = $('#beginSort').css('background-image') === this.sortNormal ? 'ASC' :
                                  ($('#beginSort').css('background-image') === this.sortUp ? 'DESC' : 'ASC');
                    $.ajax({
                        method: 'POST',
                        url: '{{route('dispo.sort')}}',
                        data: { column: 'begin', order: order, _token: '{{csrf_token()}}' },
                        success: function () {
                            location.reload();
                        }
                    });
                },
                sortEnd: function() {
                    const order = $('#endSort').css('background-image') === this.sortNormal ? 'ASC' :
                                  ($('#endSort').css('background-image') === this.sortUp ? 'DESC' : 'ASC');
                    $.ajax({
                        method: 'POST',
                        url: '{{route('dispo.sort')}}',
                        data: { column: 'end', order: order, _token: '{{csrf_token()}}' },
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
    @endif
@endsection