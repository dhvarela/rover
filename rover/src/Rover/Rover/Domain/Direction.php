<?php

namespace App\Rover\Rover\Domain;

use App\Rover\Shared\ValueObject\StringValueObject;
use InvalidArgumentException;

final class Direction extends StringValueObject
{
    public const DIRECTION_NORTH = 'N';
    public const DIRECTION_EAST  = 'E';
    public const DIRECTION_SOUTH = 'S';
    public const DIRECTION_WEST  = 'W';

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

    public function nextDirection(string $instruction): Direction
    {
        if ($instruction === Instructions::MOVE_FORWARD) {
            return $this;
        }

        $position = array_search($this->value, self::VALID_DIRECTIONS);

        if ($instruction === Instructions::MOVE_LEFT) {
            $position = $position === 0 ? count(self::VALID_DIRECTIONS) - 1 : $position - 1;
        }
        if ($instruction === Instructions::MOVE_RIGHT) {
            $position = $position === count(self::VALID_DIRECTIONS) - 1 ? 0 : $position + 1;
        }

        return new Direction(self::VALID_DIRECTIONS[$position]);
    }
}
