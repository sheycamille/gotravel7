<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;

use App\Models\Ride;
use App\Models\User;
use App\Models\Vehicle;

use DataTables;

class UserController extends Controller
{

    public function driversList(Request $request)
    {
        //$owner = new Ride();
        $drvers = User::where('type', '=', 'driver')->get();

        if ($request->ajax()) {
            $data = User::where('type', '=', 'driver')->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($driver) {

                    $actionbtn = '';

                    if ($driver->status == '1') {
                        $actionbtn .= '<a  class=" btn rounded btn-primary ms-3 btn-sm" href="' . route('unblockuser', $driver->id) . '">Unblock</a>';
                    } else {
                        $actionbtn .= '<a  class=" btn rounded btn-danger ms-3 btn-sm" href="' . route('blockuser', $driver->id) . '">Block</a>';
                    }

                    return $actionbtn;
                })
                ->addColumn('name', function ($drver) {
                    return $drver->first_name . ' ' . $drver->last_name;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('admin.manage-drivers')->with(array(
            'drvers' => $drvers,
        ));
    }

    public function passengersList(Request $request)

    {

        if ($request->ajax()) {
            $pasngers = User::where('type', '=', 'passenger')->get();
            return DataTables::of($pasngers)
                ->addIndexColumn()
                ->addColumn('name', function ($pasngers) {
                    return $pasngers->first_name . ' ' . $pasngers->last_name;
                })


                ->addColumn('action', function ($pasngers) {
                    $actionbtn = '';

                    if ($pasngers->status == '1') {
                        $actionbtn .= '<a  class=" btn rounded btn-primary ms-3 btn-sm" href="' . route('unblockuser', $pasngers->id) . '">Unblock</a>';
                    } else {
                        $actionbtn .= '<a  class=" btn rounded btn-danger ms-3 btn-sm" href="' . route('blockuser', $pasngers->id) . '">Block</a>';
                    }

                    return $actionbtn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('admin.manage-passengers');
    }

    public function index()
    {
        $user = Auth::user();
        if (!$user) return redirect()->back()->with('message', 'User not found');

        return view('user.details', compact('user'));
    }


    public function edit()
    {
        $user = Auth::user();
        if (!$user) return redirect()->back()->with('message', 'User not found');

        return view('user.edit', compact('user'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();
        
        if (!$user) return redirect()->back()->with('message', 'User not found');

        $request->validate([
            'avatar' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:5000',
        ]);

        $avta = $imageName = time() . '.' . $request->avatar->getClientOriginalName();

        // Public Folder
        $request->avatar->move(public_path('uploads/avatars'), $imageName);

        $user->update([
            'username' => $request->username,
            'email' => $request->email,
            'phone_number' => $request->phone_number,
            'type' => $request->type,
            'gender' => $request->gender,
            'language' => $request->language,
            'primary_address' => $request->primary_address,
            'nic' => $request->nic,
            'avatar' => $avta
        ]);

        $user->username = $request['username'];
        $user->email = $request['email'];
        $user->phone_number = $request['phone_number'];
        $user->type = $request['type'];
        $user->gender = $request['gender'];
        $user->language = $request['language'];
        $user->primary_address = $request['primary_address'];




        // $this->doValidate($data)->validate();

        /* $imageName = '';
        if ($request->has('avatar')) {
            $imageN = substr($request->avatar->getClientOriginalName(), 0, strpos($request->avatar->getClientOriginalName(), '.'));
            $imageN = strtolower(preg_replace('#[ -]+#', '-', $imageN));
            $imageName = $imageN . '-' . date('Y-m-d-H:m:s') . '.' . $request->avatar->getClientOriginalExtension();
            request()->avatar->move(public_path('uploads/avatars'), $imageName);
            $imageName = '/uploads/avatars/' . $imageName;
            $data['avatar'] = $imageName;
        }*/

        //$user->save();

        //switch the user's language
        if ($request->language == 'french') {
            $cookie = Cookie::queue('language', 'fr', 365 * 24 * 60);
            Session::put('language', 'fr');
            Session::save();
        } else {
            $cookie = Cookie::queue('language', 'en', 365 * 24 * 60);
            Session::put('language', 'en');
            Session::save();
        }

        return view('user.details', compact('user'))->with('message', 'Your account information successfully updated')->with('image', $imageName);
    }

    public function rides()
    {
        $user = Auth::user();
        if (!$user) return redirect()->back()->with('message', 'User not found');

        $rides = Ride::whereDriverId($user->id)->paginate(20);

        return view('user.rides', compact('user', 'rides'));
    }

    public function vehicles()
    {
        $type = new Vehicle();
        $cartype =  $type->getvehicleType();

        $id = Auth::id();

        $vehicles = Vehicle::where('owner_id', $id)->get();

        return view('user.vehicles')->with(array(
            'vehicles' => $vehicles,
            'cartype' => $cartype,
            'type' => $type,

        ));
    }

    public function journeys()
    {
        $user = Auth::user();
        if (!$user) return redirect()->back()->with('message', 'User not found');

        $user_id = $user->id;
        $journeys = Ride::join('ride_passengers', function ($join) use ($user_id) {
            $join->on('rides.id', '=', 'ride_passengers.ride_id')
                ->where('ride_passengers.passenger_id', '=', $user_id);
        })
            ->select('rides.*')
            ->paginate(20);

        return view('user.journeys', compact('user', 'journeys'));
    }

    public function changePassword(Request $request)
    {
        $user = Auth::user();
        if (!$user) return redirect()->back()->with('message', 'User not found');

        $newpass = $request->newpass;
        $cnewpass = $request->cnewpass;

        if ($newpass == $cnewpass && Hash::check($request->oldpass, $user->password)) {
            $user->password = Hash::make($newpass);
            $user->save();

            return redirect()->back()
                ->with('success', 'Password has been successfully reset!');
        } else {

            return redirect()->back()
                ->with('error', "There was an error changing your password, please make sure you enter the right old password or get to the administrator to reset it. Also, make sure the new password and it's confirmation match, thanks.");
        }
    }

    public function dashboard()
    {
        $user = Auth::user();

        $user_id = $user->id;

        $rides = Ride::where('driver_id', $user_id)->take(3)->get();

        $pendx_jounrneys = Ride::join('ride_passengers', 'rides.id', '=', 'ride_passengers.ride_id')
            ->where('ride_passengers.passenger_id', '=', $user_id)
            ->where('ride_passengers.status', '=', 'in_process')
            ->get();

        $recent_trips = Ride::join('ride_passengers', 'rides.id', '=', 'ride_passengers.ride_id')
            ->where('ride_passengers.passenger_id', '=', $user_id)
            ->where('ride_passengers.status', '=', 'ended')
            ->take(3)->get();

        return view('user.dashboard')->with(array(
            'rides' => $rides,
            'user' => $user,
            'pendx_jounrneys' => $pendx_jounrneys,
            'recent_trips' => $recent_trips
        ));
    }
}
