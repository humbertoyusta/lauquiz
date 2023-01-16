<?php

namespace App\Http\Controllers;

use App\Services\WeatherForecaService;
use Exception;
use Illuminate\Http\Request;

class WeatherController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        return view('weather');
    }
}
