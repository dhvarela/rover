<?php

namespace App\Rover\Planet\Domain;

use App\Rover\Shared\Domain\Coordinate;

final class Obstacle
{
    public const MATERIAL_ROCK = 'rock';

    private $coordinate;
    private $material;

    public function __construct(Coordinate $coordinate, string $material = self::MATERIAL_ROCK)
    {
        $this->coordinate = $coordinate;
        $this->material   = $material;
    }

    public function getCoordinate(): Coordinate
    {
        return $this->coordinate;
    }

    public function getMaterial(): string
    {
        return $this->material;
    }
}