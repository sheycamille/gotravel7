<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

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
}
