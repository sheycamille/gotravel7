@extends('layouts.app')

@section('title', 'Dashboard')


@section('content')

    @include('parts.small_header_extend')

    <style type="text/css">
        span,
        label {
            font-size: 18px;
        }

        .badge {
            background: #f7972a;
        }

        .col-sm-10 {
            padding-bottom: 20px;
        }

        .inner_column {
            float: left;
            width: 50%;
            padding: 10px;
        }

        /* Clear floats after the columns */
        .inner_row:after {
            content: "";
            display: table;
            clear: both;
        }
    </style>

    <div class="main ">
        <div class="container">
            <div class="row">

                @include('parts.account_sidebar')

                <div class="col-sm-10">
                    @if ($message = Session::get('success'))
                        <div class="alert alert-success alert-block">
                            <button type="button" class="close" data-dismiss="alert">×</button>
                            <strong>{{ $message }}</strong>
                        </div>
                    @endif


                    @if ($message = Session::get('error'))
                        <div class="alert alert-error alert-block">
                            <button type="button" class="close" data-dismiss="alert">×</button>
                            <strong>{{ $message }}</strong>
                        </div>
                    @endif

                    <h1>Welcome {{ $user->username }}</h1>

                    <hr class="hidden-xs">

                    <div class="row">

                        <div class="col-sm-12">
                            <div class="white-box">
                                <div class="d-md-flex mb-3">
                                    <h3 class="box-title mb-3">Pending Journey(s)</h3>
                                </div>
                                <div class="table-responsive">
                                    <table class="table no-wrap">
                                        <thead>
                                            <tr>
                                                <th class="border-top-0">Journey</th>
                                                <th class="border-top-0">Seats Booked</th>
                                                <th class="border-top-0">Cost</th>
                                                <th class="border-top-0">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse($pendx_jounrneys as $pendx)
                                                <tr>
                                                    <td>Journey from {{ $pendx->departure }} to {{ $pendx->destination }}
                                                    </td>
                                                    <td>{{ $pendx->num_of_seats }}</td>
                                                    <td class="txt-oflo">{{ $pendx->cost }}</td>
                                                    <td>
                                                        <a class=" btn rounded btn-danger m-1 btn-sm" data-toggle="modal"
                                                            data-target="#deleteride-{{ $pendx->id }}">Cancel
                                                            Booking</a>
                                                    </td>

                                                </tr>

                                                <!--Delete ride Modal -->
                                                <div class="modal fade" id="deleteride-{{ $pendx->id }}" tabindex="-1"
                                                    aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="exampleModalLabel">Cancel
                                                                    Booking
                                                                </h5>
                                                                <button type="button" class="btn-close"
                                                                    data-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <p>Are you sure you want to cancel this booking?</p>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <form id="submit-form"
                                                                    action="{{ route('cancel-booking', $pendx->id) }}"
                                                                    method="GET" class="hidden">
                                                                    @csrf
                                                                    @method('GET')
                                                                </form>
                                                                <a href="{{ route('cancel-booking', $pendx->id) }}"
                                                                    type="button" class="btn btn-danger "
                                                                    onclick="event.preventDefault(); document.getElementById('submit-form').submit();">Yes,
                                                                    i'm sure</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @empty
                                                <tr>
                                                    <td colspan="4">
                                                        <h5>You haven't booked any rides yet</h5>
                                                    </td>
                                                </tr>
                                            @endforelse

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="white-box">
                                <div class="d-md-flex mb-3">
                                    <h3 class="box-title mb-3">Recent Ride</h3>
                                </div>
                                <div class="table-responsive">
                                    <table class="table no-wrap">
                                        <thead>
                                            <tr>
                                                <th class="border-top-0">Ride</th>
                                                <th class="border-top-0">Price</th>
                                                <th class="border-top-0">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($rides as $ride)
                                                <tr>

                                                    <td class="txt-oflo">From {{ $ride->departure }} to
                                                        {{ $ride->destination }}</td>
                                                    <td>{{ $ride->cost }}</td>
                                                    <td>
                                                        <a href="" class=" btn rounded btn-primary m-1 btn-sm"
                                                            data-toggle="modal"
                                                            data-target="#updateride-{{ $ride->id }}">Edit Ride</a>
                                                    </td>
                                                </tr>
                                                <!-- Edit ride Modal -->

                                                <div id="updateride-{{ $ride->id }}" class="modal fade" role="dialog">
                                                    <div class="modal-dialog">
                                                        <!-- Modal content-->
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h4 class="modal-title ">Update Ride</strong></h4>
                                                                <button type="button" class="btn-close"
                                                                    data-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">

                                                                <form class="form simple" id="new_user"
                                                                    action="{{ route('update-ride', $ride->id) }}"
                                                                    accept-charset="UTF-8" method="post">
                                                                    {{ csrf_field() }}
                                                                    <div class="row">
                                                                        <div class="col-md-6">
                                                                            <div
                                                                                class="form-group{{ $errors->has('departure') ? ' has-error' : '' }}">
                                                                                <label for="departure">Departure
                                                                                    Town</label>
                                                                                <div class="controls">
                                                                                    <input
                                                                                        class="form-control places-search"
                                                                                        id="departure" type="text"
                                                                                        value="{{ $ride->departure }}"
                                                                                        name="departure" required autofocus
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
                                                                            <div
                                                                                class="form-group{{ $errors->has('destination') ? ' has-error' : '' }}">
                                                                                <label for="destination">Arrival
                                                                                    Town</label>
                                                                                <div class="controls">
                                                                                    <input
                                                                                        class="form-control places-search"
                                                                                        id="destination" type="text"
                                                                                        value="{{ $ride->destination }}"
                                                                                        name="destination" required
                                                                                        autofocus placeholder="to...">
                                                                                    @if ($errors->has('departure'))
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
                                                                            <div
                                                                                class="form-group{{ $errors->has('start_day') ? ' has-error' : '' }}">
                                                                                <label for="start_day">Start Day</label>
                                                                                <div class="controls">
                                                                                    <input class="form-control"
                                                                                        id="datetime1" type="text"
                                                                                        value="{{ $ride->start_day }}"
                                                                                        name="start_day" required autofocus
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
                                                                            <label for="start_time">Start Time</label>
                                                                            <input class="form-control" id="datetime2"
                                                                                type="text"
                                                                                value="{{ $ride->start_time }}"
                                                                                name="start_time" required autofocus
                                                                                placeholder="time...">
                                                                        </div>
                                                                    </div>

                                                                    <div class="row">
                                                                        <div class="col-md-4">
                                                                            <div
                                                                                class="form-group{{ $errors->has('type') ? ' has-error' : '' }}">
                                                                                <label for="type">For...</label>
                                                                                <div class="controls">
                                                                                    <select class="form-control"
                                                                                        id="type" type="text"
                                                                                        value="{{ old('type') }}"
                                                                                        name="type" required autofocus
                                                                                        placeholder="transport persons or goods">
                                                                                        <option
                                                                                            @if (\Session::get('transport') == 'persons') selected="selected" @endif
                                                                                            value="persons">Persons
                                                                                        </option>
                                                                                        <option
                                                                                            @if (\Session::get('transport') == 'goods') selected="selected" @endif
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
                                                                                <label for="noOfSeats">Seats
                                                                                    Available</label>
                                                                                <div class="controls">
                                                                                    <input class="form-control"
                                                                                        id="noOfSeats" type="number"
                                                                                        value="{{ old('noOfSeats') ? old('noOfSeats') : 1 }}"
                                                                                        name="noOfSeats" autofocus>
                                                                                    @if ($errors->has('noOfSeats'))
                                                                                        <span class="help-block">
                                                                                            <strong>{{ $errors->first('noOfSeats') }}</strong>
                                                                                        </span>
                                                                                    @endif
                                                                                </div>
                                                                            </div>
                                                                        </div>

                                                                        <div class="col-md-4">
                                                                            <div
                                                                                class="form-group{{ $errors->has('cost') ? ' has-error' : '' }}">
                                                                                <label for="cost">Cost</label>
                                                                                <div class="controls">
                                                                                    <input class="form-control"
                                                                                        id="cost" type="text"
                                                                                        value="{{ $ride->cost }}"
                                                                                        name="cost" required autofocus
                                                                                        placeholder="give a lower quote than the normal to attract clients">
                                                                                    @if ($errors->has('cost'))
                                                                                        <span class="help-block">
                                                                                            <strong>{{ $errors->first('cost') }}</strong>
                                                                                        </span>
                                                                                    @endif
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                    <div class="row">
                                                                        <div class="col-md-6">
                                                                            <div
                                                                                class="form-group{{ $errors->has('pickup_location') ? ' has-error' : '' }}">
                                                                                <label for="pickup_location">Pickup
                                                                                    Location</label>
                                                                                <div class="controls">
                                                                                    <input
                                                                                        class="form-control places-search"
                                                                                        id="pickup_location"
                                                                                        type="text"
                                                                                        value="{{ $ride->pickup_location }}"
                                                                                        name="pickup_location" required
                                                                                        autofocus
                                                                                        placeholder="agreed meeting position">
                                                                                    @if ($errors->has('pickup_location'))
                                                                                        <span class="help-block">
                                                                                            <strong>{{ $errors->first('pickup_location') }}</strong>
                                                                                        </span>
                                                                                    @endif
                                                                                </div>
                                                                            </div>
                                                                        </div>

                                                                        <div class="col-md-6">
                                                                            <div
                                                                                class="form-group{{ $errors->has('vehicle') ? ' has-error' : '' }}">
                                                                                <label for="vehicle">Vehicle</label>
                                                                                <div class="controls">
                                                                                    <input class="form-control"
                                                                                        id="vehicle" type="text"
                                                                                        value="{{ $ride->vehicle }}"
                                                                                        name="vehicle" required autofocus
                                                                                        placeholder="describe the exciting features of your vehicle so the client is attract to your offer.">
                                                                                    @if ($errors->has('vehicle'))
                                                                                        <span class="help-block">
                                                                                            <strong>{{ $errors->first('vehicle') }}</strong>
                                                                                        </span>
                                                                                    @endif
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                    <div
                                                                        class="form-group{{ $errors->has('comments') ? ' has-error' : '' }}">
                                                                        <label for="comments">Comments</label>
                                                                        <div class="controls">
                                                                            <textarea class="form-control" id="comments" type="text" value="" name="comments" autofocus
                                                                                placeholder="Add additional details so the potential passenger is interested to travel with you">{{ $ride->comments }}</textarea>
                                                                            @if ($errors->has('comments'))
                                                                                <span class="help-block">
                                                                                    <strong>{{ $errors->first('comments') }}</strong>
                                                                                </span>
                                                                            @endif
                                                                        </div>
                                                                    </div>

                                                                    <div class="form-group">
                                                                        <div class="controls">
                                                                            <input type="submit" name="action"
                                                                                value="Update"
                                                                                class="btn btn-success sign-in">
                                                                        </div>
                                                                    </div>
                                                                </form>

                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="white-box">
                                <div class="d-md-flex mb-3">
                                    <h3 class="box-title mb-3">Recent Trips</h3>
                                </div>
                                <div class="table-responsive">
                                    <table class="table no-wrap">
                                        <thead>
                                            <tr>
                                                <th class="border-top-0">Journey</th>
                                                <th class="border-top-0">Date</th>
                                                <th class="border-top-0">Cost</th>
                                                <th class="border-top-0">Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse ($recent_trips as $recent)
                                                <tr>
                                                    <td class="txt-oflo">From {{ $recent->departure }} to
                                                        {{ $recent->destination }}</td>
                                                    <td>{{ $recent->created_at }}</td>
                                                    <td>{{ $recent->cost }}</td>
                                                    <td><span class="badge bg-danger rounded">{{ $recent->status }}</span>
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="4">
                                                        <h5>You haven't taken any trips yet</h5>
                                                    </td>
                                                </tr>
                                            @endforelse

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">

                    </div>


                    {{-- <div class="inner_row">
                        <div class="inner_column">
                            <div class="col-md-3">
                                @if (Auth::user()->avatar == null)
                                    <img src="/assets/images/default-avatar.png" width="100%" height="100%"
                                        style="border-radius:15px;">
                                @else
                                    <img src="{{ '/uploads/avatars/' . Auth::user()->avatar }}" width="300px"
                                        height="300px" style="border-radius:15px;">
                                @endif
                            </div>
                        </div>

                    </div> --}}

                </div>
            </div>
        </div>


    @endsection

    @section('foot')

        <script type="text/javascript">
            function changePassword() {
                console.log('changing password');
                $("#reset-password-modal").modal();
            }
        </script>

    @endsection
