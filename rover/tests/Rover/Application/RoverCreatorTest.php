<?php

namespace App\Tests\Rover\Application;

use App\Rover\Planet\Domain\Dimensions;
use App\Rover\Planet\Domain\Planet;
use App\Rover\Rover\Application\RoverCreator;
use App\Rover\Shared\Domain\Coordinate;
use App\Rover\Shared\Domain\Direction;
use App\Rover\Rover\Domain\Instructions;
use App\Rover\Rover\Domain\Rover;
use PHPUnit\Framework\TestCase;

class RoverCreatorTest extends TestCase
{
    public function test_should_instantiate_a_rover(): void
    {
        $roverCreator = new RoverCreator();

        $rover = $roverCreator->execute(
            Planet::create(new Dimensions(100)),
            new Coordinate(1, 1),
            new Direction('N'),
            new Instructions('FFFLFR')
        );

        self::assertInstanceOf(Rover::class, $rover);
    }
}
