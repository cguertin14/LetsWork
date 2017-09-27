@extends('layouts.master')

@section('styles')
    <style>
        body {
            background-color: #5d5d5d;
        }
    </style>
@endsection

@section('content')

    <h1 class="title-absence" style="color: #ffffff;">Tous les postes</h1>
    <hr style="border-top: 1px solid #474747">

    <div class="layout">
        <div class="col-md-12">
            <div class="centre">
                <table class="table custom-table">
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
                    <div class="col-sm-6 col-sm-offset-5">
                        {{$specialRoles->render('pagination.paginate')}}
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection