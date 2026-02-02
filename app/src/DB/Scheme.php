<?php

namespace App\DB;

class Scheme
{
    private string $name;
    private array $columns;

    public function setName(string $name): self
    {
        $this->name = $name;
        return $this;
    }

    public function addColumn(string $columnName, string $type, $length = 255): self
    {
        $this->columns[$columnName] = $type;
        return $this;
    }

    public function query(): string
    {


        $cols = implode(', ', array_map(
            function ($type, $name) {
                $len = '';
                if ($type === 'varchar') {
                    $len = '(255)';
                }
                return "{$name} {$type}$len";
            },
            $this->columns,
            array_keys($this->columns)
        ));

        return 'CREATE TABLE IF NOT EXISTS ' . $this->name . ' (' . $cols . ');';
    }
}