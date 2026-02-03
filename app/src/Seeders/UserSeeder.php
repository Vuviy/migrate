<?php

namespace App\Seeders;

use App\DB\DB;

class UserSeeder implements SeederInterface
{
    public function __construct(
        private Faker $faker,
        private int $count = 1
    ) {
    }

    public function run(DB $db): void
    {

        $data = [];

        for ($i = 1; $i <= $this->count; $i++) {
            $data[] = [$this->faker->email(), $this->faker->int(18, 66)];
        }

        $db->querySeed("INSERT INTO users (email, age) VALUES (?, ?)", $data);
    }
}
