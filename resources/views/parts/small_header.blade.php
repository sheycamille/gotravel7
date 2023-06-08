<header class="header">
    <nav class="navbar navbar-default" >
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse" aria-expanded="false">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="{{ route('welcome') }}">
                    <img src="/assets/images/TRAVELZ-LOGO-444444.png" class="logo">
                </a>
            </div>
            <div class="collapse navbar-collapse" id="navbar-collapse">
                <ul class="nav navbar-nav primary">
                    <li class="@yield('active-menu1')">
                        <a href="">@lang('page.share')</a>
                    </li>
                    <li class="@yield('active-menu2')">
                        <a href="">@lang('page.find_transport')</a>
                    </li>
                </ul>
                <ul class="nav navbar-nav navbar-right secondary logged-out">
                    <li>
                        <a href="">@lang('page.offer')</a>
                    </li>
                    <li>
                        <a href=""> @lang('page.pick_up') </a>
                    </li>
                    <li class="nav-separator"></li>
                    @guest
                    <li><a rel="no-follow" href="{{ route('login') }}">@lang('page.login')</a></li>
                    <li><a rel="no-follow" href="{{ route('register') }}">@lang('page.sign')</a></li>
                    @else
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false" aria-haspopup="true">
                            {{ ucfirst(Auth::user()->username) }} <span class="caret"></span>
                        </a>


                        <ul class="dropdown-menu">
                            <li>
                                <a href="{{ route('my-profile') }}">@lang('page.profile')</a>
                            </li>
                            <li>
                                <a href="{{ route('my-journeys') }}">@lang('page.my_journeyMy')</a>
                            </li>
                            <li>
                                <a href="{{ route('my-rides') }}">@lang('page.my_lift')</a>
                            </li>
                            <li>
                                <a href="{{ route('my-vehicles') }}">My vehicles</a>
                            </li>
                            <li>
                                <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    @lang('page.logout')
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    {{ csrf_field() }}
                                </form>
                            </li>
                        </ul>
                    </li>
                    @endguest

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
