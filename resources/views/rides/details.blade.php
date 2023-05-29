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

                    <h1>Journey from {{ $ride->departure }} to {{ $ride->destination }}</h1>

                    <hr class="hidden-xs">
                    <div class="col-md-8" style="border-right: 1px solid #eeeeee;">
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
                                        <p>Seats Available: <b>{{ $ride->spacesLeft() }}/{{ $ride->num_of_seats }}
                                                Left</b></p>

                                        <p>Cost Per Seat: <b>{{ $ride->cost }}</b></p>

                                        <form action="">
                                            <h5>Select seats to book</h5>
                                            <div name="paymentContainer" class="paymentOptions">
                                                @for ($i = 1; $i <= $ride->spacesLeft(); $i++)
                                                    @if ($i == 1)
                                                        <div class="floatBlock">
                                                            <label for=""> <input id="" checked
                                                                    name="seat" type="radio"
                                                                    value="{{ $i }}" />{{ $i }}</label>
                                                        </div>
                                                    @else
                                                        <div class="floatBlock">
                                                            <label for=""> <input id="" name="seat"
                                                                    type="radio"
                                                                    value="{{ $i }}" />{{ $i }}</label>
                                                        </div>
                                                    @endif
                                                @endfor
                                            </div>

                                            <button class="btn btn-success" type="submit">Book</button>

                                        </form>

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

                            <div class="col">
                                <img src="{{ URL::to('assets/images') }}/1498105293-69-droppin-technologies-ltd.jpg"
                                    class="ride-vehicle" height="200px">

                            </div>

                        </div>
                    </div>

                    <div class="col-md-4">
                        <img src="{{ URL::to('assets/images') }}/bg1.jpeg" class="pilot-img">
                        <p>Chauffuer: <b>{{ $ride->driver->username }}</b></p>
                        <p>Tel: <b>{{ $ride->driver->phone_number }}</b></p>
                        <p>email: <b>{{ $ride->driver->email }}</b></p>

                    </div>
                </div>
            </div>
        </div>
    </div>


    <div id="loginModal" tabindex="-1" role="dialog" aria-spanledby="modal-login-span" aria-hidden="true"
        class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content col-md-10 col-md-offset-1">
                <div class="modal-header">
                    <button type="button" data-dismiss="modal" aria-hidden="true" class="close">&times;</button>
                    <h4 id="modal-login-span" class="modal-title"><a href="#"><i class="fa fa-lock"></i></a> Payment
                        Procedure</h4>
                </div>
                <div class="modal-body" id="reset-password_body">
                    <div class="form" style="height: inherit;">

                        <!-- <form class="form-horizontal row" action="{{ route('reset_password') }}" method="post">
                                                    {{ csrf_field() }}
                                                    <input type="hidden" id='user_id' name="user_id" value=""/>

                                                    <div class="form-group">
                                                      <span for="newpass" class="col-md-12 hide control-span">@lang('auth.old_password')</span>

                                                      <div class="col-md-12">
                                                        <input id="oldpass" type="password" placeholder="@lang('auth.old_password')" class="form-control input-lg c-square" name="oldpass" required>
                                                      </div>
                                                    </div>

                                                    <div class="form-group">
                                                      <span for="newpass" class="col-md-12 hide control-span">@lang('auth.new_password')</span>

                                                      <div class="col-md-12">
                                                        <input id="newpass" type="password" placeholder="@lang('auth.new_password')" class="form-control input-lg c-square" name="newpass" required>
                                                      </div>
                                                    </div>

                                                    <div class="form-group">
                                                      <span for="cnewpass" class="col-md-12 hide control-span">@lang('auth.confirm_password')</span>

                                                      <div class="col-md-12">
                                                        <input id="cnewpass" placeholder="@lang('auth.signup.confirm_password_placeholder')" type="password" class="form-control input-lg c-square" name="cnewpass" required>
                                                      </div>
                                                    </div>

                                                    <div class="form-group col-md-12">
                                                      <input type="submit" class="btn btn-lg btn-primary pull-right" value="@lang('auth.reset_legend')"/>
                                                    </div>

                                                  </form> -->
                    </div>
                    <!-- Send the payment of this ride({{ $ride->cost + $ride->charges }}XAF) through <br>
                                                    <label class="text-center"> MTN Mobile Money number:</label> <label class="text-center"
                                                        style='font-weight:bold;'>653 762 417</label><br>
                                                    OR <br>
                                                    <label class="text-center"> Orange Money:</label> <label class="text-center"
                                                        style='font-weight:bold;'> 691 828 518</label><br>
                                                    OR <br>
                                                    <label class="text-center"> Express Union Money:</label> <label class="text-center"
                                                        style='font-weight:bold;'>691 828 518</label><br>-->
                    Please <a href="{{ route('login') }}"><b>sign in</b></a> or <a
                        href="{{ route('register') }}"><b>create an account</b></a> to book this ride.
                </div>
            </div>
        </div>
    </div>

@endsection


@section('foot')

    <script type="text/javascript">
        function loginModal() {
            $("#loginModal").modal();
        }
    </script>


@endsection
