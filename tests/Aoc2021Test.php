<?php

declare(strict_types=1);

namespace TBali\Tests;

use PHPUnit\Framework\TestCase;
use TBali\Aoc2021\Aoc2021Day01;

/**
 * Unit tests for Advent of Code season 2021.
 *
 * @internal
 *
 * @coversNothing
 */
final class Aoc2021Test extends TestCase
{
    // --------------------------------------------------------------------

    /**
     * @covers \TBali\Aoc2021\Aoc2021Day01
     */
    public function testDay01Example1(): void
    {
        $solver = new Aoc2021Day01();
        $input = $solver->readInput($solver->inputBaseFileName() . 'ex1.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::EXAMPLE_SOLUTIONS[0];
        $this->assertEquals(strval($expected1), $ans1);
        $this->assertEquals(strval($expected2), $ans2);
    }

    /**
     * @covers \TBali\Aoc2021\Aoc2021Day01
     */
    public function testDay01(): void
    {
        $solver = new Aoc2021Day01();
        $input = $solver->readInput($solver->inputBaseFileName() . '.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::SOLUTIONS;
        $this->assertEquals(strval($expected1), $ans1);
        $this->assertEquals(strval($expected2), $ans2);
    }

    // --------------------------------------------------------------------
}
