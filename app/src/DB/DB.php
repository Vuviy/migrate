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


    public function query(string $sql): void
    {
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute();
    }

}