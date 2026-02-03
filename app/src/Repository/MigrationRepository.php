<?php

namespace App\Repository;

use App\DB\DB;

final class MigrationRepository
{
    private DB $db;
    public function __construct()
    {
        $this->db = new DB();

        $this->db->query(
            'CREATE TABLE IF NOT EXISTS migrations (
                id INT AUTO_INCREMENT PRIMARY KEY,
                migration VARCHAR(255),
                batch INT,
                executed_at DATETIME
            )'
        );
    }

    public function getLastBatch(): int
    {
        return ($this->db->fetchValue('SELECT MAX(batch) FROM migrations') ?? 0);
    }

    public function getExecuted(): array
    {
        $array =  $this->db->get(
            'SELECT migration FROM migrations'
        );
        return array_column($array, 'migration');
    }

    public function log(string $migration, int $batch): void
    {
        $this->db->query(
            'INSERT INTO migrations (migration, batch, executed_at) VALUES (?, ?, NOW())',
            [$migration, $batch]
        );
    }
    public function getByBatch(int $batch): array
    {
        return $this->db->get(
            'SELECT migration FROM migrations WHERE batch = ? ORDER BY id DESC',
            [$batch]
        );
    }

    public function delete(string $migration): void
    {
        $this->db->query(
            'DELETE FROM migrations WHERE migration = ?',
            [$migration]
        );
    }

    public function all(): array
    {
        return $this->db->get(
            'SELECT migration, batch, executed_at FROM migrations ORDER BY id'
        );
    }
}
