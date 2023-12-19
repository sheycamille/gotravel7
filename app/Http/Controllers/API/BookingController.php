<?php

namespace App\Http\Controllers\API;

use App\Models\Booking;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class BookingController extends Controller
{
 
    public function bookRide(Request $request){
        $validator = Validator::make($request->all(), [
            'feePaid' => 'nullable|min:1',
            'paymentMethod' => 'nullable|string',
            'status' => 'nullable|string',
            'rideId' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response(['message' => $validator->errors()], 401);
        }

        Booking::create([
            "ride_id" => $request->rideId,
            "passenger_id" => auth()->user()->id,
        ]);

        return response([
            "message" => "Ride booked successfully",
            "status" => true
        ]);

    }

    public function getBookings(){
        $bookings = Booking::where('passenger_id', auth()->user()->id)
                           ->get();

        return response([
            "bookings" => $bookings,
            "status" => true
        ]);
    }

    public function cancelBooking(Request $request){
        $validator = Validator::make($request->all(), [
            'rideId' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response(['message' => $validator->errors()], 401);
        }

        $booking = Booking::where('ride_id', $request->rideId)
                          ->where('passenger_id', auth()->user()->id)
                          ->first();
        $booking->delete();

        return response([
            "message" => "Booking cancelled successfully",
            "status" => true
        ]);

    }
}
