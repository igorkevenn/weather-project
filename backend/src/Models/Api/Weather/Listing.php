<?php

namespace App\Models\Api\Weather;

use App\DTOs\CityDTO;
use App\DTOs\SearchHistoryDTO;
use App\Exceptions\AppException;
use App\Interfaces\OpenWeatherServiceInterface;
use App\Interfaces\SearchHistoryRepositoryInterface;
use App\Repositories\SearchHistoryRepository;
use App\Services\OpenWeatherService;

/**
 * Leituras do recurso Weather 
 */
class Listing
{
    private OpenWeatherServiceInterface $weatherService;
    private SearchHistoryRepositoryInterface $historyRepository;

    public function __construct(
        ?OpenWeatherServiceInterface $weatherService = null,
        ?SearchHistoryRepositoryInterface $historyRepository = null
    ) {
        $this->weatherService = $weatherService ?: new OpenWeatherService();
        $this->historyRepository = $historyRepository ?: new SearchHistoryRepository();
    }

    public function current(): array
    {
        $city = $this->resolveCity();
        $weather = $this->weatherService->getCurrentWeather($city->getLat(), $city->getLon(), $city->getName());

        if ($weather->getCityName() === '' && $city->getName() !== '') {
            $weather = $weather->withCityName($city->getName());
        }

        $this->historyRepository->create(SearchHistoryDTO::fromWeather($weather));

        return Response::current($city, $weather);
    }

    public function forecast(): array
    {
        $city = $this->resolveCity();
        $forecast = $this->weatherService->getForecast($city->getLat(), $city->getLon());

        return Response::forecast($city, $forecast);
    }

    public function airPollution(): array
    {
        $city = $this->resolveCity();
        $pollution = $this->weatherService->getAirPollution($city->getLat(), $city->getLon());

        return Response::airPollution($city, $pollution);
    }

    public function geocode(): array
    {
        $query = trim($_GET['q'] ?? '');

        if ($query === '') {
            throw new AppException('Parâmetro q é obrigatório.', 422);
        }

        return Response::geocode($this->weatherService->geocode($query));
    }

    private function resolveCity(): CityDTO
    {
        $lat = $_GET['lat'] ?? null;
        $lon = $_GET['lon'] ?? null;
        $cityName = trim($_GET['city'] ?? '');

        if ($lat !== null && $lon !== null && $lat !== '' && $lon !== '') {
            return new CityDTO(
                name: $cityName,
                lat: (float) $lat,
                lon: (float) $lon,
            );
        }

        if ($cityName === '') {
            throw new AppException('Informe a cidade.', 422);
        }

        $results = $this->weatherService->geocode($cityName, 1);

        if ($results === []) {
            throw new AppException('Cidade não encontrada.', 404);
        }

        return $results[0];
    }
}
