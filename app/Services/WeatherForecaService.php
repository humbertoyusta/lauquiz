<?php

namespace App\Services;

use App\Exceptions\WeatherAPIException;
use App\Services\Interfaces\WeatherAPIInterface;
use Exception;
use Stevebauman\Location\Facades\Location;
use Illuminate\Support\Facades\Http;

class WeatherForecaService implements WeatherAPIInterface
{
    private array $user;

    private string $access_token = '';

    private string $baseUrl, $loginEndpoint, $currentEndpoint, $dailyForecastEndpoint;

    public function __construct()
    {
        $this->user = [
            'user' => config('weatherapi.foreca.user'),
            'password' => config('weatherapi.foreca.password'),
        ];

        $this->baseUrl = config('weatherapi.foreca.base_url');

        $this->loginEndpoint = config('weatherapi.foreca.login_endpoint');

        $this->currentEndpoint = config('weatherapi.foreca.current_endpoint');

        $this->dailyForecastEndpoint = config('weatherapi.foreca.daily_forecast_endpoint');
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
            $request = Http::withHeaders($headers)->post($this->baseUrl.'/'.$url, $parameters);
        } else {
            $request = Http::withHeaders($headers)->get($this->baseUrl.'/'.$url, $parameters);
        }

        return json_decode($request->body());
    }

    private function getToken ()
    {
        try {
            $response = Http::post($this->baseUrl.'/'.$this->loginEndpoint, $this->user);

            $this->access_token = json_decode($response)->access_token;
        } catch (Exception $e) {
            throw new WeatherAPIException('Authentication in external API failed');
        }
    }

    public function getTodayOverview (): array
    {
        $location = Location::get();

        $currentRequest = $this->request('get', $this->currentEndpoint.'/'.$location->longitude.','.$location->latitude);

        $forecastRequest = $this->request('get', $this->dailyForecastEndpoint.'/'.$location->longitude.','.$location->latitude);

        return [
            'temperature' => $currentRequest->current->temperature,
            'feelsLikeTemp' => $currentRequest->current->feelsLikeTemp,
            'maxTemp' => $forecastRequest->forecast[0]->maxTemp,
            'minTemp' => $forecastRequest->forecast[0]->minTemp,
        ];
    }

    public function getWeeklyOverview (): array
    {
        $location = Location::get();

        $forecastRequest = $this->request(
            'get',
            $this->dailyForecastEndpoint.'/'.$location->longitude.','.$location->latitude
        );

        return collect($forecastRequest->forecast)
            ->map(
                fn($forecast) =>
                    collect($forecast)->only(['maxTemp', 'minTemp', 'date'])
            )
            ->toArray();
    }
}
