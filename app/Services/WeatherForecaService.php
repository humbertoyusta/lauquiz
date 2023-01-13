<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class WeatherForecaService
{
    private array $user = [
        'user' => 'humbertoyusta02',
        'password' => 'KcVvTHvJau9q',
    ];

    private string $access_token = ''; 

    private string $baseURL = 'https://pfa.foreca.com';

    private string $city = 'Barcelona';

    private string $countryCode = 'es';

    private function request(
        string $method, 
        string $url, 
        array $parameters = [], 
        bool $shouldGetToken = false
    )
    {
        $headers = [];

        if (!$shouldGetToken && !$this->access_token)
            $this->access_token = $this->getToken();
            
        $headers['Authorization'] = 'Bearer '.$this->access_token;

        if ($method == 'post') {
            $request = Http::withHeaders($headers)->post($this->baseURL.$url, $parameters);
        } else {
            $request = Http::withHeaders($headers)->get($this->baseURL.$url, $parameters);
        }

        return json_decode($request->body());
    }

    private function getToken () 
    {
        return $this->request('post', '/authorize/token', $this->user, true)->access_token;
    }

    private function getLocationId ()
    {
        return $this->request(
            'get', 
            '/api/v1/location/search/'.$this->city, 
            ['country' => $this->countryCode],
        )->locations[0]->id;
    }

    public function getWeatherOverview () 
    {
        $location = $this->getLocationId();

        $currentRequest = $this->request('get', '/api/v1/current/'.$location);

        $forecastRequest = $this->request('get', '/api/v1/forecast/daily/'.$location);

        return [
            'temperature' => $currentRequest->current->temperature,
            'feelsLikeTemp' => $currentRequest->current->feelsLikeTemp,
            'maxTemp' => $forecastRequest->forecast[0]->maxTemp,
            'minTemp' => $forecastRequest->forecast[0]->minTemp,
        ];
    }
}