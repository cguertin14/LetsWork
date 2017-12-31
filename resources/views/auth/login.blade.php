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
                <div class="container" style="width: 50%">
                    <div class="row">
                        <div class="col-md-8 col-md-offset-2">
                            <div class="panel panel-default">
                                <div class="panel-heading text-center formLaravel">Connexion</div>
                                <div class="panel-body">
                                    <form class="form-horizontal" method="POST" action="{{ route('login') }}">
                                        {{ csrf_field() }}


                                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                                            <div class="col-md-12">
                                                <input id="email" placeholder="Adresse courriel" type="email" class="form-control" name="email" value="{{ old('email') }}" required autofocus>

                                                @if ($errors->has('email'))
                                                    <span class="help-block">
                                                        <strong>{{ $errors->first('email') }}</strong>
                                                    </span>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                                            <div class="col-md-12">
                                                <input id="password" type="password" class="form-control" name="password" required placeholder="Mot de passe">
                                                @if ($errors->has('password'))
                                                    <span class="help-block">
                                                        <strong>{{ $errors->first('password') }}</strong>
                                                    </span>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <div class="col-md-12">
                                                <button type="submit" class="btn purplebtn">
                                                    Se connecter
                                                </button>
                                                <a class="btn btn-link pull-right formLaravel" href="{{ route('password.request') }}">Mot de passe oublié?</a>
                                            </div>
                                            <div class="col-md-12">
                                                <a class="btn btn-link pull-right formLaravel" href="/register">Pas de compte?</a>
                                            </div>
                                        </div>
                                    </form>
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
