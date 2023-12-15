<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Cookie;

use App\Http\Resources\RouteResource;

use Bmatovu\MtnMomo\Products\Collection;
use Bmatovu\MtnMomo\Exceptions\CollectionRequestException;

use App\Models\Ride;
use App\Models\RidePassenger;
use App\Models\Momo;
use App\Models\Route;
use GuzzleHttp\Exception\RequestException;


class RideController extends Controller
{

    public $successStatus = 200;

    public function create(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'pickup_location' => 'required|string',
            'departure' => 'required|string',
            'destination' => 'required|string',
            'start_day' => 'required|string',
            'start_time' => 'required|string',
            'car_img' => 'required',
            'car_img.*' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'number_plate' => 'required|string',
            'cost' => 'required|min:1',
            'noOfSeats' => 'min:1',
            'comments' => 'string'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 401);
        }

        $images = [];

        if ($request->hasfile('car_img')) {
            foreach ($request->car_img as $img) {
                $imageName = time() . rand(1, 99) . '.' . $img->getClientOriginalName();
                $img->move(public_path('uploads/images'), $imageName);
                $images[] = $imageName;
            }
        }

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
            'comments' => $request->comments
        );

        // $this->doValidate($data)->validate();

        DB::table('rides')->insert($data);

        return response()->json([
            'message' => 'Ride created successfully',
            'ride' => $data,
        ], $this->successStatus);
    }

    public function rideDetails($id)
    {

        $ride = Ride::find($id);

        //$vehicle = new Vehicle();

        if (!$ride) return response()->json(['error' => 'Ride not found.'], 400);

        return response()->json(['details' => $ride], $this->successStatus);
    }

    public function momoRequestToPay(Request $request, $rideId)
    {
        $collection = new Collection();
        $transactionId = '6581845a-ae25-447c-b7d9-7edf3b7814fb';

        $ride = Ride::find($rideId);

        $name = auth()->user()->username;

        $cost = $ride->cost;
        $seats = $request->num_of_seats;
        $momo = $request->phoneNumber;

        session::put("ride_num_seats", $request->input('num_of_seats'));

        //session(["pay_method" => $request->input('pay_method')]);

        $totalCost = $seats * $cost;


        try {
            $referenceId = $collection->requestToPay($transactionId, $momo, $totalCost);

            $journey = Momo::create([
                'transaction_id' => $referenceId,
                'user_id' => auth()->user()->id,
                'ride_id' => $ride,
                'phone_number' => $momo,
                'amount' => $totalCost,
                'status' => 'pending',
                'status_code' => 200
            ]);

            return response()->json([
                'payer' => $request->all(),
                'message' => 'Request to pay successful!',
                'status' => true,
                'journey' => $journey
            ], 200);
        } catch (CollectionRequestException $e) {
            return response()->json([
                'payer' => $request->all(),
                'message' => $e->getMessage(),
                'status' => 'false',

            ], 400);
        }
    }

    public function checkTransactionStatus($id)
    {

        $collection = new Collection();

        $ride_id = Ride::find($id);

        $transactionId = Momo::where('user_id', Auth::user()->id)->pluck('transaction_id')->first();

        try {

            $refreid = $collection->getTransactionStatus($transactionId);

            $status = $refreid['status'];

            if (!$status === 'SUCCESSFUL')
                return response()->json([
                    'message' => 'pending',
                    'requestToPayResult' => $refreid

                ], 400);

            $join_ride = $this->join($ride_id, session::get("ride_num_seats"));

            $response = response()->json([
                'message' => 'complete',
                'requestToPayResult' => $refreid

            ], 200);

            return [$response, $join_ride];
            
            /*if (in_array('SUCCESSFUL', array_values($arr))) {  
            } else {   
            }*/
        } catch (RequestException $ex) {
            return response()->json([
                'message' => 'Unable to get transaction status',
                'status' => 'false',

            ], 400);
        }
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
        } else {
            $cookie = Cookie::queue('transport', 'persons', 365 * 24 * 60);
            session(['transport' => 'persons']);
        }

        $pickup = '';
        $destination = '';
        $start_day = '';
        $start_time = '';
        $where = array(['type', '=', $type], ['status', '<>', 'in_process']);

        if ($request->pickup) {
            $pickup = strtolower($request->pickup);
        }
        if ($request->destination) {
            $destination = strtolower($request->destination);
        }
        if ($request->start_day) {
            $start_day = $request->start_day;
        }
        if ($request->start_time) {
            $start_time = $request->start_time;
        }

        $rides = [];

        if ($pickup != '' || $destination != '') {
            $rides = Ride::where($where)
                ->orWhere('departure', 'like', '%' . $pickup . '%')
                ->orWhere('destination', 'like', '%' . $destination . '%')
                ->orderBy('start_day', 'asc')
                ->orderBy('start_time', 'asc')
                ->take(10)
                ->get();
        }

        if (!$rides) return response()->json([
            'message' => 'Search did not match any record in our database'
        ], 400);

        return response()->json([
            'rides' => $rides,
            'status' => true
        ], 200);
    }

    public function getRoutes()
    {
        $ride_directions =  RouteResource::collection(Route::all());

        return response()->json([
            'routes' => $ride_directions,
        ], 200);
    }
}
