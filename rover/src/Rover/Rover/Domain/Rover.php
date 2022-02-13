<?php

namespace App\Rover\Rover\Domain;

use App\Rover\Planet\Domain\Planet;

final class Rover
{
    private $planet;
    private $coordinate;
    private $direction;
    private $instructions;

    private function __construct(
        Planet       $planet,
        Coordinate   $coordinate,
        Direction    $direction,
        Instructions $instructions
    )
    {
        $this->planet       = $planet;
        $this->coordinate   = $coordinate;
        $this->direction    = $direction;
        $this->instructions = $instructions;
    }

    public static function create(
        Planet       $planet,
        Coordinate   $coordinate,
        Direction    $direction,
        Instructions $instructions
    ): self
    {
        return new self($planet, $coordinate, $direction, $instructions);
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

    public function getInstructions(): Instructions
    {
        return $this->instructions;
    }

    public function executeInstructions()
    {
        foreach($this->instructions as $aInstruction) {
            if ($aInstruction === 'F') {

            }
        }
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