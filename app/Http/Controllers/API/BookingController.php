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
            'phoneNumber' => 'required|string|max:9|min:9',
            'paymentMethod' => 'required|string',
            'numOfSeats' => 'required|integer|min:1',
            'rideId' => 'required',
            'totalCost' => 'required|numeric|min:100',
        ]);

        if ($validator->fails()) {
            return response(['message' => $validator->errors()->first()], 401);
        }

        // dummy transaction id since we are not using any payment gateway
        $transactionId = Str::random(10);
        $ride = \App\Models\Ride::find($request->rideId);
        
        if(intval($ride->num_of_seats) < intval($request->numOfSeats)){
            return response([
                'message' => "Sorry, the number of seats you requested is not available",
                'status' => false,
            ], 400); 
        }

        // if(auth()->user()->id == $ride->driver->id){
        //     return response([
        //         'message' => "You can't book your own ride",
        //         'status' => false,
        //     ], 400); 
        // }

        try{
            
            DB::transaction(function () use ($request, $transactionId) {

                $booking  = Booking::create([
                    "ride_id" => $request->rideId,
                    "passenger_id" => auth()->user()->id,
                    "totalCost" => $request->totalCost,
                    "paymentMethod" => $request->paymentMethod,
                    "numberOfSeats" => $request->numOfSeats,
                    "transactionId" => $transactionId,
                ]);
        
                $booking->ride->update([
                    'num_of_seats_left' => intval($booking->ride->num_of_seats_left) - intval($request->numOfSeats)
                ]);
                
                $booking->ride->save();
        
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
        $bookings = Booking::where('passenger_id', auth()->user()->id)
                           ->paginate(10);

        return response([
            "bookings" => new \App\Http\Resources\BookingCollectionResource($bookings),
            "status" => true
        ]);
    }

    public function cancelBooking(Request $request, $id){

        try{
            DB::transaction(function () use ($request , $id) {

                $booking = Booking::find($id);
                $booking->ride->update([
                    'num_of_seats_left' => $booking->ride->num_of_seats_left + $booking->numberOfSeats
                ]);
    
                $booking->delete();
            }, 5);

            return response([
                "message" => "Booking cancelled successfully",
                "status" => true
            ], 200);

        }catch (\Throwable $e) {
            return response([
                "message" => "Something went wrong",
                "status" => false
            ], 500);
        }

    }
}
