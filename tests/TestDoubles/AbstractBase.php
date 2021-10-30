<?php

namespace Procountor\Tests\TestDoubles;

use Faker\Factory as FakerFactory;
use Faker\Generator;


abstract class AbstractBase
{

    public Generator $faker;

    public function __construct()
    {
        $this->faker = FakerFactory::create();
    }

}
