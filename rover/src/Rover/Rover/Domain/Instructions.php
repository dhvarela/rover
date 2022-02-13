<?php

namespace App\Rover\Rover\Domain;

use InvalidArgumentException;

final class Instructions
{
    public const MOVE_FORWARD = 'F';
    public const MOVE_LEFT = 'L';
    public const MOVE_RIGHT = 'R';
    private const VALID_INSTRUCTIONS = [
        self::MOVE_FORWARD,
        self::MOVE_LEFT,
        self::MOVE_RIGHT
    ];
    private $values;

    public function __construct(string $values)
    {
        $instructions = str_split($values);
        foreach ($instructions as $value) {
            $this->ensureValidInstruction($value);
            $this->values[] = $value;
        }
    }

    private function ensureValidInstruction(string $value): void
    {
        if (!in_array($value, self::VALID_INSTRUCTIONS, true)) {
            throw new InvalidArgumentException(
                'Invalid instruction, valid values are ' . implode(",", self::VALID_INSTRUCTIONS)
            );
        }
    }

    public function getValues(): array
    {
        return $this->values;
    }
}
