<?php

namespace App\Http\Controllers\API;

use Illuminate\Support\Facades\DB;
use App\Models\Booking;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;


class BookingController extends Controller
{
 
    public function bookYourRide(Request $request){

        $validator = Validator::make($request->all(), [
            'phoneNumber' => 'required|string',
            'paymentMethod' => 'required|string',
            'numOfSeats' => 'required|string',
            'rideId' => 'required',
            'totalCost' => 'required',
        ]);

        if ($validator->fails()) {
            return response(['message' => $validator->errors()->first()], 401);
        }

        // dummy transaction id since we are not using any payment gateway
        $transactionId = Str::random(10);
        try{

            DB::transaction(function () use ($request, $transactionId) {

                $booking  = Booking::create([
                    "rideId" => $request->rideId,
                    "passengerId" => auth()->user()->id,
                    "totalCost" => $request->totalCost,
                    "paymentMethod" => $request->paymentMethod,
                    "numberOfSeats" => $request->numOfSeats,
                    "transactionId" => $transactionId,
                ]);

                if(intval($booking->ride->numOfSeats) < intval($request->numOfSeats)){
                    return response([
                        'message' => "Sorry, the number of seats you requested is not available",
                        'status' => false,
                    ], 400); 
                }
        
                $booking->ride->update([
                    'numOfSeats' => intval($booking->ride->numOfSeats) - intval($request->numOfSeats)
                ]);
        
            }, 5); 

            return response([
                'message' => "Ride booked successfully",
                'status' => true,
            ], 200); 

        }catch (\Throwable $e) {
            return response([
                'message' => "Something went wrong",
                'status' => false,
            ], 500);  
        }

    }

    public function getBookings(){
        $bookings = Booking::where('passengerId', auth()->user()->id)
                           ->paginate(10);

        return response([
            "bookings" => new \App\Http\Resources\BookingCollectionResource($bookings),
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


        try{

            DB::transaction(function () use ($request) {
                $booking = Booking::where('rideId', $request->rideId)
                        ->where('passengerId', auth()->user()->id)
                        ->first();
                $booking->ride->update([
                    'numOfSeats' => $booking->ride->numOfSeats + $booking->numberOfSeats
                ]);
    
                $booking->delete();
    
                return response([
                    "message" => "Booking cancelled successfully",
                    "status" => true
                ], 200);
            }, 5);

        }catch (\Throwable $e) {
            return response([
                "message" => "Something went wrong",
                "status" => false
            ], 500);
        }

    }
}
