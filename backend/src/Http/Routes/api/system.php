<?php

use App\Database;
use App\Http\Response;

/**
 * Rotas de sistema
 */
return function (string $uri, string $method): bool {
    if ($method !== 'GET') {
        return false;
    }

    if ($uri === '/' || $uri === '/index.php') {
        Response::success([
            'service' => 'InEvent Weather API',
            'online' => true,
        ]);
        return true;
    }

    if ($uri === '/api/db-test') {
        $db = Database::getConnection();
        $stmt = $db->query("SHOW TABLES LIKE 'search_history'");
        $tableExists = (bool) $stmt->fetch();

        Response::success([
            'databaseConnected' => true,
            'tableCreated' => $tableExists,
        ]);
        return true;
    }

    return false;
};
