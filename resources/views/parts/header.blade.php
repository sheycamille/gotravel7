
<header class="header">
    <nav class="navbar navbar-default navbar-transparent ">
        <div class="container">
            <div class="navbar-header">
              <!--  <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse" aria-expanded="false">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>-->
                <a class="navbar-brand" href="{{ route('welcome') }}">
                    <img src="{{ URL::to('assets/images') }}/go-kamz-black-white-green-logo.png" class="app-logo" height="100px">
                    <!--<picture>
                        <source media="(max-width: 992px)" srcset="{{ URL::to('assets/images') }}/new_logo.jpeg"/>
                        <source media="(min-width: 992px)" srcset="{{ URL::to('assets/images') }}/new_logo.jpeg"/>
                        <img src="{{ URL::to('assets/images') }}/new_logo.jpeg" class="app-logo">
                    </picture>-->
                </a>
            </div>
            <div class="collapse navbar-collapse" id="navbar-collapse">
                <ul class="nav navbar-nav primary">
                    <li class="">
                        <a href="{{route('get_all_rides')}}">@lang('page.header.header_ride_share_btn')</a>
                    </li>
                    <li class="">
                        <a href="">@lang('page.find_transport')</a>
                    </li>
                </ul>
                <ul class="nav navbar-nav navbar-right secondary logged-out">
                    <li>
                        <a href=""> @lang('page.offer')</a>
                    </li>
                    <li>
                        <a href=""> @lang('page.pick_up')</a>
                    </li>
                    <li class="nav-separator"></li>

                    @if(Auth::check())
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false" aria-haspopup="true">
                            {{ ucfirst(Auth::user()->username) }} <span class="caret"></span>
                        </a>

                        <ul class="dropdown-menu">
                            <li>
                                <a href="{{ route('my-profile') }}">@lang('page.profile')</a>
                            </li>

                            @if(Auth::user()->type != 'administrator')
                            <li>
                                <a href="{{ route('my-journeys') }}">@lang('page.my_journey')</a>
                            </li>
                            <li>
                                <a href="{{ route('my-rides') }}">@lang('page.my_lift')</a>
                            </li>
                            <li>
                                <a href="{{ route('my-vehicles') }}">My vehicles</a>
                            </li>
                            @endif

                            <li>
                                <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">@lang('page.header.logout')</a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">{{ csrf_field() }}</form>
                            </li>
                        </ul>
                    </li>
                    @else
                    <li><a rel="no-follow" href="{{ route('login') }}">@lang('page.login')</a></li>
                    <li><a rel="no-follow" href="{{ route('register') }}">@lang('page.sign')</a></li>
                    @endif

                    @if(App::isLocale('en'))
                    <li><a style="display: inline;font-size:10px !important;" href="{{ route('switch-language', 'en') }}"><img src="{{ URL::to('assets/images') }}/en.png" /></a></li>
                    <li><a style="display: inline;font-size:10px !important;" href="{{ route('switch-language', 'fr') }}"><img src="{{ URL::to('assets/images') }}/fr.png" /></a></li>
                    @else
                    <li><a style="display: inline;font-size:10px !important;" href="{{ route('switch-language', 'fr') }}"><img src="{{ URL::to('assets/images') }}/fr.png" /></a></li>
                    <li><a style="display: inline;font-size:10px !important;" href="{{ route('switch-language', 'en') }}"><img src="{{ URL::to('assets/images') }}/en.png" /></a></li>
                    @endif

                </ul>
            </div>
        </div>
    </nav>
</header>
