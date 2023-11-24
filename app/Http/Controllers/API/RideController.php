<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

use App\Models\Ride;
use App\Models\Vehicle;

class RideController extends Controller
{

    public $successStatus = 200;

    public function create(Request $request) {

        $validator = Validator::make($request->all(), [
            'pickup_location' => 'required|string',
            'departure' => 'required|string',
            'destination' => 'required|string',
            'start_day' => 'required|string',
            'start_time' => 'required|string',
            'cost' => 'required|min:1',
            'noOfSeats' => 'min:1'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 401);
        }

        $data = array(
            'pickup_location' => $request->input('pickup_location'),
            "departure" => $request->input('departure'),
            "destination" => $request->input('destination'),
            "start_day" => $request->input('start_day'),
            'start_time' => $request->input('start_time'),
            'cost' => $request->input('cost'),
            'driver_id' => Auth::user()->id,
            "num_of_seats" => $request->input('num_of_seats'),
        );

        // $this->doValidate($data)->validate();

        DB::table('rides')->insert($data);

        return response()->json([$data], $this->successStatus);
    }

    public function details(Request $request, $id)
    {

        $ride = Ride::find($id);

        $vehicle = new Vehicle();

        if (!$ride) return response()->json(['error' => 'Ride not found.'], 400);

        return response()->json(['details' => $ride], $this->successStatus);

    
    }
}
