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
<<<<<<< HEAD

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

=======
    
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
>>>>>>> 72e55b9 (Trying to fix the editprofileapi)
}
