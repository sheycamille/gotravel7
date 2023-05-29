<?php

namespace App\Providers;

use App\Actions\Fortify\CreateNewUser;
use App\Actions\Fortify\ResetUserPassword;
use App\Actions\Fortify\UpdateUserPassword;
use App\Actions\Fortify\UpdateUserProfileInformation;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;
use Laravel\Fortify\Fortify;
use Laravel\Fortify\Contracts\LoginResponse;
use Illuminate\Support\Facades\Auth;


class FortifyServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
       $this->app->instance(LoginResponse::class, new class implements LoginResponse {
        public function toResponse($request)
        {
          $type = Auth::user()->type;

            switch ($type) {
            case 'administrator':
              return redirect('/admin/home');
                break;
            case 'passenger':
                return redirect()->route('user.dashboard');

                break;
            case 'driver':
                return redirect()->route('user.dashboard');
                break;

            default:
                //return redirect()->route('welcome');

            break;
            }  
          
        }
    });
    }

    /**
     * Register the response bindings.
     *
     * @return void
     */
    protected function registerResponseBindings()
    {
        //$this->app->singleton(LoginResponseContract::class, LoginResponse::class);
        
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Fortify::createUsersUsing(CreateNewUser::class);
        Fortify::updateUserProfileInformationUsing(UpdateUserProfileInformation::class);
        Fortify::updateUserPasswordsUsing(UpdateUserPassword::class);
        Fortify::resetUserPasswordsUsing(ResetUserPassword::class);

        RateLimiter::for('login', function (Request $request) {
            $email = (string) $request->email;

            return Limit::perMinute(5)->by($email.$request->ip());
        });

        RateLimiter::for('two-factor', function (Request $request) {
            return Limit::perMinute(5)->by($request->session()->get('login.id'));
        });
    }
}
