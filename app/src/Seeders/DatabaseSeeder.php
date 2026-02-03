<?php

namespace App\Seeders;

use App\DB\DB;

final class DatabaseSeeder implements SeederInterface
{
    public function run(DB $db): void
    {
        $faker = new Faker();

        (new PostSeeder($faker, 3))->run($db);
//        (new UserSeeder($faker, 10))->run($db);
    }
}
