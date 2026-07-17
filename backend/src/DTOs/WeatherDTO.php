<?php

namespace App\DTOs;

class WeatherDTO
{
    public function __construct(
        private string $cityName,
        private string $country,
        private float $lat,
        private float $lon,
        private float $temperature,
        private float $feelsLike,
        private float $tempMin,
        private float $tempMax,
        private int $humidity,
        private int $pressure,
        private string $description,
        private string $icon,
        private float $windSpeed,
        private int $clouds,
        private int $visibility
    ) {
    }

    public function getCityName(): string
    {
        return $this->cityName;
    }

    public function getTemperature(): float
    {
        return $this->temperature;
    }

    public function getFeelsLike(): float
    {
        return $this->feelsLike;
    }

    public function getHumidity(): int
    {
        return $this->humidity;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function withCityName(string $cityName): self
    {
        $clone = clone $this;
        $clone->cityName = $cityName;

        return $clone;
    }

    public function toArray(): array
    {
        return [
            'city_name' => $this->cityName,
            'country' => $this->country,
            'lat' => $this->lat,
            'lon' => $this->lon,
            'temperature' => $this->temperature,
            'feels_like' => $this->feelsLike,
            'temp_min' => $this->tempMin,
            'temp_max' => $this->tempMax,
            'humidity' => $this->humidity,
            'pressure' => $this->pressure,
            'description' => $this->description,
            'icon' => $this->icon,
            'wind_speed' => $this->windSpeed,
            'clouds' => $this->clouds,
            'visibility' => $this->visibility,
        ];
    }

    public function toHistoryArray(): array
    {
        return [
            'city_name' => $this->cityName,
            'temperature' => $this->temperature,
            'feels_like' => $this->feelsLike,
            'humidity' => $this->humidity,
            'description' => $this->description,
        ];
    }

    public static function fromOpenWeather(array $data, float $lat, float $lon, ?string $cityName): self
    {
        $weather = $data['weather'][0] ?? [];

        $cityNameSearch = $cityName ?? ''; 

        return new self(
            cityName: (string) ($cityNameSearch ?: ($data['name'] ?? '')),
            country: (string) ($data['sys']['country'] ?? ''),
            lat: (float) ($data['coord']['lat'] ?? $lat),
            lon: (float) ($data['coord']['lon'] ?? $lon),
            temperature: (float) ($data['main']['temp'] ?? 0),
            feelsLike: (float) ($data['main']['feels_like'] ?? 0),
            tempMin: (float) ($data['main']['temp_min'] ?? 0),
            tempMax: (float) ($data['main']['temp_max'] ?? 0),
            humidity: (int) ($data['main']['humidity'] ?? 0),
            pressure: (int) ($data['main']['pressure'] ?? 0),
            description: (string) ($weather['description'] ?? ''),
            icon: (string) ($weather['icon'] ?? ''),
            windSpeed: (float) ($data['wind']['speed'] ?? 0),
            clouds: (int) ($data['clouds']['all'] ?? 0),
            visibility: (int) ($data['visibility'] ?? 0),
        );
    }
}
