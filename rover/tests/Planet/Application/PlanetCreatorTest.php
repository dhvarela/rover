<?php

namespace App\Tests\Planet\Application;

use App\Rover\Planet\Application\PlanetCreator;
use App\Rover\Planet\Domain\Dimensions;
use App\Rover\Planet\Domain\Planet;
use PHPUnit\Framework\TestCase;

class PlanetCreatorTest extends TestCase
{
    public function test_should_instantiate_a_planet(): void
    {
        $planetCreator = new PlanetCreator();
        $planet = $planetCreator->execute(new Dimensions(100));

        self::assertInstanceOf(Planet::class, $planet);
    }
}
