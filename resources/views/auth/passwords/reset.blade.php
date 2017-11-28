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
                                <div class="panel-heading text-center formLaravel">Réinitialisation du mot de passe</div>
                                <div class="panel-body">
                                    @if (session('status'))
                                        <div class="alert alert-success">
                                            {{ session('status') }}
                                        </div>
                                    @endif

                                    <form class="form-horizontal" method="POST" action="{{ route('password.request') }}">
                                        {{ csrf_field() }}

                                        <input type="hidden" name="token" value="{{ $token }}">

                                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                                            <div class="col-md-12">
                                                <input id="email" placeholder="Adresse e-mail" type="email" class="form-control" name="email" value="{{ $email or old('email') }}" required autofocus>

                                                @if ($errors->has('email'))
                                                    <span class="help-block">
                                                        <strong>{{ $errors->first('email') }}</strong>
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

                                        <div class="form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                                            <div class="col-md-12">
                                                <input placeholder="Mot de passe de confirmation" id="password-confirm" type="password" class="form-control" name="password_confirmation" required>

                                                @if ($errors->has('password_confirmation'))
                                                    <span class="help-block">
                                                        <strong>{{ $errors->first('password_confirmation') }}</strong>
                                                    </span>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <div class="col-md-12">
                                                <button type="submit" class="btn purplebtn">
                                                    Réinitialiser le mot de passe
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
