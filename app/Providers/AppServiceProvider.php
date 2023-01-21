<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Validation\Rules\Password;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $rule = Password::min(8)->letters()->mixedCase();
        Password::defaults(fn () => $this->app->isProduction() ? $rule->numbers()->symbols()->uncompromised() : $rule
        );
    }
}
