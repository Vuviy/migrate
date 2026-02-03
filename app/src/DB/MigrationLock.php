<?php

namespace App\DB;

use PDOException;
use RuntimeException;

final class MigrationLock
{
    private DB $db;

    public function __construct()
    {
        $this->db = new DB();
//        $this->db->query('CREATE TABLE IF NOT EXISTS migrations_lock (
//                    id INT PRIMARY KEY,
//                    locked_at DATETIME NOT NULL)');
    }

    public function acquire(): void
    {
        try {
            $this->db->query(
                "INSERT INTO migrations_lock (id, locked_at) VALUES (1, NOW())"
            );
        } catch (PDOException $exception) {
            throw new RuntimeException('Migrations are already running');
        }
    }

    public function release(): void
    {
        $this->db->query("DELETE FROM migrations_lock WHERE id = 1");
    }
}
