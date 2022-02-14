<?php

namespace App\Rover\Shared\Domain;

use InvalidArgumentException;

final class Coordinate
{
    private $x;
    private $y;

    public function __construct(int $x, int $y)
    {
        $this->ensurePositiveValues([$x, $y]);

        $this->x = $x;
        $this->y = $y;
    }

    private function ensurePositiveValues(array $values): void
    {
        foreach($values as $aValue) {
            if ($aValue < 0) {
                throw new InvalidArgumentException('A coordinate must contain positive values');
            }
        }
    }

    public function getX(): int
    {
        return $this->x;
    }

    public function getY(): int
    {
        return $this->y;
    }

    public function __toString()
    {
        return $this->getX() . ',' . $this->getY();
    }
}
