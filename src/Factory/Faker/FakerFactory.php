<?php

namespace App\Factory\Faker;

use Faker\Factory;
use Faker\Generator;

class FakerFactory
{
    const FAKER_SEED = 12345678;


    public static function create(): Generator
    {
        $faker = Factory::create();
        $faker->seed(self::FAKER_SEED);

        return $faker;
    }
}