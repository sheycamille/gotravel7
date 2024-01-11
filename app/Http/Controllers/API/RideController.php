<?php

namespace App\Http\Controllers\API;

use App\Models\Momo;
use App\Models\Ride;
use App\Models\Route;
use App\Models\Images;
use App\Models\Booking;
use Illuminate\Support\Str;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Models\PaymentMethod;
use App\Models\RidePassenger;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Bmatovu\MtnMomo\Products\Collection;
use App\Http\Resources\MyRidesCollectionResource;
use App\Http\Resources\RouteCollectionResource;
use App\Http\Resources\RideResource;

use Illuminate\Support\Facades\Validator;
use GuzzleHttp\Exception\RequestException;
use App\Http\Resources\RideCollectionResource;
use Bmatovu\MtnMomo\Exceptions\CollectionRequestException;


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
            'numOfSeats' => 'required|string|min:1',
            'additionalComment' => 'string'

        ]);

        if ($validator->fails()) {
            return response(['message' => $validator->errors()], 401);
        }

        try {

            DB::transaction(function () use ($request) {

                info("starting transaction");

                $ride = Ride::create([
                    "driver_id" => auth()->user()->id,
                    "pickupLocation" => $request->pickupLocation,
                    "numOfSeats" => $request->numOfSeats,
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

                info("done creating ride");
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

                info("done creating images");

            }, 5);

            return response([
                'message' => "Ride created successfully",
                'status' => true,
            ], 200);

        } catch (\Throwable $e) {
            info($e);
            return response([
                'message' => "Something went wrong",
                'status' => false,
            ], 500);
        }
    }

    public function getRidesNextTwoDays()
    {
        $rides = Ride::whereDate('departureDay', '>=', now()->format('d/m/y'))
            ->whereDate('departureDay', '<=', now()->addDays(2)->format('d/m/y'))
            ->where('status', Ride::RIDE_STATUS_PROGRESS)
            ->where('numOfSeats', '>', 0)
            ->orderBy('departureDay', 'asc')
            ->orderBy('departureTime', 'asc')
            ->get();

        return response([
            'rides' => new RideCollectionResource($rides),
            'status' => true,
        ], 200);
    }


    public function getRidesLater()
    {
        $rides = Ride::whereDate('departureDay', '>', now()->addDays(2)->format('d/m/y'))
            ->where('status', Ride::RIDE_STATUS_PROGRESS)
            ->where('numOfSeats', '>', 0)
            ->orderBy('departureDay', 'asc')
            ->orderBy('departureTime', 'asc')
            ->get();

        return response([
            'rides' => new RideCollectionResource($rides),
            'status' => true,
        ], 200);
    }

    public function deleteRide($id)
    {

       try{

        DB::transaction(function () use ($id) {

            $ride = Ride::where('id', $id)
                ->where('driver_id', auth()->user()->id)
                ->first();


                $ride->images()->delete();
                $ride->bookings()->delete();
                $ride->delete();

        }, 5);
        
        return response([
            "message" => "Ride deleted successfully",
            "status" => true
        ]);
       } catch (\Throwable $e) {
        return response([
            "message" => "Something went wrong",
            "status" => false
        ], 500);
       }

    }

    public function cancelRide($id)
    {

        $ride = Ride::where('id', $id)
            ->where('driver_id', auth()->user()->id)
            ->first();

        if ($ride) {
            $ride->update([
                'status' => Ride::RIDE_STATUS_CANCELLED
            ]);
            $ride->save();
            return response([
                "message" => "Ride cancelled successfully",
                "status" => true
            ]);
        }

        return response([
            "message" => "Failed to cancel ride",
            "status" => true
        ], 404);
    }

    public function myRides()
    {
        $rides = $rides = Ride::where('driver_id', auth()->user()->id)
            ->select('destination', 'departure',  'status', 'departureTime', 'departureDay', 'id', 'pricePerSeat')
            ->get();

        return response([
            'rides' => new MyRidesCollectionResource($rides),
            'status' => true,
        ], 200);
    }

    public function getRideDetails($id)
    {
        return response([
            "ride" => new RideResource(Ride::find($id)),
            "status" => true
        ]);
    }

    public function myBookings()
    {
        $bookings = Booking::where('passengerId', auth()->user()->id)->get();
        return response([
            'bookings' => $bookings,
            'status' => true,
        ], 200);
    }

    public function searchRides(Request $request)
    {

        $destination = $request->query('destination');
        $departure = $request->query('departure');

        $rides = Ride::where([
            'departure' => $departure,
            'destination' => $destination,
        ])->whereDate('departureDay', '>=', now()->format('d/m/y'))
        ->orderBy('departureDay', 'asc')
        ->orderBy('departureTime', 'asc')
        ->where('numOfSeats', '>', 0)
        ->paginate(10);


        return response([
            'rides' => new RideCollectionResource($rides),
            'status' => true,
        ], 200);
        
    }

    public function momoRequestToPay(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'phoneNumber' => 'required|string',
            'payMethod' => 'required|string',
            'numOfSeats' => 'required|string',
            'rideId' => 'required|string',
            'pricePerSeat' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response(['message' => $validator->errors()], 401);
        }

        $collection = new Collection();
        $transactionId = '6581845a-ae25-447c-b7d9-7edf3b7814fb';

        $ride = Ride::find($request->rideId);
        $totalCost = $request->numOfSeats * $request->pricePerSeat;

        try {

            $referenceId = $collection->requestToPay($transactionId, $request->phoneNumber, $totalCost);

            $journey = Momo::create([
                'transaction_id' => $referenceId,
                'user_id' => auth()->user()->id,
                'ride_id' => $ride,
                'phone_number' => $request->phoneNumber,
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

            return [$join_ride, $response];
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
        return response()->json([
            'routes' => new RouteCollectionResource(Route::where('status', Route::STATUS_ACTIVE)->get()),
            'status' => true
        ], 200);
    }

    public function getPaymentMethod()
    {
        $pay_methods = PaymentMethod::get();

        return response()->json([
            'paymentmethods' => $pay_methods,
        ], 200);
    }
}
