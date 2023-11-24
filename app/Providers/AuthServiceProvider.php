<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Laravel\Passport\Passport;


use Illuminate\Support\Carbon;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();
        //Passport::routes();
         Passport::tokensExpireIn(Carbon::now()->addHours(24));
        // Passport::refreshTokensExpireIn(Carbon::now()->addDays(30));
        // Passport::personalAccessTokensExpireIn(now()->addMonths(6));
        
        //Passport::hashClientSecrets();
    }
}
