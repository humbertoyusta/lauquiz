<?php

namespace App\Services\Interfaces;

interface WeatherAPIInterface 
{
    public function getWeatherOverview(): array;
}