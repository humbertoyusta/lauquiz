<?php

namespace App\Http\Livewire;

use App\Services\WeatherForecaService;
use Livewire\Component;
use Stevebauman\Location\Facades\Location;

class WeatherOverview extends Component
{
    public array $todayOverview = [];

    public array $weeklyOverview = [];

    public string $city = '';

    public bool $isDaily = true;

    public function mount ()
    {
        $this->city = Location::get()->cityName;
    }

    public function render()
    {
        $weatherForecaService = new WeatherForecaService();

        if ($this->isDaily) {
            if (!count($this->todayOverview))
                $this->todayOverview = $weatherForecaService->getTodayOverview();
        } else {
            if (!count($this->weeklyOverview))
                $this->weeklyOverview = $weatherForecaService->getWeeklyOverview();
        }

        return view('livewire.weather-overview');
    }
}
