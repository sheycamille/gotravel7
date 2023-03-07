<?php

namespace App\Actions\Fortify;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\CreatesNewUsers;
use Laravel\Jetstream\Jetstream;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    /**
     * Validate and create a newly registered user.
     *
     * @param  array<string, string>  $input
     */
    public function create(array $input): User
    {
        Validator::make($input, [
            'firstname' => 'required', 'string', 'max:255',
            'lastname' => 'required', 'string', 'max:255',
            'username' => 'required', 'string', 'max:255',
            'phone_number' => 'required',
            'email' => 'required', 'string', 'email', 'max:255', 'unique:users',
            'password' => 'required', 'string', 'min:8', 
            'password_confirmation' => 'same:password',
           // 'password' => $this->passwordRules(),
           // 'terms' => Jetstream::hasTermsAndPrivacyPolicyFeature() ? ['accepted', 'required'] : '',
        ])->validate();

        return User::create([
            'first_name' => $input['firstname'],
            'last_name' => $input['lastname'],
            'phone_number' =>$input['phone_number'],
            'username' =>$input['username'],
            'email' =>$input['email'],
            'password' => Hash::make($input['password']),
        ]);
    }
}
