<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use App\Mail\API\RequestPasswordReset;
use App\Models\User;

class PasswordResetController extends Controller
{
    public function findAccount(Request $request){
        $validator = Validator::make($request->all(), [
            'email' => 'nullable',
            'phone' => 'nullable',
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()], 401);
        }

        $user = User::where('email', $request->email)
                    ->orWhere('phone_number', $request->phone)
                    ->first();

        if(!isset($user)){
            return response()->json([
                'message'=> 'User account not found'
                ],404);
        }

        $code = random_int(100000, 999999);
        $user->update(['otp' => $code]);
        Mail::to($user->email)->send(new RequestPasswordReset($code));

        return response([
            'user'=> $user,
            'message' => 'User account exist',
            'status' => true,
        ]);

    }

    public function changePassword(Request $request){

        $validator = Validator::make($request->all(), [
            'email' => 'nullable',
            'phone' => 'nullable',
            'password' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()], 401);
        }

        $user = User::where('email', $request->email)
                    ->orWhere('phone_number', $request->phone)
                    ->first();

        $user->update([
            'password' => Hash::make($request->password),
            'otp' => ''
        ]);

        return response([
            'message'=> 'Password changed successfully',
            'status'=> true
        ], 200);

    }
}
