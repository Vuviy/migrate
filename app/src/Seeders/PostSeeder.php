<?php

namespace App\Seeders;

use App\DB\DB;

class PostSeeder implements SeederInterface
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
            $data[] = [$this->faker->text(20), $this->faker->text(30), $this->faker->text(36)];
        }

        $db->querySeed("INSERT INTO posts (title, slug, body) VALUES (?, ?, ?)", $data);
    }
}
