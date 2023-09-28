<?php

namespace App\Http\Controllers;

use App\Models\Momo;
use App\Models\Ride;
use App\Models\RidePassenger;
use App\Models\User;
use App\Models\Vehicle;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

use Illuminate\Support\Carbon;

use Bmatovu\MtnMomo\Products\Collection;
use Bmatovu\MtnMomo\Exceptions\CollectionRequestException;

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
        $type = new Vehicle();
        $cartype =  $type->getvehicleType();

        if ($type == 'goods') {
            $cookie = Cookie::queue('transport', 'goods', 365 * 24 * 60);
            session(['transport' => 'goods']);
            $menu = 'active-menu2';
        } else {
            $cookie = Cookie::queue('transport', 'persons', 365 * 24 * 60);
            session(['transport' => 'persons']);
            $menu = 'active-menu1';
        }

        return view('rides.create', compact('menu', 'cartype'));
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
            "num_of_seats" => $num_seats,
            "num_of_seats_left" => $num_seats
        );

        // $this->doValidate($data)->validate();

        DB::table('rides')->insert($data);

        if (Auth()->user()->type == 'administrator') {

            return redirect()->route('mrides')->with('success', 'Ride Created succesfully');
        } else {

            return redirect()->route('get-all-rides')->with('success', 'Ride successfully created');
        }
    }

    public function details(Request $request, $id)
    {

        $ride = Ride::find($id);

        $vehicle = new Vehicle();

        if (!$ride) return redirect()->back()->with('message', 'Ride not found');

        return view('rides.details', compact('ride', 'vehicle'));
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
        $user = Auth::user();

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

            return view('user.dashboard', compact('ride', 'user'))->with('success', 'Ride successfully updated');
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


    public function momoRequestToPay(Request $request, $id)
    {
        $collection = new Collection();
        $transactionId = '6581845a-ae25-447c-b7d9-7edf3b7814fb';

        $ride = Ride::find($id);
        
        $cost = $ride->cost;
        $seats = $request->num_of_seats;
        $momo = $request->momo_number;

        $totalCost = $seats * $cost;

        $referenceId = $collection->requestToPay($transactionId, $momo, $totalCost);

        $journey = Momo::create([
            'transaction_id' => $referenceId,
            'user_id' => Auth::user()->id,
            'ride_id' => $ride,
            'phone_number' => $momo,
            'amount' => $totalCost,
            'status' => ''
        ]);

        if($journey){
            return response()->json(['success' => true, 'message' => "You're about to make a payment of  $referenceId XAF to Travel Z, please dial *126# on your mobile phone to confirm this payment. Once done click "], 200);
        }else{
            return response()->json(['success' => false, 'message' => 'error'], 422);
        }

    }

    public function getTransactionStatus(){

        $collection = new Collection();
        //$ride = Ride::find($id);
    
        $transId = Momo::where('user_id', Auth::user()->id)->pluck('transaction_id')->first();

        $refreid = $collection->getTransactionStatus($transId);

        //return $this->join(Request $request, $id);

        dd($refreid);
    }


    public function join(Request $request, $id)
    {

        $ride = Ride::find($id);

        if (!$ride) return redirect()->back()->with('message', 'Ride not found');

        $cost = $ride->cost;
        $seats = $request->num_of_seats;
        $momo = $request->momoNumber;

        $test = $seats * $cost;

        if ($ride->num_of_seats_left == null) {

            $num_of_seat = $ride->num_of_seats - $seats;
            $ride->num_of_seats_left = $num_of_seat;
            $ride->save();
            //dd($ride);
        } else {

            $seats_left = $ride->num_of_seats_left - $seats;
            $ride->num_of_seats_left = $seats_left;
            $ride->save();
        }

        $journey = RidePassenger::create([
            'ride_id' => $id,
            'passenger_id' => Auth::user()->id,
            'num_of_seats' => $seats,
            'status' => 'in_process',
            'paid' => 'pending',
            'type' => 'persons'
        ]);

        return redirect()->back()->with('success', 'Successfully joined journey');
    }


    public function cancelBooking($id)
    {
        $ride_passenger = RidePassenger::find($id)->forceDelete();

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
        $where = array(['type', '=', $type], ['status', '<>', 'in_process']);

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
            ->orderBy('start_day', 'desc')
            ->orderBy('start_time', 'asc')
            ->paginate(5);

        return view('rides.index', compact('rides', 'menu', 'pickup', 'destination', 'start_day', 'start_time'));
    }
}
