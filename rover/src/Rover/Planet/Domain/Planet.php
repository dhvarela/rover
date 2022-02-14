<?php

namespace App\Rover\Planet\Domain;

use App\Rover\Shared\Domain\Coordinate;
use App\Rover\Shared\Domain\Direction;

final class Planet
{
    private $dimensions;
    private $obstacles;

    private function __construct(Dimensions $dimensions, Coordinate ...$obstacles)
    {
        $this->dimensions = $dimensions;
        $this->obstacles = $obstacles;
    }

    public static function create(Dimensions $dimensions, Coordinate ...$obstacles): self
    {
        return new self($dimensions, ...$obstacles);
    }

    public function getDimensions(): Dimensions
    {
        return $this->dimensions;
    }

    public function getObstacles(): array
    {
        return $this->obstacles;
    }

    public function nextCoordinate(Coordinate $coordinate, Direction $direction): Coordinate
    {
        $this->ensureCoordinateInPlanet($coordinate);

        $x = $coordinate->getX();
        $y = $coordinate->getY();

        if ($direction->value() === Direction::DIRECTION_NORTH) {
            $y = $y < $this->getDimensions()->value() ? $y + 1 : 0;
        }
        if ($direction->value() === Direction::DIRECTION_SOUTH) {
            $y = $y > 0 ? $y - 1 : $this->getDimensions()->value();
        }
        if ($direction->value() === Direction::DIRECTION_EAST) {
            $x = $x < $this->getDimensions()->value() ? $x + 1 : 0;
        }
        if ($direction->value() === Direction::DIRECTION_WEST) {
            $x = $x > 0 ? $x - 1 : $this->getDimensions()->value();
        }

        return new Coordinate($x, $y);
    }

    public function coordinateContainsObstacle(Coordinate $coordinate): bool
    {
        return in_array($coordinate, $this->obstacles);
    }

    private function ensureCoordinateInPlanet(Coordinate $coordinate)
    {
        $dimensions = $this->getDimensions()->value();
        if ($coordinate->getX() > $dimensions || $coordinate->getY() > $dimensions) {
            CoordinateOutOfPlanetRange::throwBecauseOf($coordinate);
        }
    }

}