<?php

declare(strict_types=1);


require __DIR__ . '/vendor/autoload.php';


$schema = new \App\DB\Scheme();

$schema->setName('nameeee')
    ->addColumn('col1', 'varchar')
    ->addColumn('col2', 'integer')
    ->addColumn('col3', 'integer');

dd($schema->query());



