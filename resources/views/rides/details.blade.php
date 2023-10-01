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
                    <div class="col-md-8 pay-wrapper" style="border-right: 1px solid #eeeeee;">
                        <div class="row">
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
                                        </div> --}}
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
                                        </div> --}}
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
                                                <a href="{{ route('trans-status', $ride->id) }}"> Confirm Payment</a>


                                            </form>
                                        @endif
                                    @else
                                        <h6>You need to <a href="{{ route('login') }}"><b>sign in</b></a> or <a
                                                href="{{ route('register') }}"><b>create an account</b></a> to book
                                            this ride.</h6>
                                    @endif
                                </div>
                            </div>

                        </div>
                    </div>

                    <div class="col-md-4">
                        @if (Auth()->User()->avatar)
                            ''
                        @else
                            <img src="{{ URL::to('assets/images') }}/user_default2.png" class="pilot-img">
                        @endif
                        <p>Chauffuer: <b>{{ $ride->driver->username }}</b></p>
                        <p>Tel: <b>{{ $ride->driver->phone_number }}</b></p>
                        <p>email: <b>{{ $ride->driver->email }}</b></p>

                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- Modal -->
    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Payment Confirmation</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>You're about to make a payment of {{ $ride->cost }} XAF to Travel Z, please dial *126# on your
                        mobile phone to confirm this payment. Once done click on 'Confirm Payment'</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" href="{{ route('join', $ride->id) }}">Confirm
                        Payment</button>
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
            var seats = $('#momo_num').val();

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

                    var successHtml = '<div class="alert alert-success">' +
                        '<button type="button" class="close" data-dismiss="alert">&times;</button>' +
                        '<strong><i class="glyphicon glyphicon-ok-sign push-5-r"></</strong> ' +
                        response.message +
                        '<a href="{{ route('trans-status', $ride->id) }}">HERE</a>' +
                        '</div>';

                    $(messages).html(successHtml);
                },

                error: function(response) {
                    alert('Something went wrong, please try again later.');
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
