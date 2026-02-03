<?php

namespace App\DB;

use PDO;
use PDOStatement;

class DB
{
    private ?PDO $connection = null;

    private function connect(): PDO
    {
        if ($this->connection) {
            return $this->connection;
        }

        $this->connection = new PDO(
            "mysql:host=db_migrate;dbname=migrate;charset=utf8mb4",
            'root',
            'root'
        );

        $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        return $this->connection;
    }


    public function query(string $sql, array $params = []): void
    {
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute($params);
    }

    public function querySeed(string $sql, array $params = []): void
    {
        $stmt = $this->connect()->prepare($sql);

        foreach ($params as $param) {
            $stmt->execute($param);
        }
    }

    public function fetchValue(string $sql): ?int
    {
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute();
        return $stmt->fetchColumn();
    }

    public function get(string $sql, array $params = []): array
    {
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
