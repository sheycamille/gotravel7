<?php

namespace App\Http\Controllers\API;

use Illuminate\Support\Facades\DB;
use App\Models\Booking;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class BookingController extends Controller
{
 
    public function bookYourRide(Request $request){

        $validator = Validator::make($request->all(), [
            'phoneNumber' => 'required|string',
            'payMethod' => 'required|string',
            'numOfSeats' => 'required|string',
            'rideId' => 'required|string',
            'pricePerSeat' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response(['message' => $validator->errors()->first()], 401);
        }

        DB::transaction(function () use ($request) {
            $booking  = Booking::create([
                "rideId" => $request->rideId,
                "passengerId" => auth()->user()->id,
                "feePaid" => $request->pricePerSeat,
                "paymentMethod" => $request->payMethod,
                "numberOfSeats" => $request->numOfSeats,
                "transacrtionId" => $request->transactionId,
            ]);
    
            $booking->ride->update([
                'availableSeats' => $booking->ride->availableSeats - $request->numOfSeats
            ]);
    
            return response([
                'message' => "Ride booked successfully",
                'status' => true,
            ], 200);  
        }, 5); 

        return response([
            'message' => "Something went wrong",
            'status' => false,
        ], 500);  
    }

    public function getBookings(){
        $bookings = Booking::where('passengerId', auth()->user()->id)
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

        DB::transaction(function () use ($request) {
            $booking = Booking::where('rideId', $request->rideId)
                    ->where('passengerId', auth()->user()->id)
                    ->first();
            $booking->ride->update([
                'availableSeats' => $booking->ride->availableSeats + $booking->numberOfSeats
            ]);

            $booking->delete();

            return response([
                "message" => "Booking cancelled successfully",
                "status" => true
            ]);
        }, 5);
    
        return response([
            "message" => "Something went wrong",
            "status" => false
        ], 500);
    
    }
}
