<?php

namespace App\Services\Interfaces;

interface WeatherApiInterface
{
    public function getTodayOverview(): array;

    public function getWeeklyOverview(): array;
}
