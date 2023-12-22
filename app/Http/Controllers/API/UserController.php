<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

use App\Models\User;
use App\Http\Resources\UserResource;

class UserController extends Controller
{
    public function getUser()
    {
        $user = User::where('id', auth()->user()->id)->first();

        if (!$user) return response()->json(['error' => 'user not found'], 400);

        return response()->json([
            'user' => new UserResource($user),
        ], 200);
    }

    public function changePassword(Request $request)
    {
        info(auth()->user());

        $validator = Validator::make($request->all(), [
            'oldPassword' => 'string|required',
            'password' => 'string|required|min:6',
        ]);

        if ($validator->fails()) {
            return response(['message' => $validator->errors()->first()], 401);
        }

        if (!auth()->user()) return response(['message' => 'User not found'], 400);

        if (!Hash::check($request->oldPassword, auth()->user()->password)) {
            return response(['message' => 'Current password does not match'], 401);
        }

        auth()->user()->update([
            'password' => Hash::make($request->password)
        ]);

        auth()->user()->save();

        return response([
            'message' => 'Password has been reset successfully',
            'status' => true
        ], 200);
    }

    public function editProfile(Request $request){
        
        $validator = Validator::make($request->all(), [
            'departure' => 'required|string',
            'destination' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response(['message' => $validator->errors()->first()], 401);
        }


    }
}
