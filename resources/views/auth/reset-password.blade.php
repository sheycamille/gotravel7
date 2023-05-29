@extends('layouts.app')

@section('title', 'Reset Password')

@section('active')

@section('head')
    <style type="text/css">
        .form-control:focus {
            border-color: #4cc417;
            -webkit-box-shadow: none;
            box-shadow: none;
        }

        .navbar .primary .active::after {
            display: none;

        }
    </style>


@endsection

@section('content')

    @include('parts.small_header')

    <div class="main">
        <div class="container">
            <div class="row">

                <div class="col-md-10 col-md-offset-2">
                    @if ($message = Session::get('error'))
                        <div class="alert alert-danger alert-block">
                            <button type="button" class="close" data-dismiss="alert">×</button>
                            <strong>{{ $message }}</strong>
                        </div>
                    @endif

                    @if ($message = Session::get('message'))
                        <div class="alert alert-info alert-block">
                            <button type="button" class="close" data-dismiss="alert">×</button>
                            <strong>{{ $message }}</strong>
                        </div>
                    @endif
                    <h1>Reset Password</h1>
                    <hr class="hidden-xs">
                    <div class="row">
                        <div class="col-md-4">
                            <form class="form simple" id="new_user" action="{{ route('reset.password.post', ['token' => $token]) }}" accept-charset="UTF-8"
                                method="post">
                                {{ csrf_field() }}

                                <input type="hidden" name="token" value="{{ $token }}">

                                <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                                    <label for="email">Email</label>
                                    <div class="controls">
                                        <input class="form-control" id="email" type="text"
                                            value="{{ old('email') }}" name="email">
                                        @if ($errors->has('email'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('email') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="{{ $errors->has('password') ? ' has-error' : '' }}">
                                    <label for="user_password">Password</label>
                                    <div class="controls">
                                        <input class="form-control" id="password" type="password" name="password">
                                        @if ($errors->has('password'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('password') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <br>

                                <div class="{{ $errors->has('password_confirm') ? ' has-error' : '' }}">
                                    <label for="password_confirm">Confrim Password</label>
                                    <div class="controls">
                                        <input class="form-control" id="password_confirm" type="password" name="password_confirm">
                                        @if ($errors->has('password_confirm'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('password_confrim') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                <br>

                                <div class="form-group">
                                    <div class="controls">
                                        <input type="submit" name="commit" value="Reset Password" class="btn btn-brand sign-in">
                                    </div>
                                </div>

                                <hr>

                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
