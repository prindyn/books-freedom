<?php

namespace App\Providers;

use BotMan\BotMan\BotMan;
use Illuminate\Support\ServiceProvider;

class BotManServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(BotMan::class, function ($app) {

            return $this->app->make('botman');
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
