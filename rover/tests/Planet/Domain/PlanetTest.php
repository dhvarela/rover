<?php

namespace App\Tests\Planet\Domain;

use App\Rover\Planet\Domain\CoordinateOutOfPlanetRange;
use App\Rover\Planet\Domain\Dimensions;
use App\Rover\Planet\Domain\Planet;
use App\Rover\Shared\Domain\Coordinate;
use App\Rover\Shared\Domain\Direction;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

class PlanetTest extends TestCase
{
    protected $planet;

    protected function setUp(): void
    {
        $this->planet = Planet::create(new Dimensions(100));
    }

    public function test_should_instantiate_a_planet(): void
    {
        self::assertEquals(100, $this->planet->getDimensions()->value());
    }

    public function test_should_fail_creating_a_small_planet(): void
    {
        $this->expectException(InvalidArgumentException::class);

        Planet::create(new Dimensions(2));
    }

    public function test_should_return_next_coordinate_given_north(): void
    {
        $coordinate = new Coordinate(20, 40);
        $direction  = new Direction(Direction::DIRECTION_NORTH);

        $nextCoordinate = $this->planet->nextCoordinate($coordinate, $direction);

        $this->assertEquals(20, $nextCoordinate->getX());
        $this->assertEquals(41, $nextCoordinate->getY());
    }

    public function test_should_return_next_coordinate_going_back_given_north(): void
    {
        $coordinate = new Coordinate(20, 100);
        $direction  = new Direction(Direction::DIRECTION_NORTH);

        $nextCoordinate = $this->planet->nextCoordinate($coordinate, $direction);

        $this->assertEquals(20, $nextCoordinate->getX());
        $this->assertEquals(0, $nextCoordinate->getY());
    }

    public function test_should_return_next_coordinate_given_south(): void
    {
        $coordinate = new Coordinate(20, 40);
        $direction  = new Direction(Direction::DIRECTION_SOUTH);

        $nextCoordinate = $this->planet->nextCoordinate($coordinate, $direction);

        $this->assertEquals(20, $nextCoordinate->getX());
        $this->assertEquals(39, $nextCoordinate->getY());
    }

    public function test_should_return_next_coordinate_given_east(): void
    {
        $coordinate = new Coordinate(20, 40);
        $direction  = new Direction(Direction::DIRECTION_EAST);

        $nextCoordinate = $this->planet->nextCoordinate($coordinate, $direction);

        $this->assertEquals(21, $nextCoordinate->getX());
        $this->assertEquals(40, $nextCoordinate->getY());
    }

    public function test_should_return_next_coordinate_given_west(): void
    {
        $coordinate = new Coordinate(20, 40);
        $direction  = new Direction(Direction::DIRECTION_WEST);

        $nextCoordinate = $this->planet->nextCoordinate($coordinate, $direction);

        $this->assertEquals(19, $nextCoordinate->getX());
        $this->assertEquals(40, $nextCoordinate->getY());
    }

    public function test_should_fail_given_an_out_of_planet_coordinate(): void
    {
        $this->expectException(CoordinateOutOfPlanetRange::class);

        $coordinate = new Coordinate(150, 40);
        $direction  = new Direction(Direction::DIRECTION_WEST);

        $nextCoordinate = $this->planet->nextCoordinate($coordinate, $direction);
    }
}
