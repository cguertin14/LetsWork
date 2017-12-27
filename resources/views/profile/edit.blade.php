@extends('layouts.master')

@section('styles')
    <style>
        body {
            background-color: #5d5d5d;
        }
        .dropzone {
            background-color: #c9c9c9 !important;
        }
        .employee > p {
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
            <img id="image" width="440px" height="580px" src="{{asset('image/default-profile.png')}}" style="border-radius: 5%; border: 0.8em solid #b9b9b9;cursor: pointer;">
            <div style="display: none">
                {!! Form::open(['method' => 'PATCH', 'action' => 'ProfileController@uploadphoto', 'class' => 'dropzone','id' => 'files']) !!}
                <div class="text-center">
                    <div class="row dz-default dz-message">
                        <img id="imgToClick" src="{{asset('image/purple_plus.png')}}" width="10%" height="10%" alt="">
                    </div>
                    <div class="row dz-default dz-message">
                        <strong style="font-family: 'Montserrat',sans-serif">Changer la photo de profil</strong>
                    </div>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
        <div class="col-md-8" id="content">
            <div class="col-md-12 information" style="margin-top: 2em">
                <p style="font-weight: 900;font-size: 1.3em">Information Professionnelle</p>
                <hr style="color: #ffffff;margin-top: -0.2em">
                <div class="row">
                    <div class="col-md-6">
                        <label for="">Compagnie</label>
                        <p>{{ \App\Tools\Helper::CCompany() ? \App\Tools\Helper::CCompany()->name : 'Aucun emploi' }}</p>
                    </div>
                    <div class="col-md-6">
                        <label for="">Poste</label>
                        <p>{{ $user->employees()->first() ? $user->employees()->first()->specialroles()->first()->name : 'Aucun emploi' }}</p>
                    </div>
                </div>
            </div>
            {!! Form::model($user,['method' => 'PATCH', 'action' => ['ProfileController@update', $user->slug]])!!}
            <div class="col-md-12 information" style="margin-top: 2em">
                <p style="font-weight: 900;font-size: 1.3em">Information Personnelle</p>
                <hr style="color: #ffffff;margin-top: -0.2em">
                <div class="row">
                    <div class="col-md-6 form-group">
                        {!! Form::label('first_name', 'Prénom', ['class' => 'section-title']) !!}
                        {!! Form::text('first_name', null, ['class' => 'form-control']) !!}
                    </div>
                    <div class="col-md-6 form-group">
                        {!! Form::label('last_name', 'Nom de famille', ['class' => 'section-title']) !!}
                        {!! Form::text('last_name', null, ['class' => 'form-control']) !!}
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 form-group" style="margin-top: 0.5em">
                        {!! Form::label('phone_number', 'Téléphone', ['class' => 'section-title']) !!}
                        {!! Form::text('phone_number', null, ['class' => 'form-control phone-number']) !!}
                    </div>
                    <div class="col-md-6 form-group" style="margin-top: 0.5em">
                        {!! Form::label('email', 'Adresse Courriel', ['class' => 'section-title']) !!}
                        {!! Form::text('email', null, ['class' => 'form-control']) !!}
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        @include('include.errors')
                    </div>
                </div>
                @if (Session::has('email_unique') || Session::has('phone_number_unique'))
                    <div class="row">
                        <div class="col-md-12">
                            <div class="alert alert-danger">
                                <ul>
                                    @if (Session::has('email_unique'))
                                        <li style="font-size: 0.8em">{{ session('email_unique') }}</li>
                                    @endif
                                    @if (Session::has('phone_number_unique'))
                                        <li style="font-size: 0.8em">{{ session('phone_number_unique') }}</li>
                                    @endif
                                </ul>
                            </div>
                        </div>
                    </div>
                @endif
                <div class="form-group">
                    {!! Form::submit('Modifier le profil', ['class' => 'btn purplebtn pull-left']) !!}
                    {!! Form::close() !!}

                    {!! Form::open(['method' => 'DELETE','action' => ['ProfileController@deleteuser',$user->slug]]) !!}
                    {!! Form::submit('Supprimer le profil', ['class' => 'btn btn-danger pull-right confirm_action','c_m_text' => 'Voulez-vous vraiment supprimer votre profil?', 'style' => 'font-size: 17px !important;']) !!}
                    {!! Form::close() !!}
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
        Dropzone.autoDiscover = false;
        $("#files").dropzone({
            url: '{{route('profile.uploadphoto')}}',
            acceptedFiles: "image/jpeg,image/png,image/gif",
            maxFiles: 1,
            maxfilesexceeded: function(file) {
                this.removeAllFiles();
                this.addFile(file);
            },
            queuecomplete: function () {
                setUserProfilePic('{{route('profile.photo',$user->slug)}}');
            }
        });

        $(function() {
            $('#image').click(function () {
                $('#imgToClick').trigger('click');
            });
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