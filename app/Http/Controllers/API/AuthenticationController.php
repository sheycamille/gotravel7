<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Validator;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Http;

use App\Models\User;
use App\Mail\API\VerifyEmail;


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
            return response()->json(['error' => 'Unauthorized'], 401);
            //$user = Auth::user();
            //$success['token'] =  $user->createToken('Gokamz')->accessToken;
            //$expiration = $tokenData->token->expires_at->diffInSeconds(Carbon::now());
            //return response()->json(['success' => $success], $this->successStatus);
        }

        $tokenData = auth()->user()->createToken('Gokamz');
        $token = $tokenData->accessToken;

        return response()->json([
            'access_token' => $token,
            'token_type' => 'Bearer',
            //'expires_in' => $expiration
        ]);
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

    /** 
     * Register api 
     * 
     * @return \Illuminate\Http\Response 
     */
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'first_name' => 'required', 'string', 'max:255',
            'last_name' => 'required', 'string', 'max:255',
            'username' => 'required', 'string', 'max:255',
            'phone_number' => 'required',
            'email' => 'required', 'string', 'email', 'max:255', 'unique:users',
            'password' => 'required', 'string', 'min:8',
            'password_confirmation' => 'same:password',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 401);
        }

        $name = $request->first_name;
        $input = $request->all();
        $input['password'] = bcrypt($input['password']);
        $user = User::create($input);

        $code = random_int(100000, 999999);

        user::where('email', $user->email)->update(['otp' => $code]);

        Mail::to($user->email)->send(new VerifyEmail($code, $name));

        return response()->json($this->successStatus);

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
