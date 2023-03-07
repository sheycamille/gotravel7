<?php

namespace App\Http\Responses;

use Laravel\Fortify\Contracts\LoginResponse as LoginResponseContract;
use Illuminate\Support\Facades\Auth;

class LoginResponse implements LoginResponseContract
{
    /**
     * Create an HTTP response that represents the object.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function toResponse($request)
    {
        $role = Auth::user()->type;

        switch ($role) {
            case 'administrator':
                return redirect()->intended(config('fortify.home'));
            case 'passenger':
                return redirect()->intended('/');
            default:
                return redirect('/');
        }
    }
}
