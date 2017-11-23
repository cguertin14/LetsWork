@extends('layouts.master')

@section('styles')
    <style xmlns:v-on="http://www.w3.org/1999/xhtml" xmlns:v-on="http://www.w3.org/1999/xhtml">
        body {
            background-color: #5d5d5d;
        }
    </style>
@endsection

@section('content')

    <h1 class="page-title">Toutes les compétences</h1>
    <hr class="separator">

    <div class="layout">
        <div class="col-md-12">
            @if (count($skills) > 0)
                <div class="centre custom-container">
                <table id="table" class="table custom-table" style="margin: 0px !important;">
                    <thead>
                    <tr class="section-title">
                        <th>Nom <span id="nameSort" v-on:click="sortName()" class="sort"></span></th>
                        <th>Description <span id="descriptionSort" v-on:click="sortDescription()" class="sort"></span></th>
                    </tr>
                    </thead>
                    <tbody class="section">
                    @if($skills)
                        @php($i = 0)
                        @foreach($skills as $skill)
                            <tr class="clickable-section @if ($i % 2 == 0 ) section-index-2 @else section-index @endif" data-href="{{route('skill.edit',$skill->slug)}}">
                                <td>{{$skill->name}}</td>
                                <td>{{$skill->description}}</td>
                            </tr>
                            @php(++$i)
                        @endforeach
                    @endif
                    </tbody>
                </table>

                <div class="row">
                    <div class="text-center">
                        {{$skills->render('pagination.paginate')}}
                    </div>
                </div>
            </div>
            @else
                @component('components.nothing')
                    @slot('message')
                        Il n'y a pas de compétences
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
                    $('#nameSort').css('background-image',order === 'ASC' ? this.sortUp : this.sortDown);
                    @elseif ($sesh['column'] === 'description')
                    $('#descriptionSort').css('background-image',order === 'ASC' ? this.sortUp : this.sortDown);
                    @endif
                    @endif
                },
                sortName: function() {
                    const order = $('#nameSort').css('background-image') === this.sortNormal ? 'ASC' :
                                  ($('#nameSort').css('background-image') === this.sortUp ? 'DESC' : 'ASC');
                    $.ajax({
                        method: 'POST',
                        url: '{{route('skills.sort')}}',
                        data: { column: 'name', order: order, _token: '{{csrf_token()}}' },
                        success: function () {
                            location.reload();
                        }
                    });
                },
                sortDescription: function() {
                    const order = $('#descriptionSort').css('background-image') === this.sortNormal ? 'ASC' :
                                  ($('#descriptionSort').css('background-image') === this.sortUp ? 'DESC' : 'ASC');
                    $.ajax({
                        method: 'POST',
                        url: '{{route('skills.sort')}}',
                        data: { column: 'description', order: order, _token: '{{csrf_token()}}' },
                        success: function () {
                            location.reload();
                        }
                    });
                },
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