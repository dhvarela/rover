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
        $this->direction->turnRight();

        self::assertEquals('E', $this->direction->value());
    }

    public function test_should_get_next_direction_on_turn_left(): void
    {
        $this->direction->turnLeft();

        self::assertEquals('W', $this->direction->value());
    }

}
