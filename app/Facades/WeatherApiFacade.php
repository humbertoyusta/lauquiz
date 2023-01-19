<?php

namespace App\Facades;

use App\Services\Interfaces\WeatherApiInterface;
use Illuminate\Support\Facades\Facade;

class WeatherApiFacade extends Facade
{
    /**
    * Get the registered name of the component.
    *
    * @return string
    */
    protected static function getFacadeAccessor(): string
    {
        return WeatherApiInterface::class;
    }
}
