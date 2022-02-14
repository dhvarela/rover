<?php

namespace App\Rover\Planet\Application;

use App\Rover\Planet\Domain\Dimensions;
use App\Rover\Planet\Domain\Planet;
use App\Rover\Shared\Domain\Coordinate;

class PlanetCreator
{
    public function __construct()
    {
    }

    public function execute(Dimensions $dimensions, Coordinate ...$obstacles): Planet
    {
        return Planet::create($dimensions, ...$obstacles);
    }
}