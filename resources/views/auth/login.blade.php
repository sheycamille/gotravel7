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
                                    {{-- <a href="{{ route('password.request') }}">Reset</a> --}}
                                </p>
                            </form>

                            <!-- <div class="col-md-1 hidden-iphone tcenter">
                                    <span class="text-muted or">OR</span>
                                </div>

                               <div class="col-md-4">
                                    <div class="well">
                                        <h1>Social Login</h1>
                                        <p>One-click access:</p>
                                        <p>
                                            <a class="x-fb-login btn btn-lg btn-block btn-facebook" href="">
                                                <i class="fa fa-facebook-square"></i> Sign in with Facebook
                                            </a>
                                            <a class="x-tw-login btn btn-lg btn-block btn-twitter" href="">
                                                <i class="fa fa-twitter-square"></i> Sign in with Twitter
                                            </a>
                                            <a class="x-google-login btn btn-lg btn-block btn-google" href="">
                                                <i class="fa fa-google-plus-square"></i> Sign in with Google
                                            </a>
                                        </p>
                                    </div>
                                </div>-->
                        </div>

                    </div>
                </div>
            </div>
        </div>
    @endsection
