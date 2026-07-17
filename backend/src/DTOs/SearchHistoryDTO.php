<?php

namespace App\DTOs;

class SearchHistoryDTO
{
    public function __construct(
        private ?int $id,
        private string $cityName,
        private float $temperature,
        private float $feelsLike,
        private int $humidity,
        private string $description,
        private ?string $searchedAt = null
    ) {
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'city_name' => $this->cityName,
            'temperature' => $this->temperature,
            'feels_like' => $this->feelsLike,
            'humidity' => $this->humidity,
            'description' => $this->description,
            'searched_at' => $this->searchedAt,
        ];
    }

    public static function fromRow(array $row): self
    {
        return new self(
            id: isset($row['id']) ? (int) $row['id'] : null,
            cityName: (string) $row['city_name'],
            temperature: (float) $row['temperature'],
            feelsLike: (float) $row['feels_like'],
            humidity: (int) $row['humidity'],
            description: (string) $row['description'],
            searchedAt: isset($row['searched_at']) ? (string) $row['searched_at'] : null,
        );
    }

    public static function fromWeather(WeatherDTO $weather): self
    {
        return new self(
            id: null,
            cityName: $weather->getCityName(),
            temperature: $weather->getTemperature(),
            feelsLike: $weather->getFeelsLike(),
            humidity: $weather->getHumidity(),
            description: $weather->getDescription(),
        );
    }
}
