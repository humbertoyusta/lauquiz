<?php

namespace App\Http\Controllers;

use App\Services\WeatherForecaService;
use Exception;
use Illuminate\Support\Facades\Cache;

class WelcomeController extends Controller
{
    public function __invoke()
    {
        return view('welcome');
    }
}
