<?php

namespace App\Http\Controllers;

use App\Services\WeatherForecaService;
use Exception;
use Illuminate\Http\Request;

class WeatherController extends Controller
{
    private WeatherForecaService $weatherForecaService;

    public function __construct(WeatherForecaService $weatherForecaService)
    {
        $this->weatherForecaService = $weatherForecaService;
    }

    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        try {
            $weatherOverview = $this->weatherForecaService->getWeatherOverview();
        } catch (Exception $e) {
            $weatherOverview = null;
        }

        return view(
            'weather', 
            ['weatherOverview' => $weatherOverview],
        );
    }
}
