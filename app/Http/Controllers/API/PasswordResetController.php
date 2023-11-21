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

use App\Models\API\PasswordReset;
use App\Models\User;

class PasswordResetController extends Controller
{

    public $successStatus = 200;

    public function create(Request $request)
    {

        $request->validate([
            'email' => 'required|email|string',
        ]);

        $email = $request->email;

        $code = random_int(100000, 999999);

        DB::table('password_resets')->insert([
            'email' => $email,
            'code' => $code,
            'created_at' => Carbon::now()
        ]);

        Mail::to($email)->send(new RequestPasswordReset($code));

        return response()->json([
            'message' => 'Account verification code sent!',
        ]);
    }

    public function find(Request $request)
    {
        $user = PasswordReset::where('code', $request->email)->first();

        if (!$user)
            return response()->json([
                'message' => 'Invalid code.'
            ], 404);

        return response()->json($user, $this->successStatus);
    }

    public function reset(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string|min:6',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $password_reset = PasswordReset::where('email', $request->email)->first();

        $user = User::where('email', $password_reset)->first();

        if (!$user)
            return response()->json([
                'message' => "User account not found"
            ], 404);

        User::where('email', $request->email)
            ->update(['password' => Hash::make($request->password)]);

        $password_reset->delete();

        return response()->json([
            'message' => 'password reset successfully!',
            'user' => $user,
        ]);
    }
}
