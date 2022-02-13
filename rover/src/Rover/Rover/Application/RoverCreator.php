<?php

namespace App\Rover\Rover\Application;

use App\Rover\Planet\Domain\Planet;
use App\Rover\Rover\Domain\Coordinate;
use App\Rover\Rover\Domain\Direction;
use App\Rover\Rover\Domain\Rover;

class RoverCreator
{
    public function __construct()
    {
    }

    public function execute(Planet $planet, Coordinate $coordinate, Direction $direction): Rover
    {
        return Rover::create($planet, $coordinate, $direction);
    }
}