<?php

namespace App\Interfaces;

use App\DTOs\AirPollutionDTO;
use App\DTOs\CityDTO;
use App\DTOs\WeatherDTO;

interface OpenWeatherServiceInterface
{
    /** @return CityDTO[] */
    public function geocode(string $query, int $limit = 5): array;

    public function getCurrentWeather(float $lat, float $lon, ?string $nameCity): WeatherDTO;

    public function getForecast(float $lat, float $lon): array;

    public function getAirPollution(float $lat, float $lon): AirPollutionDTO;
}
