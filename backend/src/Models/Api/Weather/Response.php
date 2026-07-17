<?php

namespace App\Models\Api\Weather;

use App\DTOs\AirPollutionDTO;
use App\DTOs\CityDTO;
use App\DTOs\WeatherDTO;

/**
 * Mapper de resposta do recurso Weather (como Response.php da API v2)
 */
class Response
{
    public static function current(CityDTO $city, WeatherDTO $weather): array
    {
        return [
            'location' => $city->toArray(),
            'weather' => $weather->toArray(),
        ];
    }

    public static function forecast(CityDTO $city, array $forecast): array
    {
        return [
            'location' => $city->toArray(),
            'forecast' => $forecast,
        ];
    }

    public static function airPollution(CityDTO $city, AirPollutionDTO $pollution): array
    {
        return [
            'location' => $city->toArray(),
            'airPollution' => $pollution->toArray(),
        ];
    }

    /** @param CityDTO[] $cities */
    public static function geocode(array $cities): array
    {
        return array_map(
            static fn (CityDTO $city) => $city->toArray(),
            $cities
        );
    }
}
