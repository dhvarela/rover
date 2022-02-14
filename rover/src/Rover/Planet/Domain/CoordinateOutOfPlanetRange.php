<?php

namespace App\Rover\Planet\Domain;

use App\Rover\Shared\Domain\Coordinate;
use InvalidArgumentException;

class CoordinateOutOfPlanetRange extends InvalidArgumentException
{
    public static function throwBecauseOf(Coordinate $coordinate)
    {
        throw new self(sprintf("Coordinate %s is out of planet range", $coordinate));
    }
}