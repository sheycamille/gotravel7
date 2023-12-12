@extends('layouts.app')

@section('title', 'Details of Journey')

@section('active')

@section('head')

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

                    <div class="messages"></div>

                    <h1>Journey from {{ $ride->departure }} to {{ $ride->destination }}</h1>

                    <hr class="hidden-xs">
                    <div class="row pay-wrapper">
                        <form accept-charset="UTF-8" id="form-data">
                            {{ csrf_field() }}
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="card">
                                        <!--<div class="card-header bg-primary text-white">Header 1</div>-->
                                        <ul class="list-group list-group-flush">
                                            <p>Day/time: <b>{{ $ride->getFullFormatedDate() }}</b></p>
                                            <p>Pickup Location: <b>{{ $ride->pickup_location }}</b></p>
                                            <p>Seats Available: <b>{{ $ride->num_of_seats_left }}/{{ $ride->num_of_seats }}
                                                    Left</b></p>
                                            <p>Cost Per Seat: <b>{{ $ride->cost }}</b></p>
                                            <img src="{{ URL::to('assets/images') }}/car-icon-png-25.png"
                                                class=" image-fluid ride-vehicle" height="150px">
                                            <!--<li class="text-bg-success p-2 col">List Item 3</li>-->
                                        </ul>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="card mx-auto  mt-3 p-0">

                                        <div class="pay-card-body">
                                            <p class="text-muted">Select seats</p>
                                            <div class="numbr mb-3">
                                                <select class="form-control seats" name="num_of_seats" required>
                                                    @if ($ride->num_of_seats_left == null)
                                                        @for ($i = 1; $i <= $ride->num_of_seats; $i++)
                                                            <option value="{{ $i }}">{{ $i }}
                                                            </option>
                                                        @endfor
                                                    @else
                                                        @for ($i = 1; $i <= $ride->num_of_seats_left; $i++)
                                                            <option value="{{ $i }}">{{ $i }}
                                                            </option>
                                                        @endfor

                                                    @endif
                                                </select>
                                            </div>
                                            <p class="text-muted">Select payment method</p>
                                            <label class="radio-inline">
                                                <input type="radio" name="pay_method" value="1" checked><img
                                                    src="{{ URL::to('assets/images') }}/momo-logo.webp" class="momo">
                                            </label>
                                            <label class="radio-inline om">
                                                <input type="radio" name="pay_method" value="2"><img
                                                    src="{{ URL::to('assets/images') }}/orange-money-logo-8F2AED308D-seeklogo.com.png"
                                                    class="orange-moni">
                                            </label>
                                            <p class="text-muted">Phone number</p>
                                            <div class="numbr mb-3">
                                                <input type="text" class="form-control" name="momo_number" 
                                                    placeholder="enter transaction number ">
                                            </div>
                                        </div>
                                        @if (auth()->check())
                                            <div class="footer pay-footer text-center p-0">
                                                <div class="col">
                                                    <button type="submit" class="pay-btn" id="proceed">Proceed To
                                                        Payment</button>
                                                </div>
                                            </div>
                                        @else
                                            <h6>You need to <a href="{{ route('login') }}"><b>sign in</b></a> or <a
                                                    href="{{ route('register') }}"><b>create an account</b></a> to book
                                                this ride.</h6>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="card text-center">

                                        <img src="{{ URL::to('assets/images') }}/user_default2.png" class="pilot-img">
                                        {{-- <@if (Auth()->User()->avatar === null)
                                    <img src="{{ URL::to('assets/images') }}/user_default2.png" class="pilot-img">
                                    @else
                                    '' 
                                    @endif --}}
                                        <p>Chauffuer: <b>{{ $ride->driver->username }}</b></p>
                                        <p>Tel: <b>{{ $ride->driver->phone_number }}</b></p>
                                        <p>email: <b>{{ $ride->driver->email }}</b></p>
                                    </div>
                                </div>
                        </form>
                        {{-- <div class="row">
                            <div class="col">
                                <div class="row">
                                    <div class="col-md-6">

                                        <p>Day/time: <b>{{ $ride->getFullFormatedDate() }}</b></p>

                                        <p>Pickup Location: <b>{{ $ride->pickup_location }}</b></p>

                                        {{-- <div class="form-group">
                                            <label for="noOfSeats">No of Seats Available</label>
                                            <div class="controls">
                                                <span title="" data-toggle="tooltip" data-placement="top"
                                                    data-original-title="{{ $ride->noOfSeats }} seats were available">
                                                    @foreach (array_fill(0, $ride->passengers()->count(), 1) as $index)
                                                        <img alt="{{ $ride->num_of_seats }} seats taken" class="icon-seat"
                                                            src="{{ URL::to('assets/images') }}/red-icon.svg">
                                                    @endforeach
                                                    @foreach (array_fill(0, $ride->spacesLeft(), 1) as $index)
                                                        <img alt="{{ $ride->num_of_seats }} seats left" class="icon-seat"
                                                            src="{{ URL::to('assets/images') }}/green-icon.svg">
                                                    @endforeach

                                                </span>
                                                {{ $ride->spacesLeft() }} left of {{ $ride->num_of_seats }}
                                            </div>
                                        </div> --
                                    </div>

                                    <div class="col-md-6">
                                        <p>Seats Available: <b>{{ $ride->num_of_seats_left }}/{{ $ride->num_of_seats }}
                                                Left</b></p>

                                        <p>Cost Per Seat: <b>{{ $ride->cost }}</b></p>



                                        {{-- <div class="form-group">
                                            <div class="controls">
                                                @if (Auth::check())
                                                    @if (Auth::user()->id == $ride->driver_id)
                                                        <a href="{{ route('edit-ride', $ride->id) }}"
                                                            class="btn btn-success ">Update</a>
                                                    @else
                                                        @if ($ride->isAPassenger())
                                                            <a href="{{ route('cancel_booking') }}"
                                                                class="btn btn-danger ">Cancel
                                                                Booking</a>
                                                        @else
                                                            <!--<a  class="btn btn-success sign-in" onclick="paySelect()">Join</a>-->
                                                            <a href="{{ route('join-ride', $ride->id) }}"
                                                                class="btn btn-success ">Book</a>
                                                        @endif
                                                    @endif
                                                @else
                                                    <a onclick="loginModal()" class="btn btn-success ">Book</a>
                                                @endif
        
                                            </div>
                                        </div> --
                                    </div>
                                </div>

                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <img src="{{ URL::to('assets/images') }}/car-icon-png-25.png" class="ride-vehicle"
                                        height="200px">

                                </div>

                                <div class="col-md-6">
                                    @if (auth()->check())
                                        @if ($ride->num_of_seats_left == 0)
                                            <h5>Sorry, this ride is full, try another one.</h5>
                                        @else
                                            <form accept-charset="UTF-8" id="form-data">
                                                {{ csrf_field() }}
                                                <p class="pay-text">Select seats to book</p>
                                                <div name="paymentContainer" class="paymentOptions">
                                                    @if ($ride->num_of_seats_left == null)

                                                        @for ($i = 1; $i <= $ride->num_of_seats; $i++)
                                                            @if ($i == 1)
                                                                <div class="floatBlock">
                                                                    <label for=""> <input id="" checked
                                                                            name="num_of_seats" type="radio"
                                                                            value="{{ $i }}" />{{ $i }}</label>
                                                                </div>
                                                            @else
                                                                <div class="floatBlock">
                                                                    <label for=""> <input id=""
                                                                            name="num_of_seats" type="radio"
                                                                            value="{{ $i }}" />{{ $i }}</label>
                                                                </div>
                                                            @endif
                                                        @endfor
                                                    @else
                                                        @for ($i = 1; $i <= $ride->num_of_seats_left; $i++)
                                                            @if ($i == 1)
                                                                <div class="floatBlock">
                                                                    <label for=""> <input checked
                                                                            name="num_of_seats" id="momo_num"
                                                                            type="radio"
                                                                            value="{{ $i }}" />{{ $i }}</label>
                                                                </div>
                                                            @else
                                                                <div class="floatBlock">
                                                                    <label for="" id="test"> <input
                                                                            name="num_of_seats" id="momo_num"
                                                                            type="radio"
                                                                            value="{{ $i }}" />{{ $i }}</label>
                                                                </div>
                                                            @endif
                                                        @endfor
                                                    @endif
                                                </div>

                                                <div  class="p-3 mb-2 bg-warning text-white">
                                                    <div class="px-6">
                                                        <div class=" d-flex justify-content-between mb-0">
                                                            <p class="text-muted mb-0 pay-text">Payment Procedure</p>
                                                            <p class="mb-0 text-bold">{{ $ride->cost + $ride->charges }} XAF
                                                            </p>
                                                        </div>
                                                        <div class="d-flex flex-column-reverse">
                                                            <div class="p-2 text-start"><img
                                                                    src="{{ URL::to('assets/images') }}/momo-logo.webp"
                                                                    class="momo"></div>
                                                            <div class="form-group row">
    
                                                                <div class="col-sm-8">
                                                                    <input type="text" class="form-control" 
                                                                        name="momo_number" placeholder="enter momo number ">
                                                                </div>
    
                                                            </div>
    
                                                        </div>
                                                    </div>
    
                                                    <button type="submit" class="btn btn-primary pay-button"
                                                        id="proceed">Proceed To
                                                        Payment</button>
                                                    {{-- <a href="{{ route('trans-status', $ride->id) }}"> Confirm Payment</a>
                                                </div>

                                            </form>
                                        @endif
                                    @else
                                        <h6>You need to <a href="{{ route('login') }}"><b>sign in</b></a> or <a
                                                href="{{ route('register') }}"><b>create an account</b></a> to book
                                            this ride.</h6>
                                    @endif
                                </div>
                            </div>

                        </div> --}}
                    </div>


                </div>
            </div>
        </div>
    </div>


    
@endsection


@section('foot')

    <script type="text/javascript">
        //$("#proceed").click(function() {
        // $("#spinner").show();
        //$("#proceed").hide();
        //});

        $("#form-data").on('submit', function(e) {
            e.preventDefault();

            var data = $('#form-data').serialize();


            $.ajax({
                type: 'post',
                url: "{{ route('request-to-pay', $ride->id) }}",
                data: data,

                beforeSend: function() {

                    $("#proceed").prop('disabled', true).html('...Processing');
                    //$("#spinner").show(); 
                },
                success: function(response) {
                    //alert(response.success);
                    //$('#myModal').show();
                    var messages = $('.messages');

                    var successHtml = '<div class="alert alert-info">' +
                        '<button type="button" class="close" data-dismiss="alert">&times;</button>' +
                        '<strong><i class="glyphicon glyphicon-ok-sign push-5-r"></</strong> ' +
                        response.message +
                        '<a class="verify-pay" href="{{ route('trans-status', $ride->id) }}">Payment Verified</a>' +
                        '</div>';

                    $(messages).html(successHtml);
                },

                error: function(response, xhr) {
                    //alert('Something went wrong, please try again later.');

                    var status = response.status;
                    //console.log(status);

                    var messages = $('.messages');

                    var erroMessage = '<div class="alert alert-danger">' +
                        '<button type="button" class="close" data-dismiss="alert">&times;</button>' +
                        '<strong><i class="glyphicon glyphicon-ok-sign push-5-r"></</strong> ' +'Something went wrong, try again!' +
                        '</div>';

                    $(messages).html(erroMessage);

                    console.log(status);
                },
                complete: function(response) {
                    $("#proceed").prop('disabled', false).html('Proceed to payment');
                    //$("#spinner").hide();
                }
            });
        });
        //var seat = document.getElementById("test").name;
        //console.log(seat)
    </script>


@endsection
