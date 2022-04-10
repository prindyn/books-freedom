<?php

namespace App\Services\Laragram\Laravel;

use App\Services\Laragram\TG;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\ServiceProvider;
use App\Services\Laragram\ClientException;

class LaragramServiceProvider extends ServiceProvider
{

    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = true;

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('laragram', function () {
            try {
                $tg = new TG(Config::get('services.telegram.socket'));
            } catch (ClientException $e) {
                Log::error($e->getMessage());

                return;
            }

            return $tg;
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [TG::class];
    }
}
