<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\RouteResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Cookie;


use Bmatovu\MtnMomo\Products\Collection;
use Bmatovu\MtnMomo\Exceptions\CollectionRequestException;

use App\Models\Ride;
use App\Models\Images;
use App\Models\Booking;
use App\Models\Route;
use App\Models\RidePassenger;
use App\Models\Momo;
use GuzzleHttp\Exception\RequestException;


class RideController extends Controller
{

    public function create(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'pickupLocation' => 'required|string',
            'departure' => 'required|string',
            'destination' => 'required|string',
            'departureDay' => 'required|string',
            'departureTime' => 'required|string',
            'carModel' => 'required|string',
            'carImages' => 'required|array',
            'carNumberPlate' => 'required|nullable',
            'pricePerSeat' => 'required|min:1',
            'availableSeats' => 'required|string|min:1',
            'additionalComment' => 'string'

        ]);

        if ($validator->fails()) {
            return response(['message' => $validator->errors()], 401);
        }

        $ride = Ride::create([
            "driver_id" => auth()->user()->id,
            "pickupLocation" => $request->pickupLocation,
            "availableSeats" => $request->availableSeats,
            "typeOfContent" => Ride::RIDE_TYPE_PERSONS,
            "status" => Ride::RIDE_STATUS_PROGRESS,
            "departure" => $request->departure,
            "destination" => $request->destination,
            "departureDay" => $request->departureDay,
            "departureTime" => $request->departureTime,
            "comments" => $request->additionalComment,
            "pricePerSeat" => $request->pricePerSeat,
            "carModel" => $request->carModel,
            "carNumberPlate" => $request->carNumberPlate,
        
        ]);


        if ($request->hasFile('carImages')) {
            $images = $request->file('carImages');
            foreach ($images as $image) {
                $file_name = (string) Str::uuid()->toString() . time() . '.png';
                $path = Storage::putFileAs('ride_images', $image, $file_name);
        
                Images::create([
                    'owner_id' => $ride->id,
                    'url' => $path,
                ]);
            }
        }
        

        return response([
            'message' => "Ride created successfully",
            'status' => true,
        ], 200);

    }

    public function getRidesNextTwoDays()
    {
        $rides = Ride::whereDate('departureDay', '>=', now()->format('Y-m-d'))
                     ->whereDate('departureDay', '<=', now()->addDays(2)->format('Y-m-d'))
                     ->get();
        return response([
            'rides' => $rides,
            'status' => true,
        ], 200);

    }

    public function getRidesLater()
    {
        $rides = Ride::whereDate('departureDay', '>', now()->addDays(2)->format('Y-m-d'))
                ->get();

        return response([
            'rides' => $rides,
            'status' => true,
        ], 200);

    }

    public function deleteRide(Request $request){
        $validator = Validator::make($request->all(), [
            'rideId' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response(['message' => $validator->errors()], 401);
        }

        $ride = Ride::where('id', $request->rideId)
                    ->where('driver_id', auth()->user()->id)
                    ->first();
        $ride->delete();

        return response([
            "message" => "Ride deleted successfully",
            "status" => true
        ]);

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

