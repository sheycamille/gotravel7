<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

use Bmatovu\MtnMomo\Products\Collection;
use Bmatovu\MtnMomo\Exceptions\CollectionRequestException;

use App\Models\Ride;
use App\Models\Vehicle;
use App\Models\Momo;
use Exception;
use GuzzleHttp\Exception\RequestException;
use Throwable;

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

        return response()->json([$data], $this->successStatus);
    }

    public function getRides()
    {
    }

    public function rideDetails(Request $request, $id)
    {

        $ride = Ride::find($id);

        //$vehicle = new Vehicle();

        if (!$ride) return response()->json(['error' => 'ride not found.'], 400);

        return response()->json(['details' => $ride], $this->successStatus);
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
