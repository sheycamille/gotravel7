<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\PaymentMethod;
use Illuminate\Http\Request;
use App\Http\Resources\PaymentMethodResource ;
use App\Models\Payment;

class PaymentMethodController extends Controller
{
    public function getPaymentMethod()
    {
        $payment_methods = new PaymentMethodResource::collection(PaymentMethod::all());

        return response()->json([
            'paymentmethods' => $payment_methods,
        ], 200);
    }

}

