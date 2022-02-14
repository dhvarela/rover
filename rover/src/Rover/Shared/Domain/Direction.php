<?php

namespace App\Rover\Shared\Domain;

use App\Rover\Shared\ValueObject\StringValueObject;
use InvalidArgumentException;

final class Direction extends StringValueObject
{
    public const DIRECTION_NORTH = 'N';
    public const DIRECTION_EAST = 'E';
    public const DIRECTION_SOUTH = 'S';
    public const DIRECTION_WEST = 'W';

    private const VALID_DIRECTIONS = [
        self::DIRECTION_NORTH, self::DIRECTION_EAST, self::DIRECTION_SOUTH, self::DIRECTION_WEST
    ];

    public function __construct(string $value)
    {
        $this->ensureValidDirection($value);

        parent::__construct($value);
    }

    private function ensureValidDirection(string $value): void
    {
        if (!in_array($value, self::VALID_DIRECTIONS, true)) {
            throw new InvalidArgumentException(
                'Unrecognized direction, valid values are ' . implode(",", self::VALID_DIRECTIONS)
            );
        }
    }

    public function turnLeft(): void
    {
        $position = array_search($this->value, self::VALID_DIRECTIONS);
        $position = $position === 0 ? count(self::VALID_DIRECTIONS) - 1 : $position - 1;

        $this->value = self::VALID_DIRECTIONS[$position];
    }

    public function turnRight(): void
    {
        $position = array_search($this->value, self::VALID_DIRECTIONS);
        $position = $position === count(self::VALID_DIRECTIONS) - 1 ? 0 : $position + 1;

        $this->value = self::VALID_DIRECTIONS[$position];
    }
}
