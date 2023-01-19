<?php

namespace App\Providers;

use App\Services\Interfaces\WeatherApiInterface;
use App\Services\WeatherForecaService;
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
        $this->app->singleton(WeatherApiInterface::class, WeatherForecaService::class);
    }
}
