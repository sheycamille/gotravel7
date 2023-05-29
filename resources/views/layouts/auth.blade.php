<!DOCTYPE html>
<html lang="en" class="svg inlinesvg svgasimg flexbox flexboxlegacy">

<head>

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title> @yield('title') | GoKamz</title>
    <meta http-equiv="X-UA-Compatible" content="chrome=1">
    <meta name="description"
        content="GoKamz is Cameroon&#39;s largest portal for ridesharing and peer-to-peer goods transportation. Find or offer a lift or rent cars from peope near you.">
    <meta name="keywords"
        content="ridesharing carpooling ride cheap transport peer-to-peer car rental rent car hire cameroon africa transport goods persons">
    <meta property="og:site_name" content="GoKamz">
    <meta property="og:title" content="Ridesharing and peer-to-peer goods transportation | GoKamz">
    <meta property="og:type" content="website">
    <meta property="og:description"
        content="GoKamz is Cameroon&#39;s largest portal for ridesharing and peer-to-peer goods transportation. Find or offer a ride from peope near you.">
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

    <!-- Custom CSS -->
    <link href="/dash/css/style.min.css" rel="stylesheet">
    <link rel="stylesheet" media="all" href="/assets/css/fontawesome.css">

    

    @yield('head')


</head>

<body class="default " data-gr-c-s-loaded="true">

    <!-- ============================================================== -->
    <!-- Preloader -->

    <div class="preloader">
        <div class="lds-ripple">
            <div class="lds-pos"></div>
            <div class="lds-pos"></div>
        </div>
    </div>

    <!-- ============================================================== -->

    <div id="main-wrapper" data-layout="vertical" data-navbarbg="skin5" data-sidebartype="full"
        data-sidebar-position="absolute" data-header-position="absolute" data-boxed-layout="full">

        @yield('sidebar')

        @yield('topbar')

        <div class="page-wrapper">

            @yield('content')

        </div>


        <footer class="footer text-center"> {{--<p> Copyright © {{ $carbon::now()->format('Y') }} GoKamz</p>--}}
        </footer>

    </div>

    <!-- All Jquery -->
    <script type="text/javascript" src="/dash/js/jquery.min.js"></script>
    <!--Custom JavaScript -->
    <script src="/dash/js/custom.js"></script>
    <!--Menu sidebar -->
    <script src="/dash/js/sidebarmenu copy.js"></script>
    <!--Bootstrap CDN links -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.min.js"
        integrity="sha384-Atwg2Pkwv9vp0ygtn1JAojH0nYbwNJLPhwyoVbhoPwBhjQPR5VtM2+xf0Uwh9KtT" crossorigin="anonymous">
    </script>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.5/dist/umd/popper.min.js"
        integrity="sha384-Xe+8cL9oJa6tN/veChSP7q+mnSPaj5Bcu9mPX5F5xIGE0DVittaqT5lorf0EI7Vk" crossorigin="anonymous">
    </script>

    <script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>

    @yield('javascript')

</body>

</html>
