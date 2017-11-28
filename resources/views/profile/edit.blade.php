@extends('layouts.master')

@section('styles')
    <style>
        body {
            background-color: #5d5d5d;
        }
        .dropzone {
            background-color: #c9c9c9 !important;
        }
    </style>
@endsection

@section('content')
    <div class="row layout">
        <div class="col-md-12 text-center">
            <br>
            <div style="width:100%; height:70%">
                <img id="image" width="200px" height="200px" src="{{asset('image/default-profile.png')}}" style="border-radius: 50%">
            </div>
            <div class="employee">
                <p>{{ $user->fullname }}</p>
            </div>
            <br>
            <div class="col-md-12">
                <div class="centre">
                    {!! Form::open(['method' => 'PATCH', 'action' => 'ProfileController@uploadphoto', 'class' => 'dropzone','id' => 'files']) !!}
                    <div class="text-center">
                        <div class="row dz-default dz-message">
                            <img src="{{asset('image/purple_plus.png')}}" width="10%" height="10%" alt="">
                        </div>
                        <div class="row dz-default dz-message">
                            <strong>Changer la photo de profil</strong>
                        </div>
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
        <div class="col-md-12" style="margin-top: 5%;">
            <div class="centre">
                {!! Form::model($user,['method' => 'PATCH', 'action' => ['ProfileController@update', $user->slug]])!!}
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                {!! Form::label('first_name', 'Prénom', ['class' => 'section-title']) !!}
                                {!! Form::text('first_name', null, ['class' => 'form-control']) !!}
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                {!! Form::label('last_name', 'Nom de famille', ['class' => 'section-title']) !!}
                                {!! Form::text('last_name', null, ['class' => 'form-control']) !!}
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                {!! Form::label('email', 'Adresse Courriel', ['class' => 'section-title']) !!}
                                {!! Form::text('email', null, ['class' => 'form-control']) !!}
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                {!! Form::label('phone_number', 'Téléphone', ['class' => 'section-title']) !!}
                                {!! Form::text('phone_number', null, ['class' => 'form-control phone-number']) !!}
                            </div>
                        </div>
                    </div>

                    <div>
                        {!! Form::submit('Modifier le profil', ['class' => 'btn purplebtn pull-left']) !!}
                    </div>

                {!! Form::close() !!}

                {!! Form::open(['method' => 'DELETE','action' => ['ProfileController@deleteuser',$user->slug]]) !!}
                        {!! Form::submit('Supprimer le profil', ['class' => 'btn btn-danger pull-right confirm_action','c_m_text' => 'Voulez-vous vraiment supprimer cet élément?', 'style' => 'font-size: 17px !important;']) !!}
                {!! Form::close() !!}
            </div>
        </div>
    </div>
    <br>
    <br>

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
    </script>
@endsection