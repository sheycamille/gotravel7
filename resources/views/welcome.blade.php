@extends('layouts.app')

@section('title', 'Ride Sharing and Goods Transportation')

@section('head')

    <link rel="stylesheet" href="{{ URL::to('assets/plugins') }}/datetimepicker/jquery.datetimepicker.min.css">
    <style>
        .btn-brand:hover {
            background: red;
        }
    </style>


@endsection

@section('content')

@include('parts.header')

    <div class="hero shadow-top flex flex-align-center flex-column nav-offset hero--km">
        <div class="relative flex flex-grow h-90vh-xs">
            <div class="flex flex-align-center">
                <div class="container mb6 mb0-sm">
                    <div id="js-offering-neutral">
                        <h1 class="hero__heading">@lang('page.heading')</h1>
                        <h2 class="hero__subheading">@lang('page.hero__subheading')</h2>
                        <a class="btn btn-lg btn-brand btn-w260 btn-shadow btn--hero" style="background-color: #4cc417; "
                            onMouseOver="this.style.background='#8bc34a'" onMouseOut="this.style.background='#4cc417'"
                            id="initial-select-ridesharing" href="#findlift">@lang('page.find_lift')</a>
                        <span class="hero__or">@lang('page.or')</span>
                        <a class="btn btn-lg btn-brand btn-w260 btn-shadow btn--hero" style="background-color: #4cc417"
                            onMouseOver="this.style.background='#8bc34a'" onMouseOut="this.style.background='#4cc417'"
                            id="initial-select-rental" href="#findlift">@lang('page.find_transport')</a>
                    </div>

                    <div class="offering offering--rideshare" id="js-offering-rideshare" style="display: none">
                        <div class="segmented-control">
                            <ul class="segmented-control__list ">
                                <li class="segmented-control__list-item">
                                    
                                        @lang('page.find_lift')
                                    </a>
                                </li>
                                <li class="segmented-control__list-item">
                                    
                                        @lang('page.find_transport')
                                    </a>
                                </li>
                            </ul>
                        </div>

                    </div>

                </div>
            </div>
        </div>

        <div class="new-type w-100% pv3 pv1-sm bt b--white-opacity-30 relative">
            <div class="shadow-bottom flex">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12">
                            <!-- <img class="mr1 hidden-xs" width="70" height="70" src=""> -->
                            <span class="text-white text-shadow semi-bold f4 inline-block tcenter mr4 mb4 mb0-sm">
                                @lang('page.gk_points')
                            </span>

                            <a class="btn btn-points " href="{{ route('register') }}">
                                @lang('page.join')
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="js-autocompleter o-mb3">
        <div class="col-md-8 col-md-offset-2">
            <h1 class="f2 dark-blue tcenter" id="findlift">
                @lang('page.journey_here')
            </h1>
        </div>
    </div>

    <div class="col-md-6 col-md-offset-3">

        <form id="quicksearch" target="_parent" class="search-form" action="{{ route('rides') }}" accept-charset="UTF-8"
            method="get">

            {{ csrf_field() }}

            <div class="tleft col-xs-12">

                <input id="pickup"
                    class="js-autocompleted search-form__control input-lg with-icon places-search places-search1 col-xs-11"
                    name="pickup" placeholder="@lang('page.current_location')" type="text" tabindex="1" required
                    autocomplete="off" value="{{ old('pickup') }}">

                <button type="button" id="js-swap-btn" class="btn btn-default search-form__swap "
                    title="Choose opposite direction" onclick="swapDD()"></button>

                <input id="destination"
                    class="js-autocompleted search-form__control input-lg with-icon icon-to places-search places-search1 col-xs-12 pull-right"
                    required name="destination" placeholder="@lang('page.destination')" type="text" tabindex="2"
                    autocomplete="off" value="{{ old('destination') }}">
                <div class="clearfix"><br></div>

                <div class="date-time-picker date-time-picker--hero-rental">
                    <div class="date-time-input-half-width o-mr3">
                        <div class="date-time-input o-mb3">
                            <input type="text" id="datetime2" value="{{ old('date') }}"
                                class="date-time-input__date  date-picker date-time-input__date--sm search-form__control input-lg with-icon--sm icon-pickup hasDatepicker"
                                placeholder="Date" name="date" tabindex="3">
                        </div>
                    </div>

                    <div class="date-time-input-half-width">
                        <div class="date-time-input o-mb3">
                            <input type="text" id="datetime1" value="{{ old('time') }}"
                                class="date-time-input__date date-time-input__date--sm search-form__control input-lg with-icon--sm hasDatepicker"
                                placeholder="Time" name="time" tabindex="4">
                        </div>
                    </div>
                </div>

                <button name="button" type="submit" style="background-color: #4cc417" id="rental-search-search-btn"
                    class="btn btn--offering btn--offering-rental btn-brand btn-lg">@lang('page.search_button')</button>
            </div>
        </form>
    </div>

    <div class="new-type pt10 pb8">
        <div class="container">
            <div class="row">
                <div class="col-md-8 col-md-offset-2">
                    <h1 class="f2 dark-blue tcenter">
                        @lang('page.branding')
                    </h1>
                    <p class="lead mb10 gray-60 tcenter">
                        @lang('page.description')
                    </p>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">

                    <div class="media mb6 col-md-4">
                        <div class="media-left pt1 pr5 pr6-sm">
                            <img width="48" height="48" class="media-object"
                                src="{{ URL::to('assets/images') }}/icon_leasing_green.png" alt="Icon leasing orange">
                        </div>
                        <div class="media-body">
                            <h3 class="f4 dark-blue">
                                @lang('page.share')
                            </h3>
                            <p class="gray-40">
                                @lang('page.do_get_bored')
                            </p>
                        </div>
                    </div>

                    <div class="media mb6 col-md-4">
                        <div class="media-left pt1 pr5 pr6-sm">
                            <img width="48" height="48" class="media-object"
                                src="{{ URL::to('assets/images') }}/icon_bus_green.png" alt="Icon rental blue">
                        </div>
                        <div class="media-body">
                            <h3 class="f4 dark-blue">
                                @lang('page.goods')
                            </h3>
                            <p class="gray-40">
                                @lang('page.transport_means')
                            </p>
                        </div>
                    </div>

                    <div class="media mb6 col-md-4">
                        <div class="media-left pt1 pr5 pr6-sm">

                            <img width="48" height="48" class="media-object"
                                src="{{ URL::to('assets/images') }}/icon_points_badge.png" alt="Gokamz Points">
                        </div>
                        <div class="media-body">
                            <h3 class="f4 dark-blue">
                                @lang('page.points')
                                <span style="background-color: #4cc417"
                                    class="label br-pill semi-bold f6 uppercase ml1 inline-block">
                                    New
                                </span>
                            </h3>
                            <p class="gray-40">
                                @lang('page.earn_points')
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="main">
        <div class="container">
            <div class="row">
                <div class="container">

                    <div class="rental-section">
                        <div class="row">
                            <div class="col-md-7 col-sm-8 col-md-offset-1 rental-bg-km"></div>
                            <div class="col-md-3 col-sm-4 rental-content">
                                <h3>@lang('page.share_car')</h3>
                                <!-- <p></p> -->
                                <a class="btn btn-primary btn-lg btn-block"
                                    href="">@lang('page.offer_lift_btn')</a>
                            </div>
                        </div>
                    </div>

                    <div class="mt10">
                        <div class="vanity-numbers tcenter">
                            <div class="row">
                                <div class="col-sm-4 vanity-block">

                                    <span class="icon-bg orange1 img-circle">
                                        <img height="48" width="48"
                                            src="{{ URL::to('assets/images') }}/icon_user_white-11619d3896a98a5e6a25991d382763c009caaa61dbbc9b6c89bc468fe022912f.svg"
                                            alt="Number of Gokamz users">
                                    </span>
                                    <h2 class="vanity-number">
                                        {{-- {{ \App\Models\User::count() }} --}}
                                        250
                                    </h2>
                                    <span class="vanity-description">@lang('page.mem')</span>
                                </div>
                                <div class="col-sm-4 vanity-block">

                                    <span class="icon-bg orange1 img-circle">
                                        <img height="48" width="48"
                                            src="{{ URL::to('assets/images') }}/icon_rental_white-626e8306de640dbecbf9b84ff648be78355ce2ac69c3bf7ae67552ac6134ff12.svg"
                                            alt="Number of rides being shared">
                                    </span>
                                    <h2 class="vanity-number">{{-- {{ \App\Models\Ride::count() }} --}}20</h2>
                                    <span class="vanity-description">@lang('page.cars_shared')</span>
                                </div>
                                <div class="col-sm-4 vanity-block">

                                    <span class="icon-bg orange1 img-circle">
                                        <img height="48" width="48"
                                            src="{{ URL::to('assets/images') }}/icon_rating_white-2e974e1e658fc55817dbdcdad67a5c00e9406cf3e2244c5e5309ab6a1e4b209b.svg"
                                            alt="Average driver rating on Gokamz">
                                    </span>
                                    <h2 class="vanity-number">4.5 </h2>
                                    <span class="vanity-description">@lang('page.average_mem')</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="new-type">
        <div class="pv6 pv10-sm ph4 " style="background-color: #4cc417; opacity:0.99">
            <h2 class="mb4 f2 tcenter">
                @lang('page.ready_to_join')
            </h2>
            <p class="mb6 big tcenter">
                @lang('page.has') {{-- {{ \App\Models\User::count() }} --}}250 @lang('page.mem') @lang('page.sign_today')
                —
                <span class="semi-bold">
                    @lang('page.its_free')
                </span>
            </p>
            <div class="tcenter">
                <a class="btn btn-default btn-xl btn-w300 mb4 mb0-sm mr4-sm bn" style="color: #4cc417"
                    href="{{ route('register') }}">
                    @lang('page.fbk')
                </a>
                <a href="{{ route('register') }}" class="btn btn-default btn-xl btn-w300 bn" style="color: #4cc417">
                    @lang('page.with_phone_number')
                </a>
            </div>
        </div>
    </div>

@endsection




@section('foot')

    <script src="{{ URL::to('assets/plugins') }}/datetimepicker/jquery.datetimepicker.full.js"></script>
    <script type="text/javascript">
        $(function() {

            $('#datetime1').datetimepicker({
                datepicker: false,
                format: 'H:i',
                step: 05
            });

            $('#datetime2').datetimepicker({
                lang: 'en',
                timepicker: false,
                format: 'd-m-Y',
                formatDate: 'Y-m-d'
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
    <script
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBabVxQOzXEbwg3GL2FuqW5baV_1xu9fJk&libraries=places&callback=activatePlacesSearch"
        async defer></script>

@endsection
