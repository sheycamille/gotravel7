<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Mail;

use App\Mail\PasswordReset;

class FrontController extends Controller
{
    public function __construct()
    {
    }

    public function welcome()
    {
        return view('welcome');
    }

    public function terms()
    {
        return view('terms');
    }

    public function faqs()
    {
        return view('faqs');
    }

    public function about()
    {
        return view('about');
    }

    public function sitemap()
    {
        return view('sitemap');
    }

    public function support()
    {
        return view('support');
    }

    public function popular_routes()
    {
        //$rides = Ride::latest()->paginate(20);
       // return view('popular_routes', compact('rides'));
    }

    public function ridesharing_works()
    {
        return view('ridesharing_works');
    }

    public function ridesharing_safety()
    {
        return view('rides.safety');
    }

    public function ridesharing_points()
    {
        return view('rides.points');
    }

    public function ridesharing_tips()
    {
        return view('ridesharing_tips');
    }

    public function offer_lift_works()
    {
        return view('offer.how');
    }

    public function offer_lift_guidelines()
    {
        return view('offer_lift_guidelines');
    }

    public function offer_lift_regulation()
    {
        return view('offer_lift_regulation');
    }

    public function switch_language($language)
    {
        if ($language == 'fr') {
            $cookie = Cookie::queue('language', 'fr', 365 * 24 * 60);
            Session::put('language', 'fr');
            Session::save();
            return redirect()->back();
        } elseif ($language == 'en') {
            $cookie = Cookie::queue('language', 'en', 365 * 24 * 60);
            Session::put('language', 'en');
            Session::save();
            return redirect()->back();
        } else {
            $cookie = Cookie::queue('language', 'en', 365 * 24 * 60);
            Session::put('language', 'en');
            Session::save();
            return redirect()->back();
        }
    }

    public function switch_transport_type($type)
    {
        if ($type == 'goods') {
            $cookie = Cookie::queue('transport_type', 'goods', 365 * 24 * 60);
            Session::push('transport_type', 'goods');
            Session::save();
            return redirect()->back();
        } else {
            $cookie = Cookie::queue('transport_type', 'persons', 365 * 24 * 60);
            Session::push('transport_type', 'persons');
            Session::save();
            return redirect()->back();
        }
    }

}
