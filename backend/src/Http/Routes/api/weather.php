<?php

use App\Http\Response;
use App\Models\Api\Weather\Listing;

/**
 * Rotas do recurso Weather
 * Estilo API v2: rota instancia Listing e devolve Response
 */
return function (string $uri, string $method): bool {
    if ($method !== 'GET') {
        return false;
    }

    $routes = [
        '/api/weather' => 'current',
        '/api/forecast' => 'forecast',
        '/api/air-pollution' => 'airPollution',
        '/api/geocode' => 'geocode',
    ];

    if (!isset($routes[$uri])) {
        return false;
    }

    $data = (new Listing())->{$routes[$uri]}();
    Response::success($data);

    return true;
};
