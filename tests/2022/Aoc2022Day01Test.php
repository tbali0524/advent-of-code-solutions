<?php

declare(strict_types=1);

namespace Tests;

use PHPUnit\Framework\TestCase;
use TBali\Aoc2022\Aoc2022Day01;

final class Aoc2022Day01Test extends TestCase
{
    public function testWorksForExample1(): void
    {
        $solver = new Aoc2022Day01();
        $input = $solver->readInput('input/2022/aoc22_01ex1.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::EXAMPLE_SOLUTIONS[0];
        $this->assertEquals(strval($expected1), $ans1);
        $this->assertEquals(strval($expected2), $ans2);
    }

    public function testWorksForInput(): void
    {
        $solver = new Aoc2022Day01();
        $input = $solver->readInput('input/2022/aoc22_01.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::SOLUTIONS;
        $this->assertEquals(strval($expected1), $ans1);
        $this->assertEquals(strval($expected2), $ans2);
    }
}
