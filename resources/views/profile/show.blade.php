@extends('layouts.master')

@section('styles')
    <style>
        body {
            background-color: #5d5d5d;
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
        </div>
        <div class="col-md-12" style="margin-top: 5%;">
            <div class="centre">
                {!! Form::model($user)!!}
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            {!! Form::label('first_name', 'Prénom', ['class' => 'section-title']) !!}
                            {!! Form::text('first_name', null, ['class' => 'form-control','disabled']) !!}
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            {!! Form::label('last_name', 'Nom de famille', ['class' => 'section-title']) !!}
                            {!! Form::text('last_name', null, ['class' => 'form-control','disabled']) !!}
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            {!! Form::label('email', 'Adresse Courriel', ['class' => 'section-title']) !!}
                            {!! Form::text('email', null, ['class' => 'form-control','disabled']) !!}
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            {!! Form::label('phone_number', 'Téléphone', ['class' => 'section-title']) !!}
                            {!! Form::text('phone_number', null, ['class' => 'form-control phone-number','disabled']) !!}
                        </div>
                    </div>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
    <br>
    <br>

@endsection

@section('scripts')
    <script>
        @if(\Illuminate\Support\Facades\Auth::user()->photo)
        setUserProfilePic('{{route('profile.photo')}}');
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
                setUserProfilePic('{{route('profile.photo')}}');
            }
        });
    </script>
@endsection