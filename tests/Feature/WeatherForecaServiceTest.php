<?php

namespace Tests\Feature;

use App\Exceptions\WeatherApiException;
use App\Exceptions\WeatherApiLoginException;
use App\Services\WeatherForecaService;
use Carbon\Carbon;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class WeatherForecaServiceTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Tests that getTodayOverview works properly, happy path :)
     */
    public function testTodayOverview ()
    {
        // Arrange
        $weatherForecaService = App::get(WeatherForecaService::class);

        // Fake forecast of next 7 days
        $forecast = [];
        for ($i = 0; $i < 7; $i ++) {
            $forecast[] = [
                'minTemp' => rand(-5, 5),
                'maxTemp' => rand(5, 15),
                'date' => Carbon::now()->addDays($i)->format('Y-m-d'),
            ];
        }

        // Fake temperature and feelsLikeTemp for today
        $temperature = rand(-1, 9);
        $feelsLikeTemp = rand(-3, 8);

        // Faking API responses
        Http::fake([
            '*/'.config('weatherapi.foreca.login_endpoint') =>
                Http::response([
                    'access_token' => 'Correct token',
                    "expires_in" => 3600,
                    "token_type" => "bearer",
                ], Response::HTTP_OK),
            '*/'.config('weatherapi.foreca.daily_forecast_endpoint').'/*' =>
                Http::response([
                    'forecast' => $forecast,
                ], Response::HTTP_OK),
            '*/'.config('weatherapi.foreca.current_endpoint').'/*' =>
                Http::response([
                    'current' => [
                        'temperature' => $temperature,
                        'feelsLikeTemp' => $feelsLikeTemp,
                    ],
                ], Response::HTTP_OK),
        ]);

        // Act
        $result = $weatherForecaService->getTodayOverview();

        // Assert
        $this->assertEquals([
            'temperature' => $temperature,
            'feelsLikeTemp' => $feelsLikeTemp,
            'minTemp' => $forecast[0]['minTemp'],
            'maxTemp' => $forecast[0]['maxTemp'],
        ], $result);
    }

    /**
     * Tests that getWeeklyOverview works properly, happy path :)
     */
    public function testWeeklyOverview ()
    {
        // Arrange
        $weatherForecaService = App::get(WeatherForecaService::class);

        // Fake forecast of next 7 days
        $forecast = [];
        for ($i = 0; $i < 7; $i ++) {
            $forecast[] = [
                'minTemp' => rand(-5, 5),
                'maxTemp' => rand(5, 15),
                'date' => Carbon::now()->addDays($i)->format('Y-m-d'),
            ];
        }

        // Faking API responses
        Http::fake([
            '*/'.config('weatherapi.foreca.login_endpoint') =>
                Http::response([
                    'access_token' => 'Correct token',
                    "expires_in" => 3600,
                    "token_type" => "bearer",
                ], Response::HTTP_OK),
            '*/'.config('weatherapi.foreca.daily_forecast_endpoint').'/*' =>
                Http::response([
                    'forecast' => $forecast,
                ], Response::HTTP_OK),
        ]);

        // Act
        $result = $weatherForecaService->getWeeklyOverview();

        // Assert
        $this->assertEquals($forecast, $result);
    }

    public function testWeeklyOverviewFail ()
    {
        // Arrange
        $weatherForecaService = App::get(WeatherForecaService::class);

        // Faking API Responses
        Http::fake([
            '*/'.config('weatherapi.foreca.login_endpoint') =>
                Http::response([
                    'access_token' => 'Correct token',
                    "expires_in" => 3600,
                    "token_type" => "bearer",
                ], Response::HTTP_OK),
            '*/'.config('weatherapi.foreca.daily_forecast_endpoint') =>
                Http::response([], Response::HTTP_REQUEST_TIMEOUT),
        ]);

        // Assert
        $this->expectException(WeatherApiException::class);

        // Act
        $weatherForecaService->getWeeklyOverview();
    }

    public function testApiLoginException()
    {
        // Arrange
        $weatherForecaService = App::get(WeatherForecaService::class);

        // Faking API responses
        Http::fake([
            '*' => Http::response([], Response::HTTP_UNAUTHORIZED),
        ]);

        // Assert
        $this->expectException(WeatherApiLoginException::class);

        // Act
        $weatherForecaService->getTodayOverview();
    }
}
