<?php

namespace App\Rover\Planet\Domain;

use App\Rover\Shared\ValueObject\IntValueObject;
use InvalidArgumentException;

final class Dimensions extends IntValueObject
{
    private const MIN_PLANET_DIMENSIONS = 3;

    public function __construct(int $value)
    {
        $this->ensureMinDimension($value);

        parent::__construct($value);
    }

    private function ensureMinDimension(int $value): void
    {
        if ($value < self::MIN_PLANET_DIMENSIONS) {
            throw new InvalidArgumentException('The planet dimensions can\'t be less than ' . self::MIN_PLANET_DIMENSIONS);
        }
    }
}
