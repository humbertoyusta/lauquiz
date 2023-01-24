<?php

namespace App\Providers;

use App\Services\Interfaces\WeatherApiInterface;
use App\Services\WeatherForecaService;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\ServiceProvider;

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
        Model::preventSilentlyDiscardingAttributes(! $this->app->isProduction());
        Model::preventsAccessingMissingAttributes(! $this->app->isProduction());

        $this->app->singleton(WeatherApiInterface::class, WeatherForecaService::class);
    }
}
