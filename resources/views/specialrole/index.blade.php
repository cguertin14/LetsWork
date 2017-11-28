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
        <h1 class="page-title">Tous les postes</h1>
        <hr style="border-top: 1px solid #474747">
    </div>

    <div class="layout">
        <div id="container" class="col-md-12">
            @if(count($specialRoles) > 0)
            <div class="centre custom-container">
                <table id="table" class="table custom-table" style="margin: 0px !important;">
                    <thead>
                        <tr class="section-title">
                           <th>Nom <span v-on:click="sortName()" id="nameSort" class="sort"></span></th>
                           <th>Description <span v-on:click="sortDescription()" id="descriptionSort" class="sort"></span></th>
                           <th>Rôles</th>
                           <th>Compétences</th>
                        </tr>
                    </thead>
                    <tbody class="section">
                        @if($specialRoles)
                            @php($i = 0)
                            @foreach($specialRoles as $specialRole)
                                <tr class="clickable-section @if ($i % 2 == 0 ) section-index-2 @else section-index @endif" data-href="{{route('specialrole.edit',$specialRole->slug)}}">
                                    <td>{{$specialRole->name}}</td>
                                    <td>{{$specialRole->description}}</td>
                                    <td>
                                        @foreach($specialRole->roles as $role)
                                            @if($role !== $specialRole->roles->get(count($specialRole->roles->toArray()) - 1))
                                                {{$role->content . ","}}
                                            @else
                                                {{$role->content}}
                                            @endif
                                        @endforeach
                                    </td>
                                    <td>
                                        @foreach($specialRole->skills as $skill)
                                            @if($skill !== $specialRole->skills->get(count($specialRole->skills->toArray()) - 1))
                                                {{$skill->name . ","}}
                                            @else
                                                {{$skill->name}}
                                            @endif
                                        @endforeach
                                    </td>
                                </tr>
                                @php(++$i)
                            @endforeach
                        @endif
                    </tbody>
                </table>

                <div class="row">
                    <div class="text-center">
                        {{$specialRoles->render('pagination.paginate')}}
                    </div>
                </div>
            </div>
            @else
                @component('components.nothing')
                    @slot('message')
                        Il n'y a pas de postes
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
                    url: '{{route('specialroles.sort')}}',
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
                    url: '{{route('specialroles.sort')}}',
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