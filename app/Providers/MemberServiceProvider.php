<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use App\Utils\Member;

class MemberServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('member', function ($app) {
            return new Member();
        });
    }
}
