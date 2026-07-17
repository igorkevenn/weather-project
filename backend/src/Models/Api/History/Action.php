<?php

namespace App\Models\Api\History;

use App\Exceptions\AppException;
use App\Interfaces\SearchHistoryRepositoryInterface;
use App\Repositories\SearchHistoryRepository;

/**
 * Escritas do histórico
 */
class Action
{
    private SearchHistoryRepositoryInterface $historyRepository;

    public function __construct(?SearchHistoryRepositoryInterface $historyRepository = null)
    {
        $this->historyRepository = $historyRepository ?: new SearchHistoryRepository();
    }

    public function delete(int $id): array
    {
        if ($id <= 0 || !$this->historyRepository->delete($id)) {
            throw new AppException('Registro não encontrado.', 404);
        }

        return Response::deleted();
    }
}
