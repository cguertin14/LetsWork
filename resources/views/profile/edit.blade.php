@extends('layouts.master')

@section('content')

    <div class="col-md-4" style="height: 100%;">
        <h1>Mon profil</h1>
        <div style="width:100%; height:100%">
            <img src="http://www.garcard.com/images/garcard_symbol.png" style="border-radius: 50%">
        </div>
        <p class="text-center">{{ $user->name }}</p>
        @if($user->employees)
            <ul>
                @foreach ($user->companies as $company)
                    <li><p class="text-center">{{ $company->employees->name }}</p></li>
                    <li><p class="text-center">{{  }}</p></li>
                @endforeach
            </ul>
        @endif
    </div>

@endsection