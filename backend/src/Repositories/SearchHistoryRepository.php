<?php

namespace App\Repositories;

use App\Database;
use App\DTOs\SearchHistoryDTO;
use App\Interfaces\SearchHistoryRepositoryInterface;
use PDO;

class SearchHistoryRepository implements SearchHistoryRepositoryInterface
{
    private PDO $db;

    public function __construct(?PDO $db = null)
    {
        $this->db = $db ?: Database::getConnection();
    }

    public function all(int $limit = 20): array
    {
        $stmt = $this->db->prepare(
            'SELECT id, city_name, temperature, feels_like, humidity, description, searched_at
             FROM (
                 SELECT id, city_name, temperature, feels_like, humidity, description, searched_at,
                        ROW_NUMBER() OVER (PARTITION BY city_name ORDER BY searched_at DESC) AS rn
                 FROM search_history
             ) latest_per_city
             WHERE rn = 1
             ORDER BY searched_at DESC
             LIMIT :limit'
        );
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();

        return array_map(
            static fn (array $row): SearchHistoryDTO => SearchHistoryDTO::fromRow($row),
            $stmt->fetchAll()
        );
    }

    public function create(SearchHistoryDTO $history): int
    {
        $data = $history->toArray();

        $stmt = $this->db->prepare(
            'INSERT INTO search_history (city_name, temperature, feels_like, humidity, description)
             VALUES (:city_name, :temperature, :feels_like, :humidity, :description)'
        );

        $stmt->execute([
            ':city_name' => $data['city_name'],
            ':temperature' => $data['temperature'],
            ':feels_like' => $data['feels_like'],
            ':humidity' => $data['humidity'],
            ':description' => $data['description'],
        ]);

        return (int) $this->db->lastInsertId();
    }

    public function delete(int $id): bool
    {
        $stmt = $this->db->prepare('DELETE FROM search_history WHERE id = :id');
        $stmt->execute([':id' => $id]);

        return $stmt->rowCount() > 0;
    }
}
