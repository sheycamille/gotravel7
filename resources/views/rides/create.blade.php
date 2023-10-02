@extends('layouts.app')

@section('title', 'Post new ride')

@section($menu, 'active')

@section('head')

    <link rel="stylesheet" href="/assets/plugins/datetimepicker/jquery.datetimepicker.min.css">

@endsection

@section('content')

    @include('parts.small_header_extend')
    <div class="main ">
        <div class="container">
            <div class="row">

                @include('parts.options_sidebar')

                <div class="col-sm-10">
                    @if ($message = Session::get('success'))
                        <div class="alert alert-success alert-block">
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

                    <div class="col-md-6">
                        @if (\Session::get('transport') == 'goods')
                            <h1> Post a new pickup </h1>
                            <span class="pull-right">Maybe, you want to list your vehicle for persons transportation, <a
                                    href="{{ route('switch-transport-type', 'persons') }}">click here</a></span>
                        @else
                            <h1> Post a new journey/ride </h1>
                            <span class="pull-right">Maybe, you want to list your vehicle for goods transportation, <a
                                    href="{{ route('switch-transport-type', 'goods') }}" style="color: #4cc417;">click
                                    here</a></span>
                        @endif
                        <hr class="hidden-xs" style="display:block">
                    </div>

                    <div class="clearfix"></div>
                    <br>

                    <div class="col-md-8">
                        <form class="form simple" id="new_user" action="{{ route('store-ride') }}" accept-charset="UTF-8"
                            method="post">
                            {{ csrf_field() }}
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group{{ $errors->has('departure') ? ' has-error' : '' }}">
                                        <label for="departure">Departure Town</label>
                                        <div class="controls">
                                            <input class="form-control places-search" id="departure" type="text"
                                                value="{{ old('departure') }}" name="departure" required autofocus
                                                placeholder="from...">
                                            @if ($errors->has('departure'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('departure') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group{{ $errors->has('destination') ? ' has-error' : '' }}">
                                        <label for="destination">Arrival Town</label>
                                        <div class="controls">
                                            <input class="form-control places-search" id="destination" type="text"
                                                value="{{ old('destination') }}" name="destination" required autofocus
                                                placeholder="to...">
                                            @if ($errors->has('destination'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('destination') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group{{ $errors->has('start_day') ? ' has-error' : '' }}">
                                        <label for="start_day">Day</label>
                                        <div class="controls">
                                            <input class="form-control" id="datetime1" type="text"
                                                value="{{ old('start_day') }}" name="start_day" required autofocus
                                                placeholder="day...">

                                            @if ($errors->has('start_day'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('start_day') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group{{ $errors->has('start_day') ? ' has-error' : '' }}">
                                        <label for="start_day">Time</label>
                                        <div class="controls">
                                            <input class="form-control" id="datetime2" type="text"
                                                value="{{ old('start_time') }}" name="start_time" required autofocus
                                                placeholder="time...">
                                            @if ($errors->has('start_day'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('start_day') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group{{ $errors->has('type') ? ' has-error' : '' }}">
                                        <label for="type">For...</label>
                                        <div class="controls">
                                            <select class="form-control" id="type" type="text"
                                                value="{{ old('type') }}" name="type" required autofocus
                                                placeholder="transport persons or goods">
                                                <option @if (\Session::get('transport') == 'persons') selected="selected" @endif
                                                    value="persons">Persons</option>
                                                <option @if (\Session::get('transport') == 'goods') selected="selected" @endif
                                                    value="goods">Goods</option>
                                            </select>
                                            @if ($errors->has('type'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('type') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group{{ $errors->has('noOfSeats') ? ' has-error' : '' }}"
                                        id="noOfSeatsContainer">
                                        <label for="noOfSeats">No of Seats Available</label>
                                        <div class="controls">
                                            <input class="form-control" id="noOfSeats" type="number"
                                                value="{{ old('noOfSeats') ? old('noOfSeats') : 1 }}" name="noOfSeats"
                                                autofocus>
                                            @if ($errors->has('noOfSeats'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('noOfSeats') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group{{ $errors->has('vehicle') ? ' has-error' : '' }}">
                                        <label for="vehicle">Vehicle Type</label>
                                        <div class="controls">
                                            <select name="type" id="type" class="form-control"
                                                placeholder="Transport Persons or Goods">
                                                @foreach ($cartype as $car)
                                                    <option value="{{ $car }}">{{ $car }}</option>
                                                @endforeach
                                            </select>

                                            @if ($errors->has('vehicle'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('vehicle') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group{{ $errors->has('cost') ? ' has-error' : '' }}">
                                        <label for="cost">Cost</label>
                                        <div class="controls">
                                            <input class="form-control" id="cost" type="text"
                                                value="{{ old('cost') }}" name="cost" required="required" autofocus
                                                placeholder="we advice you give a lower quote than the normal to attract clients">
                                            @if ($errors->has('cost'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('cost') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group{{ $errors->has('pickup_location') ? ' has-error' : '' }}">
                                        <label for="pickup_location">Pickup Location</label>
                                        <div class="controls">
                                            <input class="form-control places-search" id="pickup_location" type="text"
                                                value="{{ old('pickup_location') }}" name="pickup_location" required
                                                autofocus placeholder="agreed meeting position">
                                            @if ($errors->has('pickup_location'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('pickup_location') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('comments') ? ' has-error' : '' }}">
                                <label for="comments">Comments</label>
                                <div class="controls">
                                    <textarea class="form-control" id="comments" type="text" value="" name="comments" autofocus
                                        placeholder="Add additional details so the potential passenger is interested to travel with you">{{ old('comments') }}</textarea>
                                    @if ($errors->has('comments'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('comments') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="controls">
                                    <input type="submit" name="action" value="Create" class="btn btn-success sign-in">
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

            $('#datetime2').datetimepicker({
                datepicker: false,
                format: 'H:i',
                step: 01
            });

            $('#datetime1').datetimepicker({
                lang: 'en',
                timepicker: false,
                format: 'd-m-Y',
                formatDate: 'Y-m-d'
            });

            $("#type").click(function() {
                var that = this;

                if ($(this).val() === 'goods') {
                    $("#noOfSeatsContainer").addClass('hide');
                } else {
                    $("#noOfSeatsContainer").removeClass('hide');
                }
            });

            if ($("#type").val() == 'goods') {
                $("#noOfSeatsContainer").addClass('hide');
            } else {
                $("#noOfSeatsContainer").removeClass('hide');
            }

        });
    </script>

    <script type="text/javascript">
        function activatePlacesSearch() {
            var placesInput = document.getElementsByClassName('places-search');
            var autocomplete1 = new google.maps.places.Autocomplete(placesInput[0]);
            var autocomplete2 = new google.maps.places.Autocomplete(placesInput[1]);
            var autocomplete3 = new google.maps.places.Autocomplete(placesInput[2]);
        }
    </script>
    <script
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBabVxQOzXEbwg3GL2FuqW5baV_1xu9fJk&libraries=places&callback=activatePlacesSearch"
        async defer></script>

@endsection
