<?php

declare(strict_types=1);

namespace TBali\Tests;

use PHPUnit\Framework\TestCase;
use TBali\Aoc2018\Aoc2018Day01;
use TBali\Aoc2018\Aoc2018Day02;
use TBali\Aoc2018\Aoc2018Day03;
use TBali\Aoc2018\Aoc2018Day04;
use TBali\Aoc2018\Aoc2018Day05;
use TBali\Aoc2018\Aoc2018Day06;
use TBali\Aoc2018\Aoc2018Day07;
use TBali\Aoc2018\Aoc2018Day08;
use TBali\Aoc2018\Aoc2018Day09;
use TBali\Aoc2018\Aoc2018Day10;
use TBali\Aoc2018\Aoc2018Day11;
use TBali\Aoc2018\Aoc2018Day12;
use TBali\Aoc2018\Aoc2018Day13;
use TBali\Aoc2018\Aoc2018Day14;
use TBali\Aoc2018\Aoc2018Day15;
use TBali\Aoc2018\Aoc2018Day16;
use TBali\Aoc2018\Aoc2018Day17;
use TBali\Aoc2018\Aoc2018Day18;
use TBali\Aoc2018\Aoc2018Day19;
use TBali\Aoc2018\Aoc2018Day20;
use TBali\Aoc2018\Aoc2018Day21;
use TBali\Aoc2018\Aoc2018Day22;
use TBali\Aoc2018\Aoc2018Day23;
use TBali\Aoc2018\Aoc2018Day24;
use TBali\Aoc2018\Aoc2018Day25;

/**
 * Unit tests for Advent of Code season 2018.
 *
 * Instead of using this file with phpunit, it is a better way to run the solutions by using AoCRunner.
 *
 * @internal
 *
 * @coversNothing
 */
final class Aoc2018Test extends TestCase
{
    // --------------------------------------------------------------------

    /**
     * @covers \TBali\Aoc2018\Aoc2018Day01
     */
    public function testDay01Example1(): void
    {
        $solver = new Aoc2018Day01();
        $input = $solver->readInput($solver->inputBaseFileName() . 'ex1.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::EXAMPLE_SOLUTIONS[0];
        $this->assertEquals(strval($expected1), $ans1);
        $this->assertEquals(strval($expected2), $ans2);
    }

    /**
     * @covers \TBali\Aoc2018\Aoc2018Day01
     */
    public function testDay01(): void
    {
        $solver = new Aoc2018Day01();
        $input = $solver->readInput($solver->inputBaseFileName() . '.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::SOLUTIONS;
        $this->assertEquals(strval($expected1), $ans1);
        $this->assertEquals(strval($expected2), $ans2);
    }

    // --------------------------------------------------------------------

    /**
     * @covers \TBali\Aoc2018\Aoc2018Day02
     */
    public function testDay02Example1(): void
    {
        $solver = new Aoc2018Day02();
        $input = $solver->readInput($solver->inputBaseFileName() . 'ex1.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::EXAMPLE_SOLUTIONS[0];
        $this->assertEquals(strval($expected1), $ans1);
        // $this->assertEquals(strval($expected2), $ans2);
    }

    /**
     * @covers \TBali\Aoc2018\Aoc2018Day02
     */
    public function testDay02Example2(): void
    {
        $solver = new Aoc2018Day02();
        $input = $solver->readInput($solver->inputBaseFileName() . 'ex2.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::EXAMPLE_SOLUTIONS[1];
        // $this->assertEquals(strval($expected1), $ans1);
        $this->assertEquals(strval($expected2), $ans2);
    }

    /**
     * @covers \TBali\Aoc2018\Aoc2018Day02
     */
    public function testDay02(): void
    {
        $solver = new Aoc2018Day02();
        $input = $solver->readInput($solver->inputBaseFileName() . '.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::SOLUTIONS;
        $this->assertEquals(strval($expected1), $ans1);
        $this->assertEquals(strval($expected2), $ans2);
    }

    // --------------------------------------------------------------------

    /**
     * @covers \TBali\Aoc2018\Aoc2018Day03
     */
    public function testDay03Example1(): void
    {
        $solver = new Aoc2018Day03();
        $input = $solver->readInput($solver->inputBaseFileName() . 'ex1.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::EXAMPLE_SOLUTIONS[0];
        $this->assertEquals(strval($expected1), $ans1);
        $this->assertEquals(strval($expected2), $ans2);
    }

    /**
     * @covers \TBali\Aoc2018\Aoc2018Day03
     */
    public function testDay03(): void
    {
        $solver = new Aoc2018Day03();
        $input = $solver->readInput($solver->inputBaseFileName() . '.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::SOLUTIONS;
        $this->assertEquals(strval($expected1), $ans1);
        $this->assertEquals(strval($expected2), $ans2);
    }

    // --------------------------------------------------------------------

    /**
     * @covers \TBali\Aoc2018\Aoc2018Day04
     */
    public function testDay04Example1(): void
    {
        $solver = new Aoc2018Day04();
        $input = $solver->readInput($solver->inputBaseFileName() . 'ex1.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::EXAMPLE_SOLUTIONS[0];
        $this->assertEquals(strval($expected1), $ans1);
        $this->assertEquals(strval($expected2), $ans2);
    }

    /**
     * @covers \TBali\Aoc2018\Aoc2018Day04
     */
    public function testDay04(): void
    {
        $solver = new Aoc2018Day04();
        $input = $solver->readInput($solver->inputBaseFileName() . '.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::SOLUTIONS;
        $this->assertEquals(strval($expected1), $ans1);
        $this->assertEquals(strval($expected2), $ans2);
    }

    // --------------------------------------------------------------------

    /**
     * @covers \TBali\Aoc2018\Aoc2018Day05
     */
    public function testDay05Example1(): void
    {
        $solver = new Aoc2018Day05();
        $input = $solver->readInput($solver->inputBaseFileName() . 'ex1.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::EXAMPLE_SOLUTIONS[0];
        $this->assertEquals(strval($expected1), $ans1);
        $this->assertEquals(strval($expected2), $ans2);
    }

    /**
     * @covers \TBali\Aoc2018\Aoc2018Day05
     */
    public function testDay05(): void
    {
        $solver = new Aoc2018Day05();
        $input = $solver->readInput($solver->inputBaseFileName() . '.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::SOLUTIONS;
        $this->assertEquals(strval($expected1), $ans1);
        $this->assertEquals(strval($expected2), $ans2);
    }

    // --------------------------------------------------------------------

    /**
     * @covers \TBali\Aoc2018\Aoc2018Day06
     */
    public function testDay06Example1(): void
    {
        $solver = new Aoc2018Day06();
        $input = $solver->readInput($solver->inputBaseFileName() . 'ex1.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::EXAMPLE_SOLUTIONS[0];
        $this->assertEquals(strval($expected1), $ans1);
        $this->assertEquals(strval($expected2), $ans2);
    }

    /**
     * @covers \TBali\Aoc2018\Aoc2018Day06
     */
    public function testDay06(): void
    {
        $this->markTestSkipped();
        $solver = new Aoc2018Day06();
        $input = $solver->readInput($solver->inputBaseFileName() . '.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::SOLUTIONS;
        $this->assertEquals(strval($expected1), $ans1);
        $this->assertEquals(strval($expected2), $ans2);
    }

    // --------------------------------------------------------------------

    /**
     * @covers \TBali\Aoc2018\Aoc2018Day07
     */
    public function testDay07Example1(): void
    {
        $solver = new Aoc2018Day07();
        $input = $solver->readInput($solver->inputBaseFileName() . 'ex1.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::EXAMPLE_SOLUTIONS[0];
        $this->assertEquals(strval($expected1), $ans1);
        $this->assertEquals(strval($expected2), $ans2);
    }

    /**
     * @covers \TBali\Aoc2018\Aoc2018Day07
     */
    public function testDay07(): void
    {
        $solver = new Aoc2018Day07();
        $input = $solver->readInput($solver->inputBaseFileName() . '.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::SOLUTIONS;
        $this->assertEquals(strval($expected1), $ans1);
        $this->assertEquals(strval($expected2), $ans2);
    }

    // --------------------------------------------------------------------

    /**
     * @covers \TBali\Aoc2018\Aoc2018Day08
     */
    public function testDay08Example1(): void
    {
        $solver = new Aoc2018Day08();
        $input = $solver->readInput($solver->inputBaseFileName() . 'ex1.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::EXAMPLE_SOLUTIONS[0];
        $this->assertEquals(strval($expected1), $ans1);
        $this->assertEquals(strval($expected2), $ans2);
    }

    /**
     * @covers \TBali\Aoc2018\Aoc2018Day08
     */
    public function testDay08(): void
    {
        $solver = new Aoc2018Day08();
        $input = $solver->readInput($solver->inputBaseFileName() . '.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::SOLUTIONS;
        $this->assertEquals(strval($expected1), $ans1);
        $this->assertEquals(strval($expected2), $ans2);
    }

    // --------------------------------------------------------------------

    /**
     * @covers \TBali\Aoc2018\Aoc2018Day09
     */
    public function testDay09Example1(): void
    {
        $solver = new Aoc2018Day09();
        $input = $solver->readInput($solver->inputBaseFileName() . 'ex1.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::EXAMPLE_SOLUTIONS[0];
        $this->assertEquals(strval($expected1), $ans1);
        $this->assertEquals(strval($expected2), $ans2);
    }

    /**
     * @covers \TBali\Aoc2018\Aoc2018Day09
     */
    public function testDay09Example2(): void
    {
        $solver = new Aoc2018Day09();
        $input = $solver->readInput($solver->inputBaseFileName() . 'ex2.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::EXAMPLE_SOLUTIONS[1];
        $this->assertEquals(strval($expected1), $ans1);
        $this->assertEquals(strval($expected2), $ans2);
    }

    /**
     * @covers \TBali\Aoc2018\Aoc2018Day09
     */
    public function testDay09Example3(): void
    {
        $solver = new Aoc2018Day09();
        $input = $solver->readInput($solver->inputBaseFileName() . 'ex3.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::EXAMPLE_SOLUTIONS[2];
        $this->assertEquals(strval($expected1), $ans1);
        $this->assertEquals(strval($expected2), $ans2);
    }

    /**
     * @covers \TBali\Aoc2018\Aoc2018Day09
     */
    public function testDay09Example4(): void
    {
        $solver = new Aoc2018Day09();
        $input = $solver->readInput($solver->inputBaseFileName() . 'ex4.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::EXAMPLE_SOLUTIONS[3];
        $this->assertEquals(strval($expected1), $ans1);
        $this->assertEquals(strval($expected2), $ans2);
    }

    /**
     * @covers \TBali\Aoc2018\Aoc2018Day09
     */
    public function testDay09Example5(): void
    {
        $solver = new Aoc2018Day09();
        $input = $solver->readInput($solver->inputBaseFileName() . 'ex5.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::EXAMPLE_SOLUTIONS[4];
        $this->assertEquals(strval($expected1), $ans1);
        $this->assertEquals(strval($expected2), $ans2);
    }

    /**
     * @covers \TBali\Aoc2018\Aoc2018Day09
     */
    public function testDay09Example6(): void
    {
        $solver = new Aoc2018Day09();
        $input = $solver->readInput($solver->inputBaseFileName() . 'ex6.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::EXAMPLE_SOLUTIONS[5];
        $this->assertEquals(strval($expected1), $ans1);
        $this->assertEquals(strval($expected2), $ans2);
    }

    /**
     * @covers \TBali\Aoc2018\Aoc2018Day09
     */
    public function testDay09(): void
    {
        $solver = new Aoc2018Day09();
        $input = $solver->readInput($solver->inputBaseFileName() . '.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::SOLUTIONS;
        $this->assertEquals(strval($expected1), $ans1);
        $this->assertEquals(strval($expected2), $ans2);
    }

    // --------------------------------------------------------------------

    /**
     * @covers \TBali\Aoc2018\Aoc2018Day10
     */
    public function testDay10Example1(): void
    {
        $solver = new Aoc2018Day10();
        $input = $solver->readInput($solver->inputBaseFileName() . 'ex1.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::EXAMPLE_SOLUTIONS[0];
        $this->assertEquals(strval($expected1), $ans1);
        $this->assertEquals(strval($expected2), $ans2);
    }

    /**
     * @covers \TBali\Aoc2018\Aoc2018Day10
     */
    public function testDay10(): void
    {
        $solver = new Aoc2018Day10();
        $input = $solver->readInput($solver->inputBaseFileName() . '.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::SOLUTIONS;
        $this->assertEquals(strval($expected1), $ans1);
        $this->assertEquals(strval($expected2), $ans2);
    }

    // --------------------------------------------------------------------

    /**
     * @covers \TBali\Aoc2018\Aoc2018Day11
     */
    public function testDay11Example1(): void
    {
        $solver = new Aoc2018Day11();
        $input = [$solver::EXAMPLE_STRING_INPUTS[0]];
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::EXAMPLE_SOLUTIONS[0];
        $this->assertEquals(strval($expected1), $ans1);
        $this->assertEquals(strval($expected2), $ans2);
    }

    /**
     * @covers \TBali\Aoc2018\Aoc2018Day11
     */
    public function testDay11(): void
    {
        $solver = new Aoc2018Day11();
        $input = [$solver::STRING_INPUT];
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::SOLUTIONS;
        $this->assertEquals(strval($expected1), $ans1);
        $this->assertEquals(strval($expected2), $ans2);
    }

    // --------------------------------------------------------------------

    /**
     * @covers \TBali\Aoc2018\Aoc2018Day12
     */
    public function testDay12Example1(): void
    {
        $solver = new Aoc2018Day12();
        $input = $solver->readInput($solver->inputBaseFileName() . 'ex1.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::EXAMPLE_SOLUTIONS[0];
        $this->assertEquals(strval($expected1), $ans1);
        $this->assertEquals(strval($expected2), $ans2);
    }

    /**
     * @covers \TBali\Aoc2018\Aoc2018Day12
     */
    public function testDay12(): void
    {
        $solver = new Aoc2018Day12();
        $input = $solver->readInput($solver->inputBaseFileName() . '.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::SOLUTIONS;
        $this->assertEquals(strval($expected1), $ans1);
        $this->assertEquals(strval($expected2), $ans2);
    }

    // --------------------------------------------------------------------

    /**
     * @covers \TBali\Aoc2018\Aoc2018Day13
     */
    public function testDay13Example1(): void
    {
        $solver = new Aoc2018Day13();
        $input = $solver->readInput($solver->inputBaseFileName() . 'ex1.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::EXAMPLE_SOLUTIONS[0];
        $this->assertEquals(strval($expected1), $ans1);
        $this->assertEquals(strval($expected2), $ans2);
    }

    /**
     * @covers \TBali\Aoc2018\Aoc2018Day13
     */
    public function testDay13(): void
    {
        $solver = new Aoc2018Day13();
        $input = $solver->readInput($solver->inputBaseFileName() . '.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::SOLUTIONS;
        $this->assertEquals(strval($expected1), $ans1);
        $this->assertEquals(strval($expected2), $ans2);
    }

    // --------------------------------------------------------------------

    /**
     * @covers \TBali\Aoc2018\Aoc2018Day14
     */
    public function testDay14Example1(): void
    {
        $solver = new Aoc2018Day14();
        $input = [$solver::EXAMPLE_STRING_INPUTS[0]];
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::EXAMPLE_SOLUTIONS[0];
        $this->assertEquals(strval($expected1), $ans1);
        $this->assertEquals(strval($expected2), $ans2);
    }

    /**
     * @covers \TBali\Aoc2018\Aoc2018Day14
     */
    public function testDay14Example2(): void
    {
        $solver = new Aoc2018Day14();
        $input = [$solver::EXAMPLE_STRING_INPUTS[1]];
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::EXAMPLE_SOLUTIONS[1];
        $this->assertEquals(strval($expected1), $ans1);
        $this->assertEquals(strval($expected2), $ans2);
    }

    /**
     * @covers \TBali\Aoc2018\Aoc2018Day14
     */
    public function testDay14Example3(): void
    {
        $solver = new Aoc2018Day14();
        $input = [$solver::EXAMPLE_STRING_INPUTS[2]];
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::EXAMPLE_SOLUTIONS[2];
        $this->assertEquals(strval($expected1), $ans1);
        $this->assertEquals(strval($expected2), $ans2);
    }

    /**
     * @covers \TBali\Aoc2018\Aoc2018Day14
     */
    public function testDay14Example4(): void
    {
        $solver = new Aoc2018Day14();
        $input = [$solver::EXAMPLE_STRING_INPUTS[3]];
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::EXAMPLE_SOLUTIONS[3];
        $this->assertEquals(strval($expected1), $ans1);
        $this->assertEquals(strval($expected2), $ans2);
    }

    /**
     * @covers \TBali\Aoc2018\Aoc2018Day14
     */
    public function testDay14(): void
    {
        $solver = new Aoc2018Day14();
        $input = [$solver::STRING_INPUT];
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::SOLUTIONS;
        $this->assertEquals(strval($expected1), $ans1);
        $this->assertEquals(strval($expected2), $ans2);
    }

    // --------------------------------------------------------------------

    /**
     * @covers \TBali\Aoc2018\Aoc2018Day15
     */
    public function testDay15Example1(): void
    {
        $solver = new Aoc2018Day15();
        $input = $solver->readInput($solver->inputBaseFileName() . 'ex1.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::EXAMPLE_SOLUTIONS[0];
        $this->assertEquals(strval($expected1), $ans1);
        $this->assertEquals(strval($expected2), $ans2);
    }

    /**
     * @covers \TBali\Aoc2018\Aoc2018Day15
     */
    public function testDay15(): void
    {
        $solver = new Aoc2018Day15();
        $input = $solver->readInput($solver->inputBaseFileName() . '.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::SOLUTIONS;
        $this->assertEquals(strval($expected1), $ans1);
        $this->assertEquals(strval($expected2), $ans2);
    }

    // --------------------------------------------------------------------

    /**
     * @covers \TBali\Aoc2018\Aoc2018Day16
     */
    public function testDay16Example1(): void
    {
        $solver = new Aoc2018Day16();
        $input = $solver->readInput($solver->inputBaseFileName() . 'ex1.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::EXAMPLE_SOLUTIONS[0];
        $this->assertEquals(strval($expected1), $ans1);
        $this->assertEquals(strval($expected2), $ans2);
    }

    /**
     * @covers \TBali\Aoc2018\Aoc2018Day16
     */
    public function testDay16(): void
    {
        $solver = new Aoc2018Day16();
        $input = $solver->readInput($solver->inputBaseFileName() . '.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::SOLUTIONS;
        $this->assertEquals(strval($expected1), $ans1);
        $this->assertEquals(strval($expected2), $ans2);
    }

    // --------------------------------------------------------------------

    /**
     * @covers \TBali\Aoc2018\Aoc2018Day17
     */
    public function testDay17Example1(): void
    {
        $solver = new Aoc2018Day17();
        $input = $solver->readInput($solver->inputBaseFileName() . 'ex1.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::EXAMPLE_SOLUTIONS[0];
        $this->assertEquals(strval($expected1), $ans1);
        $this->assertEquals(strval($expected2), $ans2);
    }

    /**
     * @covers \TBali\Aoc2018\Aoc2018Day17
     */
    public function testDay17(): void
    {
        $solver = new Aoc2018Day17();
        $input = $solver->readInput($solver->inputBaseFileName() . '.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::SOLUTIONS;
        $this->assertEquals(strval($expected1), $ans1);
        $this->assertEquals(strval($expected2), $ans2);
    }

    // --------------------------------------------------------------------

    /**
     * @covers \TBali\Aoc2018\Aoc2018Day18
     */
    public function testDay18Example1(): void
    {
        $solver = new Aoc2018Day18();
        $input = $solver->readInput($solver->inputBaseFileName() . 'ex1.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::EXAMPLE_SOLUTIONS[0];
        $this->assertEquals(strval($expected1), $ans1);
        $this->assertEquals(strval($expected2), $ans2);
    }

    /**
     * @covers \TBali\Aoc2018\Aoc2018Day18
     */
    public function testDay18(): void
    {
        $solver = new Aoc2018Day18();
        $input = $solver->readInput($solver->inputBaseFileName() . '.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::SOLUTIONS;
        $this->assertEquals(strval($expected1), $ans1);
        $this->assertEquals(strval($expected2), $ans2);
    }

    // --------------------------------------------------------------------

    /**
     * @covers \TBali\Aoc2018\Aoc2018Day19
     */
    public function testDay19Example1(): void
    {
        $solver = new Aoc2018Day19();
        $input = $solver->readInput($solver->inputBaseFileName() . 'ex1.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::EXAMPLE_SOLUTIONS[0];
        $this->assertEquals(strval($expected1), $ans1);
        $this->assertEquals(strval($expected2), $ans2);
    }

    /**
     * @covers \TBali\Aoc2018\Aoc2018Day19
     */
    public function testDay19(): void
    {
        $solver = new Aoc2018Day19();
        $input = $solver->readInput($solver->inputBaseFileName() . '.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::SOLUTIONS;
        $this->assertEquals(strval($expected1), $ans1);
        $this->assertEquals(strval($expected2), $ans2);
    }

    // --------------------------------------------------------------------

    /**
     * @covers \TBali\Aoc2018\Aoc2018Day20
     */
    public function testDay20Example1(): void
    {
        $solver = new Aoc2018Day20();
        $input = $solver->readInput($solver->inputBaseFileName() . 'ex1.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::EXAMPLE_SOLUTIONS[0];
        $this->assertEquals(strval($expected1), $ans1);
        $this->assertEquals(strval($expected2), $ans2);
    }

    /**
     * @covers \TBali\Aoc2018\Aoc2018Day20
     */
    public function testDay20Example2(): void
    {
        $solver = new Aoc2018Day20();
        $input = $solver->readInput($solver->inputBaseFileName() . 'ex2.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::EXAMPLE_SOLUTIONS[1];
        $this->assertEquals(strval($expected1), $ans1);
        $this->assertEquals(strval($expected2), $ans2);
    }

    /**
     * @covers \TBali\Aoc2018\Aoc2018Day20
     */
    public function testDay20Example3(): void
    {
        $solver = new Aoc2018Day20();
        $input = $solver->readInput($solver->inputBaseFileName() . 'ex3.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::EXAMPLE_SOLUTIONS[2];
        $this->assertEquals(strval($expected1), $ans1);
        $this->assertEquals(strval($expected2), $ans2);
    }

    /**
     * @covers \TBali\Aoc2018\Aoc2018Day20
     */
    public function testDay20Example4(): void
    {
        $solver = new Aoc2018Day20();
        $input = $solver->readInput($solver->inputBaseFileName() . 'ex4.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::EXAMPLE_SOLUTIONS[3];
        $this->assertEquals(strval($expected1), $ans1);
        $this->assertEquals(strval($expected2), $ans2);
    }

    /**
     * @covers \TBali\Aoc2018\Aoc2018Day20
     */
    public function testDay20Example5(): void
    {
        $solver = new Aoc2018Day20();
        $input = $solver->readInput($solver->inputBaseFileName() . 'ex5.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::EXAMPLE_SOLUTIONS[4];
        $this->assertEquals(strval($expected1), $ans1);
        $this->assertEquals(strval($expected2), $ans2);
    }

    /**
     * @covers \TBali\Aoc2018\Aoc2018Day20
     */
    public function testDay20(): void
    {
        $solver = new Aoc2018Day20();
        $input = $solver->readInput($solver->inputBaseFileName() . '.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::SOLUTIONS;
        $this->assertEquals(strval($expected1), $ans1);
        $this->assertEquals(strval($expected2), $ans2);
    }

    // --------------------------------------------------------------------

    /**
     * @covers \TBali\Aoc2018\Aoc2018Day21
     */
    public function testDay21(): void
    {
        $solver = new Aoc2018Day21();
        $input = $solver->readInput($solver->inputBaseFileName() . '.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::SOLUTIONS;
        $this->assertEquals(strval($expected1), $ans1);
        $this->assertEquals(strval($expected2), $ans2);
    }

    // --------------------------------------------------------------------

    /**
     * @covers \TBali\Aoc2018\Aoc2018Day22
     */
    public function testDay22Example1(): void
    {
        $solver = new Aoc2018Day22();
        $input = $solver->readInput($solver->inputBaseFileName() . 'ex1.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::EXAMPLE_SOLUTIONS[0];
        $this->assertEquals(strval($expected1), $ans1);
        $this->assertEquals(strval($expected2), $ans2);
    }

    /**
     * @covers \TBali\Aoc2018\Aoc2018Day22
     */
    public function testDay22(): void
    {
        $solver = new Aoc2018Day22();
        $input = $solver->readInput($solver->inputBaseFileName() . '.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::SOLUTIONS;
        $this->assertEquals(strval($expected1), $ans1);
        $this->assertEquals(strval($expected2), $ans2);
    }

    // --------------------------------------------------------------------

    /**
     * @covers \TBali\Aoc2018\Aoc2018Day23
     */
    public function testDay23Example1(): void
    {
        $solver = new Aoc2018Day23();
        $input = $solver->readInput($solver->inputBaseFileName() . 'ex1.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::EXAMPLE_SOLUTIONS[0];
        $this->assertEquals(strval($expected1), $ans1);
        $this->assertEquals(strval($expected2), $ans2);
    }

    /**
     * @covers \TBali\Aoc2018\Aoc2018Day23
     */
    public function testDay23(): void
    {
        $solver = new Aoc2018Day23();
        $input = $solver->readInput($solver->inputBaseFileName() . '.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::SOLUTIONS;
        $this->assertEquals(strval($expected1), $ans1);
        $this->assertEquals(strval($expected2), $ans2);
    }

    // --------------------------------------------------------------------

    /**
     * @covers \TBali\Aoc2018\Aoc2018Day24
     */
    public function testDay24Example1(): void
    {
        $solver = new Aoc2018Day24();
        $input = $solver->readInput($solver->inputBaseFileName() . 'ex1.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::EXAMPLE_SOLUTIONS[0];
        $this->assertEquals(strval($expected1), $ans1);
        $this->assertEquals(strval($expected2), $ans2);
    }

    /**
     * @covers \TBali\Aoc2018\Aoc2018Day24
     */
    public function testDay24(): void
    {
        $solver = new Aoc2018Day24();
        $input = $solver->readInput($solver->inputBaseFileName() . '.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::SOLUTIONS;
        $this->assertEquals(strval($expected1), $ans1);
        $this->assertEquals(strval($expected2), $ans2);
    }

    // --------------------------------------------------------------------

    /**
     * @covers \TBali\Aoc2018\Aoc2018Day25
     */
    public function testDay25Example1(): void
    {
        $solver = new Aoc2018Day25();
        $input = $solver->readInput($solver->inputBaseFileName() . 'ex1.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::EXAMPLE_SOLUTIONS[0];
        $this->assertEquals(strval($expected1), $ans1);
        // $this->assertEquals(strval($expected2), $ans2);
    }

    /**
     * @covers \TBali\Aoc2018\Aoc2018Day25
     */
    public function testDay25Example2(): void
    {
        $solver = new Aoc2018Day25();
        $input = $solver->readInput($solver->inputBaseFileName() . 'ex2.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::EXAMPLE_SOLUTIONS[1];
        $this->assertEquals(strval($expected1), $ans1);
        // $this->assertEquals(strval($expected2), $ans2);
    }

    /**
     * @covers \TBali\Aoc2018\Aoc2018Day25
     */
    public function testDay25Example3(): void
    {
        $solver = new Aoc2018Day25();
        $input = $solver->readInput($solver->inputBaseFileName() . 'ex3.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::EXAMPLE_SOLUTIONS[2];
        $this->assertEquals(strval($expected1), $ans1);
        // $this->assertEquals(strval($expected2), $ans2);
    }

    /**
     * @covers \TBali\Aoc2018\Aoc2018Day25
     */
    public function testDay25Example4(): void
    {
        $solver = new Aoc2018Day25();
        $input = $solver->readInput($solver->inputBaseFileName() . 'ex4.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::EXAMPLE_SOLUTIONS[3];
        $this->assertEquals(strval($expected1), $ans1);
        // $this->assertEquals(strval($expected2), $ans2);
    }

    /**
     * @covers \TBali\Aoc2018\Aoc2018Day25
     */
    public function testDay25(): void
    {
        $solver = new Aoc2018Day25();
        $input = $solver->readInput($solver->inputBaseFileName() . '.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::SOLUTIONS;
        $this->assertEquals(strval($expected1), $ans1);
        // $this->assertEquals(strval($expected2), $ans2);
    }

    // --------------------------------------------------------------------
}
