@extends('layouts.master')

@section('styles')
    <style>
        body {
            background-color: #5d5d5d;
        }
    </style>
@endsection

@section('content')

    <div class="page-title-header">
        <h1 class="page-title">Toutes les demandes d'absences</h1>
        <hr class="separator">
    </div>

    <div class="col-md-12">
        <div class="row">
            @if (count($absences) > 0)
                <div class="centre custom-container" style="margin-bottom: 2em !important;">
                    <table id="table" class="table custom-table" style="margin: 0px !important">
                        <thead>
                        <tr class="section-title">
                            <th>Nom de l'employé <span v-on:click="sortEmployee()" id="employeeSort" class="sort"></span></th>
                            <th>Date de début <span v-on:click="sortBegin()" id="beginSort" class="sort"></span></th>
                            <th>Date de fin <span v-on:click="sortEnd()" id="endSort" class="sort"></span></th>
                        </tr>
                        </thead>
                        <tbody id="content">
                        @if($absences)
                            @php
                                $i = 0;
                                \Carbon\Carbon::setLocale('fr');
                            @endphp
                            @foreach($absences as $absence)
                                <tr data-toggle="collapse" data-target="#accordion{{$absence->id}}" class="accordion-toggle section-index" @if ($absence->approved == 1) style="background-color: #552AD6" @else style="background-color: #24817A"  @endif>
                                    <td>{{$absence->employee->user->name}}</td>
                                    <td>{{\Carbon\Carbon::parse($absence->begin)->diffForHumans()}}, {{\Carbon\Carbon::parse($absence->begin)->toDateTimeString()}}</td>
                                    <td>{{\Carbon\Carbon::parse($absence->end)->diffForHumans()}}, {{\Carbon\Carbon::parse($absence->end)->toDateTimeString()}}</td>
                                </tr>
                                <tr>
                                    <td colspan="3" class="hiddenRow">
                                        <div class="accordion-body collapse"  id="accordion{{$absence->id}}">
                                            <div style="height: auto;vertical-align: middle;margin-top: 20px" class="col-md-12">
                                                <div class="row" style="padding: 1em">
                                                    <p style="font-size: 1.2em;font-weight:700;color: white">Raison: </p>
                                                    <p style="font-size: 1.2em;color: white">{{$absence->reason}}</p>
                                                </div>
                                                <div class="row" style="padding: 1em">
                                                    @if ($absence->approved == 0)
                                                        {!! Form::open(['method' => 'PATCH','action' => ['AbsenceController@update',$absence->slug]]) !!}
                                                        <div class="form-group pull-left">
                                                            {!! Form::hidden('approved',1) !!}
                                                            {!! Form::submit('Approuver',['class' => 'btn btn-success','style' => 'background-color:#24817A!important']) !!}
                                                        </div>
                                                        {!! Form::close() !!}
                                                    @else
                                                        <button disabled class="btn purplebtn">Cette absence a été approuvée</button>
                                                    @endif
                                                </div>
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
                            {{$absences->render('pagination.paginate')}}
                        </div>
                    </div>

                </div>
            @else
                @component('components.nothing')
                    @slot('message')
                        Il n'y a pas d'absences
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
                        @if ($sesh['column'] === 'employee')
                            $('#employeeSort').css('background-image',order === 'ASC' ? this.sortUp : this.sortDown);
                        @elseif ($sesh['column'] === 'begin')
                            $('#beginSort').css('background-image',order === 'ASC' ? this.sortUp : this.sortDown);
                        @elseif ($sesh['column'] === 'end')
                            $('#endSort').css('background-image',order === 'ASC' ? this.sortUp : this.sortDown);
                        @endif
                    @endif
                },
                sortEmployee: function() {
                    const order = $('#employeeSort').css('background-image') === this.sortNormal ? 'ASC' :
                                 ($('#employeeSort').css('background-image') === this.sortUp ? 'DESC' : 'ASC');
                    $.ajax({
                        method: 'POST',
                        url: '{{route('absence.sort')}}',
                        data: { column: 'employee', order: order, _token: '{{csrf_token()}}' },
                        success: function () {
                            location.reload();
                        }
                    });
                },
                sortBegin: function() {
                    const order = $('#beginSort').css('background-image') === this.sortNormal ? 'ASC' :
                                 ($('#beginSort').css('background-image') === this.sortUp ? 'DESC' : 'ASC');
                    $.ajax({
                        method: 'POST',
                        url: '{{route('absence.sort')}}',
                        data: { column: 'begin', order: order, _token: '{{csrf_token()}}' },
                        success: function () {
                            location.reload();
                        }
                    });
                },
                sortEnd: function () {
                    const order = $('#endSort').css('background-image') === this.sortNormal ? 'ASC' :
                                 ($('#endSort').css('background-image') === this.sortUp ? 'DESC' : 'ASC');
                    $.ajax({
                        method: 'POST',
                        url: '{{route('absence.sort')}}',
                        data: { column: 'end', order: order, _token: '{{csrf_token()}}' },
                        success: function () {
                            location.reload();
                        }
                    });
                }
            },
            created: function () {;
                this.init();
            }
        });
    </script>
@endsection