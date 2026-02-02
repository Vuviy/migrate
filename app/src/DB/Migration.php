<?php

namespace App\DB;

class Migration
{
    public function up(): string
    {
        $scheme = new Scheme();

         return $scheme->setName('nameeee')
            ->addColumn('col1', 'varchar')
            ->addColumn('col2', 'integer')
            ->addColumn('col3', 'integer')
             ->query();

    }

    public function down()
    {

    }
}