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
use Exception;

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
        $request->validate([
            'pickup_location' => 'required|string',
            'departure' => 'required|string',
            'destination' => 'required|string',
            'start_day' => 'required|string',
            'start_time' => 'required|string',
            'car_img' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'car_img.*' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'number_plate' => 'required|string',
            'cost' => 'required|min:1',
            'noOfSeats' => 'min:1',
            'comments' => 'string',
        ]);

        $images = [];

        if ($request->hasfile('car_img')) {
            foreach ($request->car_img as $img) {
                $imageName = time() . rand(1, 99) . '.' . $img->getClientOriginalName();
                $img->move(public_path('uploads/images'), $imageName);
                $images[] = $imageName;
            }
        }

        //$fileName = time() . '.' . $request->car_img->();
        //$fileName = $request->car_img->getClientOriginalName();
        //$request->car_img->storeAs('public/images', $fileName);
        //$fileName = time() . '.' . $request->car_img->getClientOriginalName();
        //$request->car_img->storeAs('public/images', $fileName);

        $data = array(
            'pickup_location' => $request->input('pickup_location'),
            "departure" => $request->input('departure'),
            "destination" => $request->input('destination'),
            "start_day" => $request->input('start_day'),
            'start_time' => $request->input('start_time'),
            'cost' => $request->input('cost'),
            'driver_id' => auth()->user()->id,
            "num_of_seats" => $request->input('noOfSeats'),
            'carImages' => json_encode($images),
            'carNumberPlate' => $request->input('number_plate'),
            'comments' => $request->comments,
        );

        // $this->doValidate($data)->validate();

        DB::table('rides')->insert($data);

        $action = '<a class="m-1 btn btn-danger btn-sm text-nowrap" href="' . route("get-all-rides") . '">View Here</a>';

        if (Auth()->user()->type == 'administrator') {

            return redirect()->route('mrides')->with('success', 'Ride Created succesfully');
        } else {

            return redirect()->back()->with('success', ' Ride succesfully created ');
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

        $name = Auth::user()->username;

        $cost = $ride->cost;
        $seats = $request->num_of_seats;
        $momo = $request->momo_number;

        session(["ride_num_seats" => $request->input('num_of_seats')]);

        $totalCost = $seats * $cost;

        $referenceId = $collection->requestToPay($transactionId, $momo, $totalCost);

        $journey = Momo::create([
            'transaction_id' => $referenceId,
            'user_id' => Auth::user()->id,
            'ride_id' => $ride,
            'phone_number' => $momo,
            'amount' => $totalCost,
            'status' => 'pending',
            'status_code' => 200
        ]);

        return response()->json(['success' => true, 'message' => " Hello, $name. You're about to make a payment of  $totalCost XAF to Travel Z. please be patient while we process the payment. Once you verify the payment, click on: "], 200);

        //return response()->json(['success' => false, 'message' => 'Something went wrong, try again later.'], 422);
    }

    public function checkTransactionStatus($id)
    {

        $collection = new Collection();

        $ride_id = Ride::find($id);

        $transId = Momo::where('user_id', Auth::user()->id)->pluck('transaction_id')->first();

        $refreid = $collection->getTransactionStatus($transId);

        return $this->join($ride_id, session("ride_num_seats"));
    }


    public function join($ride_id, $seats)
    {
        //dd($ride_id, $seats);

        if ($ride_id->num_of_seats_left == null) {

            $num_of_seat = $ride_id->num_of_seats - $seats;
            $ride_id->num_of_seats_left = $num_of_seat;
            $ride_id->save();
            //dd($ride);
        } else {

            $seats_left = $ride_id->num_of_seats_left - $seats;
            $ride_id->num_of_seats_left = $seats_left;
            $ride_id->save();
        }

        $journey = RidePassenger::create([
            'ride_id' => $ride_id,
            'passenger_id' => Auth::user()->id,
            'num_of_seats' => $seats,
            'status' => 'in_process',
            'paid' => 'completed',
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
