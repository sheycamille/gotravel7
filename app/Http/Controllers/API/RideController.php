<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\RouteResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

use Bmatovu\MtnMomo\Products\Collection;
use Bmatovu\MtnMomo\Exceptions\CollectionRequestException;

use App\Models\Ride;
use App\Models\Images;
use App\Models\Booking;
use App\Models\Route;
use App\Models\Vehicle;
use App\Models\Momo;
use Exception;
use GuzzleHttp\Exception\RequestException;
use Throwable;

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

    public function getRoutes(Request $request)
    {
        return RouteResource::collection(Route::withStatus('active')->get());
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

        try {
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

            return response()->json([
                'payer' => $request->all(),
                'message' => 'Request to pay successful!',
                'status' => 'true',
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

            return response()->json([
                'message' => 'success',
                'status' => 'true',
                'requestToPayResult' => $refreid

            ], 200);

        } catch (RequestException $ex) {
            return response()->json([
                'message' => 'Unable to get transaction status',
                'status' => 'false',

            ], 400);
        }

    }
}
