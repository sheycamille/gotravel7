<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Hash;

use App\Models\User;
use App\Mail\API\VerifyEmail;
use App\Http\Resources\UserResource;


class AuthenticationController extends Controller
{
    

    public function login(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'phone_number' => 'required|string',
            'password' => 'required|string'
        ]);

        if ($validator->fails()) {
            return response(['message' => $validator->errors()->first()], 400);
        }

        if (!(auth()->attempt(['phone_number' => $request->phone_number, 'password' => $request->password]))) {
            return response([
                'message' => "User phone or password not correct",
                'userData' => $request->all()
            ], 401);
        }
    
        $user = User::where('phone_number', $request->phone_number)->first();
        $token = $user->createToken('Gokamz')->accessToken;

        return response([
            'token' => $token,
            'user' => new UserResource($user),
            'message' => 'Login Successful',
            'status' => 'true'
        ], 200);

    }

    public function register(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'firstname' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'username' => 'required|string|max:255',
            'verifiedWith' => 'required|string',
            'phone_number' => 'sometimes|required_without:email|string|max:255|unique:users',
            'email' => 'sometimes|required_without:phone|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()->first()], 401);
        }

        $user = User::create([
            'first_name'=> $request->firstname,
            'last_name'=> $request->lastname,
            'username'=> $request->username,
            'phone_number' => $request->phone_number,
            'email'=> $request->email,
            'password'=> Hash::make($request->password),
        ]);

        $code = random_int(100000, 999999);
        if(isset($request->email) && $request->email != '') {
            User::where('email', $user->email)->update(['otp' => $code]);
            Mail::to($user->email)->send(new VerifyEmail($code, $request->first_name));
            return response([
                "message" => "Email verification sent",
                "status" => true,
            ], 200);
        } else {
            return response([
                'message' => 'Something happened, try again'
            ], 500);
        }

        if($request->verifiedWith == 'email'){
            if(isset($request->email) && $request->email != '') {
                User::where('email', $user->email)->update(['otp' => $code]);
                Mail::to($user->email)->send(new VerifyEmail($code, $request->first_name));
                return response([
                    "message" => "Email verification sent",
                    "status" => true,
                ], 200);
            } else {
                return response([
                    'message' => 'Something happened, try again'
                ], 500);
            }
        } else {

            $token =  $user->createToken('Gokamz')->accessToken;
            return response([
                'token' => $token,
                'user' => new UserResource($user),
                'message' => 'Registration Successful',
                'status' => 'true'
            ], 200);
        }
    }

    public function logout (Request $request) {
        $token = $request->user()->token();
        $token->revoke();
        $response = ['message' => 'You have been successfully logged out!'];
        return response($response);
    }


    public function emailVerify(Request $request)
    {
        info($request->all());
        $validator = Validator::make($request->all(), [
            'email' => 'required',
            'otp' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()], 401);
        }

        $user = User::where('email', $request->email)->first();

        if ($user->otp !== $request->otp) {
            return response()->json(['message' => 'Invalid Code'], 401);
        }

        $user->update(['otp' => '']);
        $user->save();
        $token =  $user->createToken('Gokamz')->accessToken;

        return response([
            'token' => $token,
            'user' => new UserResource($user),
            'message' => 'Registration Successful',
            'status' => 'true'
        ], 200);
    }

    public function resendOtp(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()], 401);
        }

        $code = random_int(100000, 999999);
        $user = User::where('email', $request->email)->first();
        info($user);
        $user->update(['otp' => $code]);
        $user->save();
        Mail::to($user->email)->send(new VerifyEmail($code, $user->first_name));

        return response([
            'message' => 'Otp code sent',
            'status' => true
        ], 200);
    }
}
