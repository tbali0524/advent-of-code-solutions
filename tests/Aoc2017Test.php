<?php

declare(strict_types=1);

namespace TBali\Tests;

use PHPUnit\Framework\TestCase;
use TBali\Aoc2017\Aoc2017Day01;
use TBali\Aoc2017\Aoc2017Day02;
use TBali\Aoc2017\Aoc2017Day03;
use TBali\Aoc2017\Aoc2017Day04;
use TBali\Aoc2017\Aoc2017Day05;

/**
 * Unit tests for Advent of Code season 2017.
 *
 * @internal
 *
 * @coversNothing
 */
final class Aoc2017Test extends TestCase
{
    // --------------------------------------------------------------------

    /**
     * @covers \TBali\Aoc2017\Aoc2017Day01
     */
    public function testDay01Example1(): void
    {
        $solver = new Aoc2017Day01();
        $input = [$solver::EXAMPLE_STRING_INPUTS[0]];
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::EXAMPLE_SOLUTIONS[0];
        $this->assertEquals(strval($expected1), $ans1);
        // $this->assertEquals(strval($expected2), $ans2);
    }

    /**
     * @covers \TBali\Aoc2017\Aoc2017Day01
     */
    public function testDay01Example2(): void
    {
        $solver = new Aoc2017Day01();
        $input = [$solver::EXAMPLE_STRING_INPUTS[1]];
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::EXAMPLE_SOLUTIONS[1];
        // $this->assertEquals(strval($expected1), $ans1);
        $this->assertEquals(strval($expected2), $ans2);
    }

    /**
     * @covers \TBali\Aoc2017\Aoc2017Day01
     */
    public function testDay01(): void
    {
        $solver = new Aoc2017Day01();
        $input = $solver->readInput($solver->inputBaseFileName() . '.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::SOLUTIONS;
        $this->assertEquals(strval($expected1), $ans1);
        $this->assertEquals(strval($expected2), $ans2);
    }

    // --------------------------------------------------------------------

    /**
     * @covers \TBali\Aoc2017\Aoc2017Day02
     */
    public function testDay02Example1(): void
    {
        $solver = new Aoc2017Day02();
        $input = $solver->readInput($solver->inputBaseFileName() . 'ex1.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::EXAMPLE_SOLUTIONS[0];
        $this->assertEquals(strval($expected1), $ans1);
        // $this->assertEquals(strval($expected2), $ans2);
    }

    /**
     * @covers \TBali\Aoc2017\Aoc2017Day02
     */
    public function testDay02Example2(): void
    {
        $solver = new Aoc2017Day02();
        $input = $solver->readInput($solver->inputBaseFileName() . 'ex2.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::EXAMPLE_SOLUTIONS[1];
        // $this->assertEquals(strval($expected1), $ans1);
        $this->assertEquals(strval($expected2), $ans2);
    }

    /**
     * @covers \TBali\Aoc2017\Aoc2017Day02
     */
    public function testDay02(): void
    {
        $solver = new Aoc2017Day02();
        $input = $solver->readInput($solver->inputBaseFileName() . '.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::SOLUTIONS;
        $this->assertEquals(strval($expected1), $ans1);
        $this->assertEquals(strval($expected2), $ans2);
    }

    // --------------------------------------------------------------------

    /**
     * @covers \TBali\Aoc2017\Aoc2017Day03
     */
    public function testDay03Example1(): void
    {
        $solver = new Aoc2017Day03();
        $input = [$solver::EXAMPLE_STRING_INPUTS[0]];
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::EXAMPLE_SOLUTIONS[0];
        $this->assertEquals(strval($expected1), $ans1);
        // $this->assertEquals(strval($expected2), $ans2);
    }

    /**
     * @covers \TBali\Aoc2017\Aoc2017Day03
     */
    public function testDay03Example2(): void
    {
        $solver = new Aoc2017Day03();
        $input = [$solver::EXAMPLE_STRING_INPUTS[1]];
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::EXAMPLE_SOLUTIONS[1];
        // $this->assertEquals(strval($expected1), $ans1);
        $this->assertEquals(strval($expected2), $ans2);
    }

    /**
     * @covers \TBali\Aoc2017\Aoc2017Day03
     */
    public function testDay03(): void
    {
        $solver = new Aoc2017Day03();
        $input = [$solver::STRING_INPUT];
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::SOLUTIONS;
        $this->assertEquals(strval($expected1), $ans1);
        $this->assertEquals(strval($expected2), $ans2);
    }

    // --------------------------------------------------------------------

    /**
     * @covers \TBali\Aoc2017\Aoc2017Day04
     */
    public function testDay04Example1(): void
    {
        $solver = new Aoc2017Day04();
        $input = $solver->readInput($solver->inputBaseFileName() . 'ex1.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::EXAMPLE_SOLUTIONS[0];
        $this->assertEquals(strval($expected1), $ans1);
        // $this->assertEquals(strval($expected2), $ans2);
    }

    /**
     * @covers \TBali\Aoc2017\Aoc2017Day04
     */
    public function testDay04Example2(): void
    {
        $solver = new Aoc2017Day04();
        $input = $solver->readInput($solver->inputBaseFileName() . 'ex2.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::EXAMPLE_SOLUTIONS[1];
        // $this->assertEquals(strval($expected1), $ans1);
        $this->assertEquals(strval($expected2), $ans2);
    }

    /**
     * @covers \TBali\Aoc2017\Aoc2017Day04
     */
    public function testDay04(): void
    {
        $solver = new Aoc2017Day04();
        $input = $solver->readInput($solver->inputBaseFileName() . '.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::SOLUTIONS;
        $this->assertEquals(strval($expected1), $ans1);
        $this->assertEquals(strval($expected2), $ans2);
    }

    // --------------------------------------------------------------------

    /**
     * @covers \TBali\Aoc2017\Aoc2017Day05
     */
    public function testDay05Example1(): void
    {
        $solver = new Aoc2017Day05();
        $input = $solver->readInput($solver->inputBaseFileName() . 'ex1.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::EXAMPLE_SOLUTIONS[0];
        $this->assertEquals(strval($expected1), $ans1);
        $this->assertEquals(strval($expected2), $ans2);
    }

    /**
     * @covers \TBali\Aoc2017\Aoc2017Day05
     */
    public function testDay05(): void
    {
        $this->markTestSkipped();
        $solver = new Aoc2017Day05();
        $input = $solver->readInput($solver->inputBaseFileName() . '.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::SOLUTIONS;
        $this->assertEquals(strval($expected1), $ans1);
        $this->assertEquals(strval($expected2), $ans2);
    }

    // --------------------------------------------------------------------
}
