<?php

namespace App\Tests\Planet\Domain;

use App\Rover\Planet\Domain\Dimensions;
use App\Rover\Planet\Domain\Planet;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

class PlanetTest extends TestCase
{
    public function test_should_instantiate_a_planet(): void
    {
        $planet = Planet::create(new Dimensions(100));

        self::assertEquals(100, $planet->getDimensions()->value());
    }

    public function test_should_fail_creating_a_small_planet(): void
    {
        $this->expectException(InvalidArgumentException::class);

        $planet = Planet::create(new Dimensions(2));
    }
}
