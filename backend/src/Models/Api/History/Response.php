<?php

namespace App\Models\Api\History;

use App\DTOs\SearchHistoryDTO;

/**
 * Mapper de resposta do recurso History
 */
class Response
{
    /** @param SearchHistoryDTO[] $items */
    public static function list(array $items): array
    {
        return [
            'registers' => array_map(
                static fn (SearchHistoryDTO $item) => $item->toArray(),
                $items
            ),
        ];
    }

    public static function deleted(): array
    {
        return [
            'deleted' => true,
        ];
    }
}
