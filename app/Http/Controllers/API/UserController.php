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
        $user = auth()->user();

        $validator = Validator::make($request->all(), [
            'current_pass' => 'string|required',
            'newpass' => 'string|required|min:6',
            'confirm_newpass' => 'string|required|same:newpass'
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()], 401);
        }
        $newpass = $request->newpass;
        $cnewpass = $request->cnewpass;

        if (!$user) return response()->json(['message' => 'User not found'], 400);

        if (!Hash::check($request->current_pass, $user->password)) {
            return response()->json(['message' => 'Current password does not match'], 401);
        }

        $user->password = Hash::make($newpass);
        $user->save();

        return response()->json([
            'message' => 'Password has been reset successfully',
        ], 200);
    }

    // public function update(Request $request)
    // {
    //     $user = auth()->user();
    
    //     if (!$user) return response()->json([
    //         'message' => 'User not found' ], 400);
                
    //     $validator = Validator::make($request->all(), [
    //         'Username' => 'string',
    //         'email' => 'string',
    //         'phone_number' => 'string',
    //         'type' => 'string',
    //         'gender' => 'string',
    //         'language' => 'string',
    //         'primary_address' => 'string',
    //         'nic' => 'string',
            // 'avatar' => 'string|required',
            
        // ]);

        // if ($validator->fails()) {
        //     return response()->json(['message' => $validator->errors()], 401);
        // }
    
        // redirect()->back()->with('message', 'User not found');

        //$avta = $imageName = time() . '.' . $request->avatar->getClientOriginalName();

        // Public Folder
        //$request->avatar->move(public_path('uploads/avatars'), $imageName);

        // $user->update([
        //     'username' => $request->username,
        //     'email' => $request->email,
        //     'phone_number' => $request->phone_number,
        //     'type' => $request->type,
        //     'gender' => $request->gender,
        //     'language' => $request->language,
        //     'primary_address' => $request->primary_address,
        //     'nic' => $request->nic,
        //     //'avatar' => $avta
        // ]);



    // 
    

    public function update(Request $request)
{
    $user = auth()->user();

    if (!$user) {
        return response()->json(['message' => 'User not found'], 404);
    }

    // $validatedData = $request->validate([
    //     'username' => 'required',
    //     'first_name' => 'required',
    //     'last_name' => 'required',
    //     'email' => 'required|email',
    //     'phone_number' => 'required',
    // ]);

    // $user->update($validatedData);
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

    return response()->json(['message' => 'User updated successfully', 'user' => $user], 200);
}
}
