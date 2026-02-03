<?php

namespace App\Seeders;

final class Faker
{
    public function email(): string
    {
        return rand(10000, 99999) . '@email.com';
    }

    public function name(): string
    {
        return 'name_' . rand(1000, 9999);
    }

    public function int(int $min = 0, int $max = 100): int
    {
        return rand($min, $max);
    }

    public function text(int $length = 200): string
    {
        return substr(
            str_shuffle(str_repeat('abcdefghijklmnopqrstuvwxyz ', 10)),
            0,
            $length
        );
    }
}
