@extends('layouts.master')

@section('styles')
    <style>
        body {
            background-color: #5d5d5d;
        }
    </style>
@endsection

@section('content')

    <h1 class="page-title">Tous les postes</h1>
    <hr style="border-top: 1px solid #474747">

    <div class="layout">
        <div class="col-md-12">
            @if(count($specialRoles) > 0)
            <div class="centre custom-container">
                <table class="table custom-table" style="margin: 0px !important;">
                    <thead>
                        <tr class="section-title">
                           <th>Nom</th>
                           <th>Description</th>
                           <th>Rôles</th>
                           <th>Compétences</th>
                        </tr>
                    </thead>
                    <tbody class="section">
                        @if($specialRoles)
                            @foreach($specialRoles as $specialRole)
                                <tr class="clickable-section" data-href="{{route('specialrole.edit',$specialRole->slug)}}">
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