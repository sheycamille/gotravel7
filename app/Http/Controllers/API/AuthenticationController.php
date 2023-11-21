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
    public $successStatus = 200;
    /** 
     * login api 
     * 
     * @return \Illuminate\Http\Response 
     */
    public function login(Request $request)
    {
        $credentials = $request->only(['email', 'password']);
        $validator = Validator::make($credentials, [
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        if (!auth()->attempt($credentials)) {
            return response()->json(['error' => 'User credentials not correct'], 401);
        }
    
        $user = User::where('email', $request->email)->first();
        $token = $user->createToken('Gokamz')->accessToken;

        return response()->json([
            'token' => $token,
            'user' => new UserResource($user),
            'message' => 'Login Successful',
            'status' => 'true'
        ], 200);
    }

    public function loginGrant(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        //$baseUrl = url('/');
        $response = Http::post("http://127.0.0.1:8000/api/oauth/token", [
            'username' => $request->email,
            'password' => $request->password,
            'client_id' => config('passport.password_grant_client.id'),
            'client_secret' => config('passport.password_grant_client.secret'),
            'grant_type' => 'password',
            'scope' => '',
        ]);

        $result = json_decode($response->getBody(), true);
        if (!$response->ok()) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
        return response()->json($result);
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'username' => 'required|string|max:255',
            'phone_number' => 'required',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()->first()], 401);
        }

        $name = $request->first_name;

        $user = User::create([
            'first_name'=> $request->first_name,
            'last_name'=> $request->last_name,
            'username'=> $request->username,
            'phone_number' => $request->phone_number,
            'email'=> $request->email,
            'password'=> Hash::make($request->password),
        ]);

        $code = random_int(100000, 999999);

        User::where('email', $user->email)->update(['otp' => $code]);

        Mail::to($user->email)->send(new VerifyEmail($code, $name));

        return response([
            "message" => "Email verification sent",
            "status" => "true",
        ], 200);

    }


    public function emailVerify(Request $request)
    {
        $validator = Validator::make($request->all(), ['otp' => 'required']);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 401);
        }

        $user = User::where('otp', $request->otp)->first();

        if(!$user) 
        return response()->json(['message' => 'Invalid Code'], 404);

        $success['token'] =  $user->createToken('Gokamz')->accessToken;
        $success['email'] = $user->email;
        //$success['code'] =  $code;
        return response()->json(['success' => $success], $this->successStatus);
    }
}
