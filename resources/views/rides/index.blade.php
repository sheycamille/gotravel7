@extends('layouts.app')

@section('title', 'Rides')

@section($menu, 'active')

@section('head')

<link rel="stylesheet" href="{{ URL::to('assets/plugins') }}/datetimepicker/jquery.datetimepicker.min.css">

@endsection

@section('content')

@include('parts.small_header_extend')

<div id="finder" class="js-sticky sticky-sm z-2-sm bg-white pv2 bb b--gray-15" style="top: 0">
    <div class="container rideshare pv2 ph3 ph4-sm">
        <div class="intro">
            <h5>Share your next trip with others</h5>
            <p class="hidden-xs">Ridesharing is fun, cheap and flexible transportation</p>
        </div>

        <form id="quicksearch" target="_parent" class="search-form flex-md" action="{{ route('rides') }}" accept-charset="UTF-8" method="get">

            {{ csrf_field() }}

            <div class="form-group o-mb4 o-mb0-md o-mr3-md flex-grow-md">
                <span class="js-autocompleter">
                    <input id="pickup" class="js-autocompleted search-form__control input-lg with-icon places-search" name="pickup" placeholder="@lang('page.current_location')" type="text" tabindex="1" autocomplete="off" value="{{ $pickup }}">
                </span>
            </div>

            <div class="search-wrapper o-mr3 hidden-sm hidden-xs">
                <button type="button" id="js-swap-btn" class="btn btn-default search-form__swap" title="Choose opposite direction" onclick="swapDD()"></button>
            </div>

            <div class="form-group o-mb4 o-mb0-md o-mr3-md flex-grow-md">
                <span class="js-autocompleter">
                    <input id="destination" class="js-autocompleted search-form__control input-lg with-icon icon-to places-search" name="destination" placeholder="Destination..." type="text" tabindex="2" autocomplete="off" value="{{ $destination }}">
                </span>
            </div>

            <div class="date-time-picker date-time-picker--rideshare o-mr2">
                <div class="date-time-input">
                    <input type="text" id="datetime1" value="{{ old('date') }}" name="date" class="js-datepicker datepicker date-time-input__date search-form__control input-lg with-icon--sm hasDatepicker" tabindex="3" placeholder="Date">
                    <input type="text" id="datetime2" value="{{ old('time') }}" name="time" class="date-time-input__time search-form__control input-lg with-icon--sm hours ui-timepicker-input" tabindex="4" autocomplete="off" placeholder="Time">
                </div>
            </div>

            <div class="form-group o-mb4 o-mb0-md o-mr3-md flex-grow-md">
                <div class="js-autocompleter">
                    <select class="search-form__control input-lg" id="type" type="text" value="{{ old('type') }}" name="type" required  tabindex="5" placeholder="transport persons or goods">
                        <option value="">For...</option>
						<option @if(\Session::get('transport') == 'persons') selected="selected" @endif value="persons">Persons</option>
						<option @if(\Session::get('transport') == 'goods') selected="selected" @endif value="goods">Goods</option>
				    </select>
                </div>
            </div>

            <div class="search-wrapper">
                <input class="search-form__btn btn btn-primary btn-lg submitter" data-url="{{ route('rides', 'persons') }}" tabindex="6" value="Search rides" type="submit">
            </div>
        </form>
    </div>
</div>


<div class="main main--dark">
    <div class="container">
        <div class="row">

            @include('parts.options_sidebar')

            <div class="col-sm-10">

                <h1>Upcoming Rides</h1>

                @if ($message = Session::get('success'))
                <div class="alert alert-success alert-block">	
                        <strong>{{ $message }}</strong>
                        <button type="button" class="close" data-bs-dismiss="alert" aria-label="Close">×</button>
                </div>
                @endif


                @if ($message = Session::get('error'))
                <div class="alert alert-danger alert-block">
                    <button type="button" class="close" data-dismiss="alert">×</button>	
                        <strong>{{ $message }}</strong>
                </div>
                @endif

                <div class="card new-type mb4 mb5-sm pa5 flex">
                    <div class="mr4">
                        <img width="48" height="48" class="media-object" src="{{ URL::to('assets/images') }}/icon_points_badge_green.png" alt="Gokamz Points">
                    </div>
                    <div>
                        <h4 class="f-base mb1">Earn GoKamz Points on every booking</h4>
                        <p class="mb0 gray-40">
                            Use points to save money on your next ride.
                            <a style="color: #4cc417;" class="link-unstyled " href="{{ route('ridesharing-points') }}">
                                Learn more
                            </a>              
                        </p>
                    </div>
                </div>

                <div id="rides">
                    <ul class="list-unstyled">

                        <li class="js-sticky sticky static-sm t0 z-1 pt4 pb3 pt6-sm pb5-sm ph4 mv1 nmh-2 mh0-sm hidden-sm hidden-md hidden-lg bg-brand-paper">
                            <h3 class="mb0 f7 f5-sm flex flex-align-center uppercase-xs gray-80">
                                <img width="16" height="16" alt="" class="block mr2 mb1" src="">
                                Today
                            </h3>
                        </li>

                        @foreach($rides as $ride)

                        <li class="card pa0 mb4">
                            <a class="link-unstyled" href="{{ route('details-ride', $ride->id) }}">
                                <div class="flex-sm">
                                    <div class="pv4 ph3 ph4-sm flex-sm flex-column flex-grow flex-order-2 minw-0 bb bnb-sm br-sm b--gray-7 overflow-hidden">
                                        <div class="mb2 flex flex-align-center">
                                            <h3 class="mb0 f-base f3-sm">
                                                On {{ $ride->getFullFormatedDate() }}
                                            </h3>
                                            <div class="ml2 flex-grow flex-align-center tright">
                                                <img class="w-20 w-24-sm h-20 h-24-sm ml1 ml2-sm" alt="" title="" data-toggle="tooltip" data-placement="top" src="" data-original-title="">
                                            </div>
                                        </div>

                                        <div class="flex-sm flex-grow flex-column hidden-xs">
                                            <h4 class="mb0 f-base f4-sm">
                                                {{ $ride->departure }}
                                                <span class="route-arrow hidden-xs">→</span>
                                                {{ $ride->destination }}
                                            </h4>
                                        </div>

                                        <div>
                                            <div class="mb2 mb1-sm">
                                                <h4 class="mb0 f-base hidden-sm hidden-md hidden-lg">
                                                    {{ $ride->departure }}
                                                </h4>
                                                <div class="gray-40 trunc-line-sm">
                                                    Start: {{ $ride->departure }}, {{ $ride->pickup_location }}
                                                </div>
                                            </div>

                                            <div class="mb0">
                                                <h4 class="mb0 f-base hidden-sm hidden-md hidden-lg">
                                                    {{ $ride->destination }}
                                                </h4>
                                                <div class="gray-40 trunc-line-sm">
                                                    End: {{ $ride->destination }}
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="pv2 ph3 pa0-sm flex flex-column-sm flex-align-center flex-order-3 bb bnb-sm b--gray-7 minw-135">
                                        <div class="pa4-sm flex flex-align-center flex-1 flex-order-2-sm">
                                            <span title="" data-toggle="tooltip" data-placement="top" data-original-title="{{ $ride->noOfSeats }} seats were available">
                                                @foreach(array_fill(0, $ride->passengers()->count(), 1) as $index)
                                                <img alt="{{ $ride->num_of_seats }} seats taken" class="icon-seat" src="{{ URL::to('assets/images') }}/red-icon.svg">
                                                @endforeach
                                                @foreach(array_fill(0, $ride->spacesLeft(), 1) as $index)
                                                <img alt="{{ $ride->num_of_seats }} seats left" class="icon-seat" src="{{ URL::to('assets/images') }}/green-icon.svg">
                                                @endforeach
                                                
                                            </span>
                                            {{ $ride->spacesLeft() }} Seats left of {{ $ride->num_of_seats }}
                                        </div>

                                        <div class="pa4-sm flex-sm flex-justify-center flex-align-center flex-1 flex-order-1-sm w-100% f4 bb-sm b--gray-7 tright uppercase bold tcenter-sm">
                                            XAF {{ $ride->cost }}
                                        </div>
                                    </div>
                                    <div class="pv4 ph3 ph6-sm flex flex-column-sm flex-align-center flex-order-1 br-sm b--gray-7 minw-165 mw-11-sm">
                                        <div class="mr3 mr0-sm relative">
                                            <img alt="{{ $ride->driver->username }}" class="avatar-image" src="{{ asset('uploads/avatars/' .$ride->driver->username)}}">
                                            {{--<img alt="" class="avatar-image__superuser" src="">--}}
                                        </div>
                                        <div class="mw-100% tcenter-sm">
                                            <div class="flex flex-column-sm">
                                                <div class="mr2 mr0-sm gray-80 semi-bold trunc-line-sm">
                                                    {{ $ride->driver->getName() }}
                                                </div>
                                                <div class="lh-solid top" data-placement="top" data-toggle="tooltip" data-original-title="">
                                                </div>
                                            </div>
                                            <div class="mb0 f6 gray-40 hidden-sm hidden-md hidden-lg">
                                                {{ $ride->driver->ratings }} ratings
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>   
                        </li>   
            
                      <!--<div class="card new-type mb4 mb5-sm pa5 flex">
                            <p class="text-danger " style="font-size:20px; color:#4cc417;">Sorry we could not find any rides for your destination, please wait for some few hours and try again. Thanks for using our services.</p>-->
                        </div>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('foot')

<script src="{{ URL::to('assets/plugins') }}/datetimepicker/jquery.datetimepicker.full.js"></script>
<script type="text/javascript">
  $(function() {

    $('#datetime1').datetimepicker({
        lang:'en',
        timepicker:false,
        format:'d-m-Y',
        formatDate:'Y-m-d'
    });

    $('#datetime2').datetimepicker({
        datepicker:false,
        format:'H:i',
        step:05 
    });

});
</script>

<script type="text/javascript">
    function activatePlacesSearch() {
        var placesInput = document.getElementsByClassName('places-search');
        var autocomplete1 = new google.maps.places.Autocomplete(placesInput[0]);
        var autocomplete2 = new google.maps.places.Autocomplete(placesInput[1]);
    }

    function swapDD() {
        var pickup = document.getElementById('pickup');
        var destination = document.getElementById('destination');
        var temp = pickup.value;
        pickup.value = destination.value;
        destination.value = temp;
    }
</script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBabVxQOzXEbwg3GL2FuqW5baV_1xu9fJk&libraries=places&callback=activatePlacesSearch" async defer></script>

@endsection