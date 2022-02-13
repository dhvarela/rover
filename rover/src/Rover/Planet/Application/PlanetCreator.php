<?php

namespace App\Rover\Planet\Application;

use App\Rover\Planet\Domain\Dimensions;
use App\Rover\Planet\Domain\Planet;

class PlanetCreator
{
    public function __construct()
    {
    }

    public function execute(Dimensions $dimensions): Planet
    {
        return Planet::create($dimensions);
    }
}