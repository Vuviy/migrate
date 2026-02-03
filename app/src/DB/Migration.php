<?php

namespace App\DB;

abstract class Migration
{
    protected Schema $schema;
    protected DB $db;

    public function __construct()
    {
        $this->db = new DB();
        $this->schema = new Schema();
    }

    abstract public function up(): void;
    abstract public function down(): void;
}
