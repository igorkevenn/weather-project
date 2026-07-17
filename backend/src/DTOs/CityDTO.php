<?php

namespace App\DTOs;

class CityDTO
{
    public function __construct(
        private string $name,
        private float $lat,
        private float $lon,
        private string $country = '',
        private ?string $state = null
    ) {
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getLat(): float
    {
        return $this->lat;
    }

    public function getLon(): float
    {
        return $this->lon;
    }

    public function getCountry(): string
    {
        return $this->country;
    }

    public function getState(): ?string
    {
        return $this->state;
    }

    public function toArray(): array
    {
        return [
            'name' => $this->name,
            'lat' => $this->lat,
            'lon' => $this->lon,
            'country' => $this->country,
            'state' => $this->state,
        ];
    }

    public static function fromArray(array $data): self
    {
        return new self(
            name: (string) ($data['name'] ?? ''),
            lat: (float) ($data['lat'] ?? 0),
            lon: (float) ($data['lon'] ?? 0),
            country: (string) ($data['country'] ?? ''),
            state: isset($data['state']) ? (string) $data['state'] : null,
        );
    }
}
