<?php

namespace App\DB;

class Schema
{
    private string $table;
    private array $columns = [];

    public function create(string $table, callable $callback): string
    {
        $this->table = $table;
        $callback($this);

        $columns = [];
        foreach ($this->columns as $column) {
            $columns[] = implode(' ', $column);
        }

        return sprintf(
            'CREATE TABLE IF NOT EXISTS `%s` (%s)',
            $this->table,
            implode(', ', $columns)
        );
    }

    public function id(): self
    {
        $this->columns[] = ['`id`', 'INT', 'AUTO_INCREMENT', 'PRIMARY KEY'];
        return $this;
    }

    public function string(string $name, int $length = 255): self
    {
        $this->columns[] = ["`$name`", "VARCHAR($length)"];
        return $this;
    }

    public function integer(string $name): self
    {
        $this->columns[] = ["`$name`", 'INT'];
        return $this;
    }
}
