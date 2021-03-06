@extends('layouts.top')

@section('styles')
    <style>
        body {
            background-color: #474747;
        }
    </style>
@endsection

@section('contenu')
    <div class="outer">
        <div class="middle">
            <div class="inner">
                <div class="text-center">
                    <a  href="/"><img src="{{asset('image/LetsWw.png')}}" height="100px" width="auto" alt=""></a>
                </div>
                <br>
                <br>
                <div class="container" style="width: 50%;">
                    <div class="row">
                        <div class="col-md-8 col-md-offset-2">
                            <div class="panel panel-default">
                                <div class="panel-heading text-center formLaravel">S'inscrire</div>
                                <div class="panel-body">
                                    <form class="form-horizontal" method="POST" action="{{ route('register') }}">
                                        {{ csrf_field() }}

                                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                                            <div class="col-md-12">
                                                <input id="email" type="email" placeholder="Adresse courriel" class="form-control" name="email" value="{{ old('email') }}" required autofocus>

                                                @if ($errors->has('email'))
                                                    <span class="help-block">
                                                        <strong>{{ $errors->first('email') }}</strong>
                                                    </span>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                                            <div class="col-md-12">
                                                <input id="name" placeholder="Nom d'usager" type="text" class="form-control" name="name" value="{{ old('name') }}" required>

                                                @if ($errors->has('name'))
                                                    <span class="help-block">
                                                        <strong>{{ $errors->first('name') }}</strong>
                                                    </span>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="form-group{{ $errors->has('first_name') ? ' has-error' : '' }}">
                                            <div class="col-md-12">
                                                <input id="first_name" placeholder="Prénom" type="text" class="form-control" name="first_name" value="{{ old('first_name') }}" required autofocus>

                                                @if ($errors->has('first_name'))
                                                    <span class="help-block">
                                                        <strong>{{ $errors->first('first_name') }}</strong>
                                                    </span>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="form-group{{ $errors->has('last_name') ? ' has-error' : '' }}">
                                            <div class="col-md-12">
                                                <input id="last_name" placeholder="Nom de famille" type="text" class="form-control" name="last_name" value="{{ old('last_name') }}" required autofocus>

                                                @if ($errors->has('last_name'))
                                                    <span class="help-block">
                                                        <strong>{{ $errors->first('last_name') }}</strong>
                                                    </span>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="form-group{{ $errors->has('phone_number') ? ' has-error' : '' }}">
                                            <div id="phone_container" class="col-md-12">
                                                <input id="phone_number" placeholder="Numéro de téléphone" type="text" class="form-control phone-number" name="phone_number" value="{{ old('phone_number') }}" required autofocus>

                                                @if ($errors->has('phone_number'))
                                                    <span class="help-block">
                                                        <strong id="phone_errors">{{ $errors->first('phone_number') }}</strong>
                                                    </span>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                                            <div class="col-md-12">
                                                <input id="password" placeholder="Mot de passe" type="password" class="form-control" name="password" required>

                                                @if ($errors->has('password'))
                                                    <span class="help-block">
                                                        <strong>{{ $errors->first('password') }}</strong>
                                                    </span>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <div class="col-md-12">
                                                <input id="password-confirm" placeholder="Mot de passe de confirmation" type="password" class="form-control" name="password_confirmation" required>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <div class="col-md-12">
                                                <button id="submit" type="submit" class="btn purplebtn">
                                                    Soumettre
                                                </button>
                                                <a href="/login" class="btn btn-link pull-right formLaravel">Je possède un compte</a>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="text-center">
                {!! Form::open(['method' => 'POST', 'action' => 'FacebookAuthController@login', 'id' => 'FBForm']) !!}
                <div scope="email" onlogin="checkLoginState();" class="fb-login-button" data-max-rows="1" data-size="large" data-button-type="continue_with" data-show-faces="false" data-auto-logout-link="false" data-use-continue-as="true"></div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
@endsection

@section('scriptsm')
    <script>
        function checkLoginState() {
            FB.login(function(response) {
                if (response.status === 'connected') {
                    var accessToken = response.authResponse.accessToken;
                    let input = $('<input>').attr('type','hidden').attr('name','access_token').val(accessToken);
                    $('#FBForm').append($(input));
                    $('#FBForm').submit();
                }
            }, {scope:'email'});
        }
        (function(d, s, id) {
            var js, fjs = d.getElementsByTagName(s)[0];
            if (d.getElementById(id)) return;
            js = d.createElement(s); js.id = id;
            js.src = 'https://connect.facebook.net/fr_CA/sdk.js#xfbml=1&version=v2.11&appId=905290879647809';
            fjs.parentNode.insertBefore(js, fjs);
        }(document, 'script', 'facebook-jssdk'));
    </script>
@endsection
