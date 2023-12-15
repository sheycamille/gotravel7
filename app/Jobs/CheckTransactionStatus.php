<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class CheckTransactionStatus implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
    
        $collection = new Collection();

        $ride_id = Ride::find($id);

        $transactionId = Momo::where('user_id', Auth::user()->id)->pluck('transaction_id')->first();

        //return response()->json(session('pay_method'));

        try {

            $refreid = $collection->getTransactionStatus($transactionId);

            //$join_ride = $this->join($ride_id, session::get("ride_num_seats"));

            $response = response()->json([
                'message' => 'success',
                'status' => true,
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
    
}
