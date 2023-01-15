<?php

namespace App\Http\Controllers;

use App\Services\WeatherForecaService;
use Exception;
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
        try {
            $weatherOverview = Cache::remember(
                'welcome.weatherOverview',
                config('app.cache_long_ttl'),
                fn() => $this->weatherForecaService->getWeatherOverview()
            );
        } catch (Exception $e) {
            $weatherOverview = null;
        }

        return view(
            'welcome', 
            ['weatherOverview' => $weatherOverview],
        );
    }
}
