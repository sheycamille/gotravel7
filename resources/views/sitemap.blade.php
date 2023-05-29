@extends('layouts.app')

@section('title', 'Frequently Asked Questions')

@section($menu, 'active')

@section('content')

@section('head')

<style type="text/css">
    ul {
        padding: 0px;
    }

    li {
        list-style: none;
        font-size: 18px;
    }
</style>

@endsection

@include('parts.small_header_extend')

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <h1>Site Map</h1>

                <div class="col-sm-12">
                    @if (session('status'))
                    <div class="alert alert-success">
                        {{ session('status') }}
                    </div>
                    @endif

                    <hr class="hidden-xs">

                    <div class="col-md-4">
                        About
                        <ul class="">
                            <li class="lpage"><a href="https://www.gokamz.com/" title=" Ride Sharing and Goods Transportation | GoKamz"> Home</a></li>
                            <li class="lpage"><a href="https://www.gokamz.com/login" title=" Login | GoKamz"> Login</a></li>
                            <li class="lpage"><a href="https://www.gokamz.com/register" title=" Sign up | GoKamz"> Sign up</a></li>
                            <li class="lpage"><a href="https://www.gokamz.com/about" title=" About Us | GoKamz"> About Us</a></li>
                            <li class="lpage"><a href="https://www.gokamz.com/terms" title=" Terms and conditions | GoKamz"> Terms and conditions</a></li>
                            <li class="lpage last-page"><a href="https://www.gokamz.com/faqs" title=" Frequently Asked Questions | GoKamz"> Frequently Asked Questions</a></li>
                            <li class="lpage"><a href="https://www.gokamz.com/sitemap" title=" Sitemap | GoKamz"> Sitemap</a></li>
                        </ul>
                    </div>

                    <div class="col-md-4">
                        Ridesharing

                        <ul class="">
                            <li class="lpage"><a href="https://www.gokamz.com/how/ridesharing/works" title=" How ride sharing works | GoKamz"> How it works </a></li>
                            <li class="lpage"><a href="https://www.gokamz.com/how/ridesharing/points" title=" How to earn and use Gokamz Points | GoKamz"> How to earn and use Gokamz Points </a></li>
                            <li class="lpage last-page"><a href="https://www.gokamz.com/how/ridesharing/popular_routes" title=" Popular routes | GoKamz"> Popular routes </a></li>
                        </ul>
                    </div>

                    <div class="col-md-4">
                        Posting pickups
                        <ul class="">
                            <li class="lpage"><a href="https://www.gokamz.com/rides/list/persons" title=" How posting works | GoKamz"> How posting works </a></li>
                            <li class="lpage last-page"><a href="https://www.gokamz.com/rides/list/goods" title=" Regulation & Policies | GoKamz"> Regulation & Policies </a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<br><br><br><br>
@endsection
