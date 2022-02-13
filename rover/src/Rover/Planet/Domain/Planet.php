<?php

namespace App\Rover\Planet\Domain;

final class Planet
{
    private $dimensions;

    private function __construct(Dimensions $dimensions)
    {
        $this->dimensions = $dimensions;
    }

    public static function create(Dimensions $dimensions): self
    {
        return new self($dimensions);
    }

    public function getDimensions(): Dimensions
    {
        return $this->dimensions;
    }

}