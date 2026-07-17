<?php

namespace App\Http;

class Response
{
    public static function success(mixed $data = null, int $statusCode = 200): void
    {
        self::send(true, $data, $statusCode);
    }

    public static function error(string $message, int $statusCode = 400, array $details = []): void
    {
        self::send(false, [
            'code' => $statusCode,
            'message' => $message,
            'details' => $details,
        ], $statusCode);
    }

    private static function send(bool $status, mixed $data, int $statusCode): void
    {
        http_response_code($statusCode);
        echo json_encode([
            'status' => $status,
            'data' => $data,
        ], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    }
}
