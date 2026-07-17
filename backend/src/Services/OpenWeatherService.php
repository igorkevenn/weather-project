<?php

namespace App\Services;

use App\DTOs\AirPollutionDTO;
use App\DTOs\CityDTO;
use App\DTOs\WeatherDTO;
use App\Exceptions\AppException;
use App\Interfaces\OpenWeatherServiceInterface;

class OpenWeatherService implements OpenWeatherServiceInterface
{
    private string $apiKey;
    private string $baseUrl = 'https://api.openweathermap.org';

    public function __construct(?string $apiKey = null)
    {
        $this->apiKey = $apiKey ?: (getenv('OPENWEATHER_API_KEY') ?: '');
    }

    public function geocode(string $query, int $limit = 5): array
    {
        $query = trim($query);

        if ($query === '') {
            throw new AppException('Informe o nome da cidade.', 422);
        }

        $results = $this->request('/geo/1.0/direct', [
            'q' => $query,
            'limit' => $limit,
        ]);

        return array_map(
            static fn (array $item): CityDTO => CityDTO::fromArray($item),
            $results
        );
    }

    public function getCurrentWeather(float $lat, float $lon, ?string $nameCity): WeatherDTO
    {
        $data = $this->request('/data/2.5/weather', [
            'lat' => $lat,
            'lon' => $lon,
            'units' => 'metric',
            'lang' => 'pt_br',
        ]);

        return WeatherDTO::fromOpenWeather($data, $lat, $lon, $nameCity ?? '');
    }

    public function getForecast(float $lat, float $lon): array
    {
        $data = $this->request('/data/2.5/forecast', [
            'lat' => $lat,
            'lon' => $lon,
            'units' => 'metric',
            'lang' => 'pt_br',
        ]);

        $list = array_map(static function (array $item): array {
            $weather = $item['weather'][0] ?? [];

            return [
                'datetime' => $item['dt_txt'] ?? '',
                'timestamp' => (int) ($item['dt'] ?? 0),
                'temperature' => (float) ($item['main']['temp'] ?? 0),
                'feels_like' => (float) ($item['main']['feels_like'] ?? 0),
                'temp_min' => (float) ($item['main']['temp_min'] ?? 0),
                'temp_max' => (float) ($item['main']['temp_max'] ?? 0),
                'humidity' => (int) ($item['main']['humidity'] ?? 0),
                'description' => $weather['description'] ?? '',
                'icon' => $weather['icon'] ?? '',
                'wind_speed' => (float) ($item['wind']['speed'] ?? 0),
                'pop' => (float) ($item['pop'] ?? 0),
            ];
        }, $data['list'] ?? []);

        return [
            'city' => [
                'name' => $data['city']['name'] ?? '',
                'country' => $data['city']['country'] ?? '',
                'lat' => (float) ($data['city']['coord']['lat'] ?? $lat),
                'lon' => (float) ($data['city']['coord']['lon'] ?? $lon),
            ],
            'list' => $list,
        ];
    }

    public function getAirPollution(float $lat, float $lon): AirPollutionDTO
    {
        $data = $this->request('/data/2.5/air_pollution', [
            'lat' => $lat,
            'lon' => $lon,
        ]);

        return AirPollutionDTO::fromOpenWeather($data);
    }

    private function request(string $endpoint, array $params = []): array
    {
        if ($this->apiKey === '' || $this->apiKey === 'sua_chave_api_aqui') {
            throw new AppException('OPENWEATHER_API_KEY não configurada.', 500);
        }

        $params['appid'] = $this->apiKey;
        $url = $this->baseUrl . $endpoint . '?' . http_build_query($params);

        $ch = curl_init($url);
        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT => 15,
        ]);

        $body = curl_exec($ch);
        $status = (int) curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $error = curl_error($ch);
        curl_close($ch);

        if ($body === false) {
            throw new AppException('Busca indisponível, tente novamente mais tarde', 502);
        }

        $data = json_decode($body, true);

        if (!is_array($data) || $status >= 400) {
            $message = is_array($data) ? ($data['message'] ?? 'Erro na OpenWeather') : 'Resposta inválida';
            throw new AppException($message, $status >= 400 ? $status : 502);
        }

        return $data;
    }
}
