<?php

namespace App\Tests\Rover\Domain;

use App\Rover\Planet\Domain\Dimensions;
use App\Rover\Planet\Domain\Planet;
use App\Rover\Shared\Domain\Coordinate;
use App\Rover\Shared\Domain\Direction;
use App\Rover\Rover\Domain\Instructions;
use App\Rover\Rover\Domain\Rover;
use PHPUnit\Framework\TestCase;

class RoverTest extends TestCase
{
    protected $planet;
    protected $coordinate;

    protected function setUp(): void
    {
        $this->planet     = Planet::create(new Dimensions(100));
        $this->coordinate = new Coordinate(10, 10);
    }

    /**
     * @dataProvider provider
     */
    public function test_should_execute_instructions(
        $direction,
        $instructions,
        $directionExpected,
        $xExpected,
        $yExpected
    ): void
    {
        $instructions = new Instructions($instructions);

        $rover = Rover::create(
            $this->planet,
            $this->coordinate,
            new Direction($direction),
            $instructions
        );

        $rover->executeInstructions();

        self::assertEquals($directionExpected, $rover->getDirection()->value());
        self::assertEquals($xExpected, $rover->getCoordinate()->getX());
        self::assertEquals($yExpected, $rover->getCoordinate()->getY());

    }

    public function provider()
    {
        return [
            //[direction, instructions, directionExpected, xExpected, yExpected]
            ['N', 'FFFLFR', 'N', 8, 14],
            ['S', 'FFFLFR', 'S', 12, 6],
            ['W', 'RRFF', 'E', 13, 11],
            ['E', 'FLFRFLL', 'W', 12, 13],
            ['S', 'FFFFFFFFFFF', 'S', 10, 100], //rover appears on top
        ];
    }
}
