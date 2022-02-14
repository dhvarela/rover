<?php

namespace App\Tests\Rover\Domain;

use App\Rover\Shared\Domain\Direction;
use PHPUnit\Framework\TestCase;

class DirectionTest extends TestCase
{
    protected $direction;

    protected function setUp(): void
    {
        $this->direction = new Direction(Direction::DIRECTION_NORTH);
    }
    public function test_should_instantiate_a_direction(): void
    {
        self::assertEquals('N', $this->direction->value());
    }

    public function test_should_get_next_direction_on_turn_right(): void
    {
        $nextDirection = $this->direction->nextDirection('R');

        self::assertEquals('E', $nextDirection->value());
    }

    public function test_should_get_next_direction_on_turn_left(): void
    {
        $nextDirection = $this->direction->nextDirection('L');

        self::assertEquals('W', $nextDirection->value());
    }

    public function test_should_get_next_direction_on_move_forward(): void
    {
        $nextDirection = $this->direction->nextDirection('F');

        self::assertEquals('N', $nextDirection->value());
    }

}
