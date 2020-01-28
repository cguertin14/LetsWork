@extends('layouts.master')

@section('styles')
    <style>
        body {
            background-color: #5d5d5d;
        }
        .employee > p {
            font-family: 'Montserrat',sans-serif;
        }
        .information > .row > .col-md-6 > p, .information > .row > .col-md-6 > label, .information > p {
            font-family: 'Montserrat',sans-serif;
        }
        .form-group > label {
            font-family: 'Montserrat',sans-serif;
        }
    </style>
@endsection

@section('content')
    <div class="row" style="padding: 5em;margin-top: 5em">
        <div class="col-md-4">
            <img id="image" src="{{asset('image/default-profile.png')}}" style="border-radius: 5%; border: 0.8em solid #b9b9b9;cursor: pointer;width: auto;height: auto;max-height: 440px; max-width: 500px">
        </div>
        <div class="col-md-8" id="content">
            <div class="col-md-12 information" style="margin-top: 2em">
                <p style="font-weight: 900;font-size: 1.3em">Information Professionnelle</p>
                <hr style="color: #ffffff;margin-top: -0.2em">
                <div class="row">
                    <div class="col-md-6">
                        <label for="">Compagnie</label>
                        <p>{{ $user->employees()->first() ? $user->employees()->first()->specialroles()->first()->company->name : 'Aucun emploi' }}</p>
                    </div>
                    <div class="col-md-6">
                        <label for="">Poste</label>
                        <p>{{ $user->employees()->first() ? $user->employees()->first()->specialroles()->first()->name : 'Aucun emploi' }}</p>
                    </div>
                </div>
            </div>
            <div class="col-md-12 information" style="margin-top: 2em">
                <p style="font-weight: 900;font-size: 1.3em">Information Personnelle</p>
                <hr style="color: #ffffff;margin-top: -0.2em">
                <div class="row">
                    <div class="col-md-6">
                        <label for="">Prénom</label>
                        <p>{{ $user->first_name }}</p>
                    </div>
                    <div class="col-md-6">
                        <label for="">Nom</label>
                        <p>{{ $user->last_name }}</p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6" style="margin-top: 0.5em">
                        <label for="">Téléphone</label>
                        <p>{{ $user->phone_number ? $user->phone_number : 'Pas de numéro de téléphone'}}</p>
                    </div>
                    <div class="col-md-6" style="margin-top: 0.5em">
                        <label for="">Adresse Courriel</label>
                        <p><a href="mailto:{{ $user->email }}" style="text-decoration: none; color: inherit;">{{ $user->email }}</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('scripts')
    <script>
        @if($user->photo)
            setUserProfilePic('{{route('profile.photo',$user->slug)}}');
        @else
            $('#image').attr('src','{{asset('image/default-profile.png')}}');
        @endif

        $(function() {
            function resize () {
                const mq = window.matchMedia("screen and (min-width: 1850px)"),
                      mq2 = window.matchMedia("screen and (min-width: 870px)"),
                      mq3 = window.matchMedia("screen and (min-width: 767px)")  ;

                if (mq.matches) {
                    $('#content').addClass('col-md-8').removeClass('col-md-12');
                } else {
                    $('#content').addClass('col-md-12').removeClass('col-md-8');
                }

                if (mq2.matches) {
                    $('#image').width(440);
                } else {
                    $('#image').width(330);
                }

                if (!mq3.matches) {
                    $('#image').width(440);
                }
            }
            $(window).resize(function() { resize(); });

            resize();
        });
    </script>
@endsection