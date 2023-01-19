<?php

namespace App\Http\Livewire;

use App\Facades\WeatherApiFacade;
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

        if ($this->isDaily)
            $this->getDailyOverview();
        else
            $this->getWeeklyOverview();
    }

    public function getDailyOverview ()
    {
        $this->isDaily = true;

        if (!count($this->todayOverview))
            $this->todayOverview = WeatherApiFacade::getTodayOverview();
    }

    public function getWeeklyOverview ()
    {
        $this->isDaily = false;

        if (!count($this->weeklyOverview))
            $this->weeklyOverview = WeatherApiFacade::getWeeklyOverview();
    }

    public function render()
    {
        return view('livewire.weather-overview');
    }
}
