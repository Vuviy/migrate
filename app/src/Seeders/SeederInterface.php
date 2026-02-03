<?php

namespace App\Seeders;

use App\DB\DB;

interface SeederInterface
{
    public function run(DB $db): void;
}
