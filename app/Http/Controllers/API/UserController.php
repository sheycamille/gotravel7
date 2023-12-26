<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

use App\Http\Resources\UserResource;

class UserController extends Controller
{
    public function getUser()
    {
        return response([
            'user' => new UserResource(auth()->user()),
        ], 200);
    }

    public function changePassword(Request $request)
    {
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

        return response([
            'message' => 'Password has been reset successfully',
            'status' => true
        ], 200);
    }


    public function update(Request $request)
    {
        $user = auth()->user();

        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        $user->update([
            'first_name' => $request->first_name ?? $user->first_name,
            'last_name' => $request->last_name ?? $user->last_name,
            'username' => $request->username ?? $user->username,  
            'dob' => $request->dob ?? $user->dob,
            'gender' => $request->gender == 1 ? \App\Models\User::GENDER_MALE : \App\Models\User::GENDER_FEMALE ?? $user->gender,
            'language' => $request->language  == 'en' ?  \App\Models\User::LANG_EN : \App\Models\User::LANG_FR ?? $user->language,
            'address' => $request->address ?? $user->address,
            'nic' => $request->nic ?? $user->nic,
        ]);

        return response([
            'message' => 'User updated successfully', 
            'user' => $user,
            "status" => true
        ], 200);
    }


}
