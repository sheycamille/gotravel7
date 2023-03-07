<style type="text/css">
    .navbar .primary .active::after{
    display: none;    
    content: '';
    position: absolute;
    left: 40%;
    bottom: 0;
    width: 0;
    height: 0;
    border-left: 8px solid transparent;
    border-right: 8px solid transparent;
    clear: both;
}
  </style>

<div class="">
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
                    <img src="/assets/images/go-kamz-black-white-logo.png" class="logo">
                </a>
            </div>
            <div class="collapse navbar-collapse" id="navbar-collapse">
                <ul class="nav navbar-nav primary">
                    <li class="@yield('active-menu1')">
                        <a href="{{ route('rides', 'persons') }}">@lang('page.share')</a>
                    </li>
                    <li class="@yield('active-menu2')">
                        <a href="{{ route('rides', 'goods') }}">@lang('page.find_transport')</a>
                    </li>
                </ul>
                <ul class="nav navbar-nav navbar-right secondary logged-out">
                    <li>
                        <a class="btn-nav" href="{{ route('create-ride', \Session::get('transport')) }}">  Post a @if(\Session::get('transport') == 'goods') pickup @else journey/ride @endif
                        </a>
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
                                <a href="{{ route('my-journeys') }}">@lang('page.my_journey')</a>
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

    <div class="navsub" >

        <div class="container">
            <ul class="list-unstyled list-inline">
                <li class=""><span class=""><a href="{{ route('rides') }}">Rides</a></span></li>
                <li class=""><span class=""><a href="">Passengers</a></span></li>
                <li class="pull-right"><span class=""><a href="{{ route('faqs') }}">Frequently Asked</a></span></li>
                <li class="pull-right"><span class=""><a href="{{ route('terms') }}">Terms&nbsp;&nbsp;&nbsp;</a></span></li>
            </ul>
        </div>
    </div>
</div>
