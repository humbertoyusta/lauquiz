<?php

namespace App\Http\Controllers;

use App\Services\WeatherForecaService;
use Illuminate\Support\Facades\Cache;

class WelcomeController extends Controller
{
    private WeatherForecaService $weatherForecaService;

    public function __construct(WeatherForecaService $weatherForecaService)
    {
        $this->weatherForecaService = $weatherForecaService;
    }

    public function __invoke()
    {
        $weatherOverview = Cache::remember(
            'welcome.weatherOverview',
            config('app.cache_long_ttl'),
            fn() => $this->weatherForecaService->getWeatherOverview()
        );

        return view(
            'welcome', 
            ['weatherOverview' => $weatherOverview],
        );
    }
}
