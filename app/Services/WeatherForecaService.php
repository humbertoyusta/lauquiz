<?php

namespace App\Services;

use App\Exceptions\WeatherAPIException;
use App\Services\Interfaces\WeatherAPIInterface;
use Exception;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Facades\Http;

class WeatherForecaService implements WeatherAPIInterface
{
    private array $user;

    private string $access_token = ''; 

    private string $baseURL, $city, $countryCode;

    public function __construct()
    {
        $this->user = [
            'user' => config('foreca.user'),
            'password' => config('foreca.password'),
        ];

        $this->baseURL = config('foreca.base_url');

        $this->countryCode = config('foreca.country_code');

        $this->city = config('foreca.city');
    }

    private function request(
        string $method, 
        string $url, 
        array $parameters = []
    )
    {
        $headers = [];

        if (!$this->access_token)
            $this->getToken();
            
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
        try {
            $response = Http::post($this->baseURL.'/authorize/token', $this->user);

            $this->access_token = json_decode($response)->access_token;
        } catch (Exception $e) {
            throw new WeatherAPIException('Authentication in external API failed');
        }
    }

    private function getLocationId ()
    {
        return $this->request(
            'get', 
            '/api/v1/location/search/'.$this->city, 
            ['country' => $this->countryCode],
        )->locations[0]->id;
    }

    public function getWeatherOverview (): array
    {
        $location = $this->getLocationId();

        $currentRequest = $this->request('get', '/api/v1/current/'.$location);

        $forecastRequest = $this->request('get', '/api/v1/forecast/daily/'.$location);

        return [
            'city' => $this->city,
            'temperature' => $currentRequest->current->temperature,
            'feelsLikeTemp' => $currentRequest->current->feelsLikeTemp,
            'maxTemp' => $forecastRequest->forecast[0]->maxTemp,
            'minTemp' => $forecastRequest->forecast[0]->minTemp,
        ];
    }
}