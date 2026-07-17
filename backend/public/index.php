<?php

require_once __DIR__ . '/../vendor/autoload.php';

use App\Exceptions\AppException;
use App\Http\Response;

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With');
header('Access-Control-Allow-Methods: GET, POST, DELETE, OPTIONS');
header('Content-Type: application/json; charset=UTF-8');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH) ?: '/';
$method = $_SERVER['REQUEST_METHOD'];
$routeFiles = glob(__DIR__ . '/../src/Http/Routes/api/*.php') ?: [];

try {
    foreach ($routeFiles as $routeFile) {
        $handler = require $routeFile;

        if (is_callable($handler) && $handler($uri, $method)) {
            exit;
        }
    }

    Response::error('Rota não encontrada.', 404);
} catch (AppException $e) {
    Response::error($e->getMessage(), $e->getStatusCode());
} catch (Throwable $e) {
    Response::error('Erro interno no servidor.', 500, [
        'details' => $e->getMessage(),
    ]);
}
