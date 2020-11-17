<?php
namespace App\DataFixtures;

final class RandomHelper
{
    public static function getRandomInteger(int $from, int $to): int {
        return random_int($from, $to);
    }
}

