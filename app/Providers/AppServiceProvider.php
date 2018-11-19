<?php

namespace App\Providers;

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        if( ! env('TEST_APP'))
            $this->app['request']->server->set('HTTPS', 'on');

        Schema::defaultStringLength(191);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            'App\Contracts\Repositories\HomeRepositoryInterface',
            'App\Repositories\HomeRepository'
        );
        $this->app->bind(
            'App\Contracts\Repositories\ApiRepositoryInterface',
            'App\Repositories\ApiRepository'
        );
    }
}
