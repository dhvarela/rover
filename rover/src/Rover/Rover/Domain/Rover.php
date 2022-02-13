<?php

namespace App\Rover\Rover\Domain;

use App\Rover\Planet\Domain\Planet;

final class Rover
{
    private $planet;
    private $coordinate;
    private $direction;

    private function __construct(Planet $planet, Coordinate $coordinate, Direction $direction)
    {
        $this->planet     = $planet;
        $this->coordinate = $coordinate;
        $this->direction  = $direction;
    }

    public static function create(Planet $planet, Coordinate $coordinate, Direction $direction): self
    {
        return new self($planet, $coordinate, $direction);
    }

    public function getPlanet(): Planet
    {
        return $this->planet;
    }

    public function getCoordinate(): Coordinate
    {
        return $this->coordinate;
    }

    public function getDirection(): Direction
    {
        return $this->direction;
    }

    public function executeInstructions(array $instructions)
    {

    }

    /*public function moveLeft(): self
    {
        //TODO
        return $this;
    }

    public function moveLeft(): self
    {
        //TODO
        return $this;
    }*/

}