<?php

namespace App\Rover\Rover\Domain;

use App\Rover\Planet\Domain\Obstacle;
use App\Rover\Planet\Domain\Planet;
use App\Rover\Shared\Domain\Coordinate;
use App\Rover\Shared\Domain\Direction;

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

    public function executeInstructions(): ?Obstacle
    {
        foreach ($this->getInstructions()->getValues() as $aInstruction) {

            if ($aInstruction === Instructions::MOVE_LEFT) {
                $this->direction->turnLeft();
            }
            if ($aInstruction === Instructions::MOVE_RIGHT) {
                $this->direction->turnRight();
            }

            $nextCoordinate = $this->planet->nextCoordinate(
                $this->coordinate,
                $this->direction
            );

            if ($this->planet->coordinateContainsObstacle($nextCoordinate)) {
                $obstacle = new Obstacle($nextCoordinate);
                break;
            }

            $this->coordinate = $nextCoordinate;
        }

        return $obstacle ?? null;
    }

}