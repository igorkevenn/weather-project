<?php

namespace App\DTOs;

class AirPollutionDTO
{
    public function __construct(
        private int $aqi,
        private string $aqiLabel,
        private array $components
    ) {
    }

    public function toArray(): array
    {
        return [
            'aqi' => $this->aqi,
            'aqi_label' => $this->aqiLabel,
            'components' => $this->components,
        ];
    }

    public static function fromOpenWeather(array $data): self
    {
        $item = $data['list'][0] ?? [];
        $aqi = (int) ($item['main']['aqi'] ?? 0);

        return new self(
            aqi: $aqi,
            aqiLabel: match ($aqi) {
                1 => 'Bom',
                2 => 'Razoável',
                3 => 'Moderado',
                4 => 'Ruim',
                5 => 'Muito ruim',
                default => 'Desconhecido',
            },
            components: [
                'co' => (float) ($item['components']['co'] ?? 0),
                'no' => (float) ($item['components']['no'] ?? 0),
                'no2' => (float) ($item['components']['no2'] ?? 0),
                'o3' => (float) ($item['components']['o3'] ?? 0),
                'so2' => (float) ($item['components']['so2'] ?? 0),
                'pm2_5' => (float) ($item['components']['pm2_5'] ?? 0),
                'pm10' => (float) ($item['components']['pm10'] ?? 0),
                'nh3' => (float) ($item['components']['nh3'] ?? 0),
            ],
        );
    }
}
