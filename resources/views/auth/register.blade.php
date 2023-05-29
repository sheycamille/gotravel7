@extends('layouts.app')

@section('title', 'Sign up')

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
                    <h1>Sign up</h1>

                    <hr class="hidden-xs">

                    <div class="row">

                        <div class="col-md-6">
                            <form class="form simple" id="new_user" action="{{ route('register') }}" accept-charset="UTF-8"
                                method="post">

                                {{ csrf_field() }}

                                <div class="row sign-up-form">
                                    <div class="col-md-6">
                                        <label for="name"> Firstname</label>
                                        <div class="controls">
                                            <input class="form-control" id="firstname" tabindex="1" type="text"
                                                name="firstname" placeholder="firstname..."
                                                class="@error('firstname') is-invalid @enderror">

                                            @error('firstname')
                                                <span class="alert alert-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="name"> Lastname</label>
                                        <div class="controls">
                                            <input class="form-control" id="lastname" tabindex="1" type="text"
                                                name="lastname" placeholder="lastname..."
                                                class="@error('lastname') is-invalid @enderror">
                                            @error('lastname')
                                                <span class="alert alert-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="row sign-up-form">
                                    <div class="col-md-6">
                                        <label for="username">Username</label>
                                        <div class="controls">
                                            <input class="form-control" id="username" tabindex="1" type="text"
                                                name="username" placeholder="choose a unique nickname..."
                                                class="@error('username') is-invalid @enderror">
                                            @error('username')
                                                <span class="alert alert-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="user_email">Email</label>
                                        <div class="controls">
                                            <input class="form-control" id="email" tabindex="2" type="email"
                                                value="" name="email" class="@error('email') is-invalid @enderror"
                                                placeholder="your email address..">
                                            @error('email')
                                                <span class="alert alert-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="row sign-up-form">
                                    <div class="col-md-8">
                                        <label for="phone_number">Phone number</label>
                                        <div class="controls">
                                            <input class="form-control" id="phone_number" tabindex="3" type="text"
                                                name="phone_number" placeholder="enter your main phone number..."
                                                class="@error('phone_number') is-invalid @enderror">
                                            @error('phone_number')
                                                <span class="alert alert-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="type">You are looking...</label>
                                        <div class="controls">
                                            <select class="form-control" id="type" tabindex="4" type="type"
                                                value="" name="type">

                                                <option selected value="passenger">for a ride</option>
                                                <option value="driver">to offer a ride</option>
                                            </select>

                                        </div>
                                    </div>
                                </div>

                                <div class="row sign-up-form">
                                    <div class="col-md-6">
                                        <label for="password">Choose password</label>
                                        <div class="controls">
                                            <input class="form-control" id="password" tabindex="5" type="password"
                                                name="password" aria-autocomplete="list"
                                                class="@error('password') is-invalid @enderror">
                                            @error('password')
                                                <span class="alert alert-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                                            <label class="control-label">
                                                <label for="password_confirmation">Confirm password</label>
                                            </label>
                                            <div class="controls">
                                                <input class="form-control" id="password-confirmation" tabindex="6"
                                                    type="password" name="password_confirmation"
                                                    class="@error('password_confirmation') is-invalid @enderror">
                                                @error('password_confirmation')
                                                    <span class="alert alert-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>     

                                <p class="small">By clicking on 'Sign up' you accept our
                                    <a class="black underline:hover" href="/terms">terms of
                                        service</a>.
                                </p>

                                <div class="form-group">
                                    <div class="controls">
                                        <input type="submit" name="commit" value="Sign up" class="btn btn-brand"
                                            id="signup-btn" tabindex="6">
                                    </div>
                                </div>
                                <hr>
                                <p class="small">Already a member? <a href="{{ route('login') }}">Log in</a>
                                </p>
                            </form>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
