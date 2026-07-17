<?php

namespace App\Models\Api\History;

use App\Interfaces\SearchHistoryRepositoryInterface;
use App\Repositories\SearchHistoryRepository;

/**
 * Leituras do histórico
 */
class Listing
{
    private SearchHistoryRepositoryInterface $historyRepository;

    public function __construct(?SearchHistoryRepositoryInterface $historyRepository = null)
    {
        $this->historyRepository = $historyRepository ?: new SearchHistoryRepository();
    }

    public function all(): array
    {
        $limit = (int) ($_GET['limit'] ?? 5);
        $items = $this->historyRepository->all(max(1, min($limit, 5)));

        return Response::list($items);
    }
}
