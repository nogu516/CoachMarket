<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Laravel\Fortify\Fortify;
use App\Actions\Fortify\CreateNewUser;
use App\Actions\Fortify\UpdateUserProfileInformation;
use App\Actions\Fortify\UpdateUserPassword;
use App\Actions\Fortify\ResetUserPassword;


class FortifyServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(
            \Laravel\Fortify\Contracts\CreatesNewUsers::class,
            CreateNewUser::class
        );

        $this->app->singleton(
            \Laravel\Fortify\Contracts\UpdatesUserProfileInformation::class,
            UpdateUserProfileInformation::class
        );

        $this->app->singleton(
            \Laravel\Fortify\Contracts\UpdatesUserPasswords::class,
            UpdateUserPassword::class
        );

        $this->app->singleton(
            \Laravel\Fortify\Contracts\ResetsUserPasswords::class,
            ResetUserPassword::class
        );
    }


    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        Fortify::loginView(fn() => view('auth.login'));
        Fortify::registerView(fn() => view('auth.register'));
        Fortify::requestPasswordResetLinkView(fn() => view('auth.passwords.email'));
        Fortify::resetPasswordView(fn($request) => view('auth.passwords.reset', ['request' => $request]));
    }
}
