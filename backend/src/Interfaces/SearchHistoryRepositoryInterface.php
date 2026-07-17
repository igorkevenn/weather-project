<?php

namespace App\Interfaces;

use App\DTOs\SearchHistoryDTO;

interface SearchHistoryRepositoryInterface
{
    /** @return SearchHistoryDTO[] */
    public function all(int $limit = 20): array;

    public function create(SearchHistoryDTO $history): int;

    public function delete(int $id): bool;
}
