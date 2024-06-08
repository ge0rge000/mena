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
use App\Models\User;

class FortifyServiceProvider extends ServiceProvider
{
    public function register()
    {
        //
    }

    public function boot()
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

        // Customize authentication logic
        Fortify::authenticateUsing(function (Request $request) {
            $user = User::where('mobile_phone', $request->mobile_phone)->first();

            if ($user) {
                // Add your custom authentication logic here if needed
                // For example, you might want to verify an OTP instead of a password
                // if (Hash::check($request->password, $user->password)) {
                    return $user;
                // }
            }

            // If authentication fails
            return null;
        });

        // Customize the login validation
        Fortify::loginView(function () {
            return view('auth.login');
        });

        Fortify::authenticateThrough(function (Request $request) {
            return array_filter([
                function (Request $request) {
                    Validator::make($request->all(), [
                        'mobile_phone' => ['required', 'string'],
                        // Remove the password validation rule
                    ])->validate();

                    return true;
                },
                Fortify::ensureLoginIsNotRateLimited(),
                Fortify::attemptToAuthenticate(),
                Fortify::ensureTwoFactorAuthenticationIsEnabled(),
            ]);
        });
    }
}
