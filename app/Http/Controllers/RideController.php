<?php

namespace App\Http\Controllers;

use App\Models\Ride;
use App\Models\RidePassenger;
use App\Models\User;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

use Datatables;

class RideController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth')->except(['search', 'details']);
    }

    /**
     * Get a doValidate for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function doValidate(array $data)
    {
        return Validator::make($data, [
            'pickup_location' => 'required|string',
            'departure' => 'required|string',
            'destination' => 'required|string',
            'start_day' => 'required|string',
            'start_time' => 'required|string',
            'cost' => 'required|min:1',
            'driver_id' => 'required',
            'noOfSeats' => 'min:1'
        ]);
    }


    public function create(Request $request, $type = 'persons')
    {

        if ($type == 'goods') {
            $cookie = Cookie::queue('transport', 'goods', 365 * 24 * 60);
            session(['transport' => 'goods']);
            $menu = 'active-menu2';
        } else {
            $cookie = Cookie::queue('transport', 'persons', 365 * 24 * 60);
            session(['transport' => 'persons']);
            $menu = 'active-menu1';
        }

        return view('rides.create', compact('menu'));
    }

    public function store(Request $request)
    {
        /*$data = $request->all();
        $data['num_of_seats'] = $request->noOfSeats;
        $data['driver_id'] = Auth::user()->id;
        $this->doValidate($data)->validate();

        $ride = Ride::create($data);*/

        $pickup_location = $request->input('pickup_location');
        $departure = $request->input('departure');
        $destination = $request->input('destination');
        $start_day = $request->input('start_day');
        $start_time = $request->input('start_time');
        $cost = $request->input('cost', '');
        $driver_id = Auth::user()->id;
        $num_seats = $request->input('noOfSeats');

        $data = array(
            'pickup_location' => $pickup_location,
            "departure" => $departure,
            "destination" => $destination,
            "start_day" => $start_day,
            'start_time' => $start_time,
            'cost' => $cost,
            'driver_id' => $driver_id,
            "num_of_seats" => $num_seats
        );

        // $this->doValidate($data)->validate();

        DB::table('rides')->insert($data);

        if (Auth()->user()->type == 'administrator') {

            return redirect()->route('mrides')->with('success', 'Ride Created succesfully');
        } else {

            return redirect()->intended('profile/rides')->with('success', 'Ride successfully created');
        }
    }

    public function details(Request $request, $id)
    {
        $ride = Ride::find($id);
        if (!$ride) return redirect()->back()->with('message', 'Ride not found');

        return view('rides.details', compact('ride'));
    }

    public function edit(Request $request, $id)
    {
        $ride = Ride::find($id);
        if (!$ride) return redirect()->back()->with('message', 'Ride not found');

        if ($ride->driver_id != Auth::user()->id) {
            return redirect()->back()->with('message', "Sorry you can't edit another persons ride");
        }

        return view('rides.edit', compact('ride'));
    }

    public function update(Request $request, $id)
    {
        $ride = Ride::find($id);
        if (!$ride) return redirect()->back()->with('message', 'Ride not found');

        $data = $request->all();
        // $this->doValidate($data)->validate();
        if ($request->noOfSeats == '')
            unset($data['noOfSeats']);
        if ($request->comments == '')
            unset($data['comments']);
        $ride->update($data);

        if (Auth()->user()->type == 'administrator') {

            return redirect()->route('mrides')->with('success', 'Ride Updated succesfully');
        } else {

            return view('rides.edit', compact('ride'))->with('message', 'Ride successfully updated');
        }
    }

    public function delete($id)
    {
        $ride = Ride::find($id);
        if (!$ride) return redirect()->back()->with('message', 'Ride not found');

        $ride->delete();

        if (Auth()->user()->type == 'administrator') {

            return redirect()->back()->with('success', 'Ride Deleted');
        } else {

            return redirect()->intended('rides')->with('message', 'Ride successfully deleted');
        }
    }


    public function join(Request $request, $id)
    {
        $ride = Ride::find($id);
        if (!$ride) return redirect()->back()->with('message', 'Ride not found');

        if ($ride->isAPassenger()) {
            return redirect()->back()->with('message', "Sorry you can't join your own ride");
        }

        $journey = RidePassenger::create([
            'ride_id' => $id,
            'passenger_id' => Auth::user()->id,
            'status' => 'in_process',
            'paid' => 'pending',
            'type' => 'persons'
        ]);

        return redirect()->back()->with('success', 'Successfully joined journey');
    }


    public function cancelBooking()
    {

        $id = Auth::user()->id;

        DB::table('ride_passengers')->where('passenger_id', $id)->delete();

        return redirect()->back()->with('success', 'Successfully canceled booking');
    }

    public function search(Request $request, $type = '')
    {

        if (isset($request->type) && $type == '') {
            $type = $request->type;
        }

        if ($type == '') {
            $type = Session::get('transport');
        }

        if ($type == 'goods') {
            $cookie = Cookie::queue('transport', 'goods', 365 * 24 * 60);
            session(['transport' => 'goods']);
            $menu = 'active-menu2';
        } else {
            $cookie = Cookie::queue('transport', 'persons', 365 * 24 * 60);
            session(['transport' => 'persons']);
            $menu = 'active-menu1';
        }

        $pickup = '';
        $destination = '';
        $start_day = '';
        $start_time = '';
        $where = array(['type', '=', $type], ['status', '<>', 'ended']);

        if ($request->pickup) {
            $pickup = strtolower($request->pickup);
            // array_push($where, ['departure', 'like', '%' . $pickup . '%']);
        }
        // var_dump($where);
        if ($request->destination) {
            $destination = strtolower($request->destination);
            // array_push($where, ['destination', 'like', '%' . $destination . '%']);
        }
        if ($request->start_day) {
            $start_day = $request->start_day;
            // array_push($where, ['start_day', '>=', date_format(date_create($start_day), 'd-m-Y')]);
        }
        if ($request->start_time) {
            $start_time = $request->start_time;
            // array_push($where, ['start_time', '>=', date_format(date_create($start_time), 'd-m-Y')]);
        }
        $rides = [];

        if ($pickup != '' || $destination != '') {
            $rides = Ride::where($where)
                ->orWhere('departure', 'like', '%' . $pickup . '%')
                ->orWhere('destination', 'like', '%' . $destination . '%')
                ->orderBy('start_day', 'asc')
                ->orderBy('start_time', 'asc')
                ->paginate(20);
        }

        return view('rides.index', compact('rides', 'menu', 'pickup', 'destination'));
    }

    public function getAllRides()
    {
        $pickup = '';
        $destination = '';
        $start_day = '';
        $start_time = '';
        $menu = 'active-menu1';
        $rides = Ride::where('type', '=', 'persons')
            ->orderBy('start_day', 'asc')
            ->orderBy('start_time', 'asc')
            ->paginate(20);

        return view('rides.index', compact('rides', 'menu', 'pickup', 'destination', 'start_day', 'start_time'));
    }
}
