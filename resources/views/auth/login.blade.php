@extends('layouts.app')

@section('title', 'Login')

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
                    <h1>Log in</h1>
                    <hr class="hidden-xs">
                    <div class="row">
                        <div class="col-md-4">
                            <form class="form simple" id="new_user" action="{{ route('login') }}" accept-charset="UTF-8"
                                method="post">
                                {{ csrf_field() }}

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

                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="remember" id="user_remember_me"
                                            {{ old('remember') ? 'checked' : '' }}> Remember me
                                    </label>
                                </div>

                                <div class="form-group">
                                    <div class="controls">
                                        <input type="submit" name="commit" value="Log in" class="btn btn-brand sign-in">
                                    </div>
                                </div>

                                <hr>

                                <p class="small">
                                    No profile?
                                    <a href="{{ route('register') }}">Sign up</a><br>
                                    Forgot your password?
                                    <a href="{{ route('forget.password') }}">Reset here</a>
                                </p>
                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
