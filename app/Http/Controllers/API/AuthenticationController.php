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
            'input' => 'nullable',
            'password' => 'required'
        ]);


        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()->first()], 401);
        }

        if (!auth()->attempt($request->all())) {
            return response()->json(['error' => 'User credentials not correct'], 401);
        }
    
        $user = User::where(['email' => $request->input])
                    ->orWhere(['phone_number' => $request->input])
                    ->first();

        // $user = User::where(function ($query) use ($request) {
        //     if ($request->email) {
        //         $query->where('email', $request->email);
        //     }
        //     if ($request->phone) {
        //         $query->orWhere('phone_number', $request->phone);
        //     }
        // })->first();
        


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
            'phone' => 'sometimes|required_without:email|string|max:255|unique:users',
            'email' => 'sometimes|required_without:phone|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()->first()], 401);
        }

        $name = $request->first_name;

        $user = User::create([
            'first_name'=> $request->firstname,
            'last_name'=> $request->lastname,
            'username'=> $request->username,
            'phone_number' => $request->phone,
            'email'=> $request->email,
            'password'=> Hash::make($request->password),
        ]);

        $code = random_int(100000, 999999);
        if(isset($request->email) && $request->email != '') {
            User::where('phone_number', $user->phone)->update(['otp' => $code]);
            Mail::to($user->email)->send(new VerifyEmail($code, $name));
            return response([
                "message" => "Email verification sent",
                "status" => true,
            ], 200);
        }else{
            return response([
                'message' => 'Something happened, try again'
            ], 500);
        }

        if($request->verifiedWith == 'email'){
            if(isset($request->email) && $request->email != '') {
                User::where('phone_number', $user->phone)->update(['otp' => $code]);
                Mail::to($user->email)->send(new VerifyEmail($code, $name));
                return response([
                    "message" => "Email verification sent",
                    "status" => true,
                ], 200);
            }else{
                return response([
                    'message' => 'Something happened, try again'
                ], 500);
            }
        }else{

            $token =  $user->createToken('Gokamz')->accessToken;
            return response([
                'token' => $token,
                'user' => new UserResource($user),
                'message' => 'Registration Successful',
                'status' => 'true'
            ], 200);
        }    

    }

    // public function logout (Request $request) {
    //     $token = $request->user()->token();
    //     $token->revoke();
    //     $response = ['message' => 'You have been successfully logged out!'];
    //     return response($response, $this->successStatus);
    // }


    public function emailVerify(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required',
            'otp' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()], 401);
        }

        $user = User::where(['email' => $request->email])->first();

        if($user->otp !== $request->otp){
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

    public function resendOtp(Request $request){
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
