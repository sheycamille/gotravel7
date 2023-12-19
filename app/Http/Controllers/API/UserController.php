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
    
        if (!$user) return response()->json([
            'message' => 'User not found' ], 400);
                
        $validator = Validator::make($request->all(), [
            'Username' => 'string',
            'email' => 'string',
            'phone_number' => 'string',
            'type' => 'string',
            'gender' => 'string',
            'language' => 'string',
            'primary_address' => 'string',
            'nic' => 'string',
            // 'avatar' => 'string|required',
            
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()], 401);
        }
    
        // redirect()->back()->with('message', 'User not found');

        //$avta = $imageName = time() . '.' . $request->avatar->getClientOriginalName();

        // Public Folder
        //$request->avatar->move(public_path('uploads/avatars'), $imageName);

        $user->update([
            'username' => $request->username,
            'email' => $request->email,
            'phone_number' => $request->phone_number,
            'type' => $request->type,
            'gender' => $request->gender,
            'language' => $request->language,
            'primary_address' => $request->primary_address,
            'nic' => $request->nic,
            //'avatar' => $avta
        ]);


    }
}
