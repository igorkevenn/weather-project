<?php

use App\Http\Response;
use App\Models\Api\History\Action;
use App\Models\Api\History\Listing;

/**
 * Rotas do recurso History
 */
return function (string $uri, string $method): bool {
    if ($uri === '/api/history' && $method === 'GET') {
        Response::success((new Listing())->all());
        return true;
    }

    if ($method === 'DELETE' && preg_match('#^/api/history/(\d+)$#', $uri, $matches)) {
        Response::success((new Action())->delete((int) $matches[1]));
        return true;
    }

    return false;
};
