<?php

namespace App\Services\Interfaces;

interface WeatherAPIInterface 
{
    public function getTodayOverview(): array;

    public function getWeeklyOverview(): array;
}