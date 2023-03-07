<!DOCTYPE html>
<html lang="en" class="svg inlinesvg svgasimg flexbox flexboxlegacy">
<head>

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title> @yield('title') | GoKamz</title>
    <meta http-equiv="X-UA-Compatible" content="chrome=1">
    <meta name="description" content="GoKamz is Cameroon&#39;s largest portal for ridesharing and peer-to-peer goods transportation. Find or offer a lift or rent cars from peope near you.">
    <meta name="keywords" content="ridesharing carpooling ride cheap transport peer-to-peer car rental rent car hire cameroon africa transport goods persons">
    <meta property="og:site_name" content="GoKamz">
    <meta property="og:title" content="Ridesharing and peer-to-peer goods transportation | GoKamz">
    <meta property="og:type" content="website">
    <meta property="og:description" content="GoKamz is Cameroon&#39;s largest portal for ridesharing and peer-to-peer goods transportation. Find or offer a ride from peope near you.">
    <meta property="og:url" content="/">
    <meta property="og:image" content="">
    <meta property="og:locale" content="en_US">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="apple-itunes-app" content="app-id=">
    <meta id="controller-options" content="{}">
    <meta name="google-play-app" content="app-id=">
    <meta name="apple-mobile-web-app-title" content="GoKamz">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta name="”referrer”" content="”always”">

    <link rel="shortcut icon" href="/assets/images/logo.png">
    <link rel="apple-touch-icon-precomposed" sizes="76x76" href="">
    <link rel="apple-touch-icon-precomposed" sizes="120x120" href="">
    <link rel="apple-touch-icon-precomposed" sizes="152x152" href="">
    <link rel="stylesheet" media="all" href="/assets/css/style.css">
    <link rel="stylesheet" media="all" href="/assets/css/bootstrap.css">
    <link rel="stylesheet" media="all" href="/assets/css/bootstrap-slider.css">
    <link rel="stylesheet" media="all" href="/assets/css/normalize.css">
    <link rel="stylesheet" media="all" href="/assets/css/animate.css">
    <link rel="stylesheet" media="all" href="/assets/css/fontawesome.css">
    <link rel="stylesheet" media="all" href="/assets/css/custom.css">
    <link rel="stylesheet" media="all" href="/assets/css/style.css">

    <style type="text/css">
        .dropdown-menu li {
            padding: 0px 15px;
            border-bottom: black dotted 1px;
        }
    </style>

    @yield('head')

</head>

<body class="default " data-gr-c-s-loaded="true">

    @yield('content')

    <footer class="footer">
        <div class="container">
            <div class="row flex flex-same-col-height">

                <div class="col-md-3 col-sm-3 col-xs-6 o-mt4 o-mt0-md">
                    <h5>Company</h5>
                    <ul class="list-unstyled">
                        <li><a href="{{ route('about') }}">About GoKamz</a></li>
                        <li><a href="{{ route('terms') }}">Terms</a></li>
                        <li><a href="{{ route('sitemap') }}">Sitemap</a></li>
                        <li><a href="{{ route('faqs') }}">FAQs</a></li>
                    </ul>
                </div>

                <div class="col-md-3 col-sm-3 col-xs-6 o-mt4 o-mt0-md text-center">
                    <h5>Ridesharing</h5>
                    <ul class="list-unstyled">
                        <li><a href="{{ route('how-ridesharing-works') }}">How it works</a></li>
                        <li><a href="{{ route('popular-routes') }}">Popular routes</a></li>
                        <li><a href="{{ route('ridesharing-points') }}">Points</a></li>
                        <!-- <li><a href="{{ route('ridesharing-tips') }}">Tips</a></li> -->
                    </ul>
                </div>

                <div class="col-md-3 col-sm-3 col-xs-6 o-mt4 o-mt0-md text-right">
                    <h5>Posting Rides/Pickups</h5>
                    <ul class="list-unstyled">
                        <li><a href="{{ route('how-offer-lift-works') }}">How it works</a></li>
                        <!-- <li><a href="{{ route('offer-lift-guidelines') }}">Guidelines</a></li> -->
                        <li><a href="{{ route('offer-lift-regulation') }}">Regulation/Policies</a></li>
                    </ul>
                </div>

                <div class="col-md-3 col-sm-3 col-xs-6 o-mt4 o-mt0-md text-right">
                    <h5>Contact Us</h5>
                    <ul class="list-unstyled">
                        <li><a target="_blank" href="#" title="Call Us">
                            <i class="fa fa-phone fa-1-4x"></i> +237 653762417</a>
                        </li>
                        <li><a target="_blank" href="https://api.whatsapp.com/send?phone=6717122221">
                            <i class="fa fa-whatsapp fa-1-4x"></i> +237 6717122221</a>
                        </li>
                        <li><a target="_blank" href="https://www.facebook.com/gokamz237">
                            <i class="fa fa-facebook fa-1-4x"></i> Meet Us</a>
                        </li>
                        <li><a target="_blank" href="https://twitter.com/gokamz">
                            <i class="fa fa-twitter fa-1-4x"></i> Follow US</a>
                        </li>
                    </ul>
                </div>

            </div>

            <div class="disclaimer">
                <div class="row">
                    <div class="col-xs-4 col-sm-5">
                        <div class="inline pull-left mr4">
                        </div>
                        <div class="hidden-xs">
                            Copyright © 2018 GoKamz
                        </div>
                    </div>
                    <div class="col-xs-4 col-sm-2 pull-right text-right">
                        <a href="https://www.facebook.com/gokamz" class="btn-link">
                            <i class="fa fa-facebook fa-1-5x"></i>
                        </a>
                        <a href="http://twitter.com/gokamz" class="btn-link">
                            <i class="fa fa-twitter fa-1-5x"></i>
                        </a>
                        <a href="http://linkedin.com/gokamz" class="btn-link">
                            <i class="fa fa-linkedin fa-1-5x"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <script type="text/javascript" src="/assets/js/jquery.js"></script>
    <script type="text/javascript" src="/assets/js/bootstrap.js"></script>

    @yield('foot')

</body>
</html>