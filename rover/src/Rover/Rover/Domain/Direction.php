<?php

namespace App\Rover\Rover\Domain;

use App\Rover\Shared\ValueObject\StringValueObject;
use InvalidArgumentException;

final class Direction extends StringValueObject
{
    public const DIRECTION_NORTH = 'N';
    public const DIRECTION_EAST = 'E';
    public const DIRECTION_SOUTH = 'S';
    public const DIRECTION_WEST = 'W';

    private const VALID_DIRECTIONS = [
        self::DIRECTION_NORTH, self::DIRECTION_WEST, self::DIRECTION_SOUTH, self::DIRECTION_EAST
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
}
