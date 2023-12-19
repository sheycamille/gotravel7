@extends('layouts.app')

@section('title', 'Editing My Profile')

@section('active')

@section('sub-menu1', 'active')

@section('content')

@section('head')

    <link rel="stylesheet" href="/assets/plugins/datetimepicker/jquery.datetimepicker.min.css">

@endsection

@include('parts.small_header_extend')
<div class="main ">
    <div class="container">
        <div class="row">

            @include('parts.account_sidebar')

            <div class="col-sm-10">

                <h1>Editing Account Information</h1>

                <hr class="hidden-xs">

                <div class="col-md-6">
                    <form class="form simple" action="{{ route('update-profile') }}" accept-charset="UTF-8"
                        method="post" enctype="multipart/form-data">
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('username') ? ' has-error' : '' }}">
                            <label for="username">username</label>
                            <div class="controls">
                                <input class="form-control places-search" id="username" type="text"
                                    value="{{ $user->username }}" name="username"  placeholder="username">
                                @if ($errors->has('username'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('username') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('avatar') ? ' has-error' : '' }}">
                            <label for="avatar">Profile Picture</label>
                            <div class="controls">
                                <input class="form-control places-search" id="avatar" type="file"
                                    value="{{ $user->avatar }}" name="avatar" 
                                    placeholder="your profile pic...">
                                @if ($errors->has('avatar'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('avatar') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label for="email">Email</label>
                            <div class="controls">
                                <input class="form-control places-search" id="email" type="text"
                                    value="{{ $user->email }}" name="email" autofocus placeholder="doe@...">
                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('phone_number') ? ' has-error' : '' }}">
                            <label for="phone_number">Phone Number</label>
                            <div class="controls">
                                <input class="form-control places-search" id="phone_number" type="text"
                                    value="{{ $user->phone_number }}" name="phone_number" required autofocus
                                    placeholder="+23767....">
                                @if ($errors->has('phone_number'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('phone_number') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('primary_address') ? ' has-error' : '' }}">
                            <label for="primary_address">Primary Address</label>
                            <div class="controls">
                                <input class="form-control places-search" id="primary_address" type="text"
                                    value="{{ $user->primary_address }}" name="primary_address" required autofocus
                                    placeholder="malingo, buea">
                                @if ($errors->has('primary_address'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('primary_address') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('nic') ? ' has-error' : '' }}">
                            <label for="nic">National ID Card Number</label>
                            <div class="controls">
                                <input class="form-control places-search" id="nic" type="text"
                                    value="{{ $user->nic }}" name="nic" autofocus placeholder="malingo, buea">
                                @if ($errors->has('nic'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('nic') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('dob') ? ' has-error' : '' }}">
                            <label for="dob">Date of Birth</label>
                            <div class="controls">
                                <input class="form-control places-search" id="dob" type="text"
                                    value="{{ $user->dob }}" name="dob" autofocus placeholder="03/10/2019">
                                @if ($errors->has('dob'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('dob') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('type') ? ' has-error' : '' }}">
                            <label for="type">Use Gokamz as...</label>
                            <div class="controls">
                                <select class="form-control" id="type" type="text" value="{{ old('type') }}"
                                    name="type" autofocus placeholder="to look for rides or to offer rides">
                                    <option value="driver" <?= $user->type == 'driver' ? 'selected' : '' ?>>driver</option>
                                    <option value="passenger" <?= $user->type == 'passenger' ? 'selected' : '' ?>>passenger</option>
                                   
                                </select>
                                @if ($errors->has('type'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('type') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('type') ? ' has-error' : '' }}">
                            <label for="type">Use Gokamz mainly as...</label>
                            <div class="controls">
                                <select class="form-control" id="type" type="text"
                                    value="{{ old('type') }}" name="gender" required autofocus
                                    placeholder="to look for rides or to offer rides">

                                    @foreach ($user::getUserGenders() as $gender)
                                        <option @if ($gender == $user->gender) selected="selected" @endif
                                            value="{{ $gender }}">{{ ucfirst($gender) }}</option>
                                    @endforeach
                                </select>
                                @if ($errors->has('type'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('type') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('language') ? ' has-error' : '' }}">
                            <label for="language">Prefered Language</label>
                            <div class="controls">
                                <select class="form-control" id="language" type="text"
                                    value="{{ old('language') }}" name="language" required autofocus
                                    placeholder="your first language">
                                    @foreach (\App\Models\User::getUserLanguages() as $language)
                                        <option @if ($language == $user->language) selected="selected" @endif
                                            value="{{ $language }}">{{ ucfirst($language) }}</option>
                                    @endforeach
                                </select>
                                @if ($errors->has('language'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('language') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group pull-right">
                            <div class="controls">
                                <input type="submit" name="action" value="Update" class="btn btn-success sign-in">
                            </div>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection

@section('foot')

<script src="/assets/plugins/datetimepicker/jquery.datetimepicker.full.js"></script>
<script type="text/javascript">
    $(function() {

        $('#dob').datetimepicker({
            format: 'd/m/Y',
            timepicker: false,
            format: 'd/m/Y',
            formatDate: 'Y/m/d'
        });

    });
</script>

@endsection
