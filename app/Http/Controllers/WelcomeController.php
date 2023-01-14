<?php

namespace App\Http\Controllers;

use App\Services\WeatherForecaService;

class WelcomeController extends Controller
{
    private WeatherForecaService $weatherForecaService;

    public function __construct(WeatherForecaService $weatherForecaService)
    {
        $this->weatherForecaService = $weatherForecaService;
    }

    public function __invoke()
    {
        return view(
            'welcome', 
            ['weatherOverview' => $this->weatherForecaService->getWeatherOverview()]
        );
    }
}
