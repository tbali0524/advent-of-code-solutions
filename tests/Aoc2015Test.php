<?php

declare(strict_types=1);

namespace Tests;

use PHPUnit\Framework\TestCase;
use TBali\Aoc2015\Aoc2015Day01;
use TBali\Aoc2015\Aoc2015Day02;
use TBali\Aoc2015\Aoc2015Day03;
use TBali\Aoc2015\Aoc2015Day04;
use TBali\Aoc2015\Aoc2015Day05;
use TBali\Aoc2015\Aoc2015Day06;
use TBali\Aoc2015\Aoc2015Day07;
use TBali\Aoc2015\Aoc2015Day08;
use TBali\Aoc2015\Aoc2015Day09;
use TBali\Aoc2015\Aoc2015Day10;
use TBali\Aoc2015\Aoc2015Day11;
use TBali\Aoc2015\Aoc2015Day12;
use TBali\Aoc2015\Aoc2015Day13;
use TBali\Aoc2015\Aoc2015Day14;
use TBali\Aoc2015\Aoc2015Day15;
use TBali\Aoc2015\Aoc2015Day16;
use TBali\Aoc2015\Aoc2015Day17;
use TBali\Aoc2015\Aoc2015Day18;
use TBali\Aoc2015\Aoc2015Day19;
use TBali\Aoc2015\Aoc2015Day20;
use TBali\Aoc2015\Aoc2015Day21;
use TBali\Aoc2015\Aoc2015Day22;
use TBali\Aoc2015\Aoc2015Day23;
use TBali\Aoc2015\Aoc2015Day24;
use TBali\Aoc2015\Aoc2015Day25;

/**
 * Unit tests for Advent of Code season 2015.
 *
 * @internal
 *
 * @coversNothing
 */
final class Aoc2015Test extends TestCase
{
    // --------------------------------------------------------------------

    /**
     * @covers \TBali\Aoc2015\Aoc2015Day01
     */
    public function testDay01Example1(): void
    {
        $solver = new Aoc2015Day01();
        $input = [$solver::EXAMPLE_STRING_INPUTS[0]];
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::EXAMPLE_SOLUTIONS[0];
        $this->assertEquals(strval($expected1), $ans1);
        $this->assertEquals(strval($expected2), $ans2);
    }

    /**
     * @covers \TBali\Aoc2015\Aoc2015Day01
     */
    public function testDay01Example2(): void
    {
        $solver = new Aoc2015Day01();
        $input = [$solver::EXAMPLE_STRING_INPUTS[1]];
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::EXAMPLE_SOLUTIONS[1];
        // $this->assertEquals(strval($expected1), $ans1);
        $this->assertEquals(strval($expected2), $ans2);
    }

    /**
     * @covers \TBali\Aoc2015\Aoc2015Day01
     * @covers \TBali\Aoc\SolutionBase
     */
    public function testDay01(): void
    {
        $solver = new Aoc2015Day01();
        $baseFileName = 'input/' . $solver::YEAR . '/Aoc' . $solver::YEAR . 'Day'
            . str_pad(strval($solver::DAY), 2, '0', STR_PAD_LEFT);
        $input = $solver->readInput($baseFileName . '.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::SOLUTIONS;
        $this->assertEquals(strval($expected1), $ans1);
        $this->assertEquals(strval($expected2), $ans2);
    }

    // --------------------------------------------------------------------

    /**
     * @covers \TBali\Aoc2015\Aoc2015Day02
     */
    public function testDay02Example1(): void
    {
        $solver = new Aoc2015Day02();
        $input = [$solver::EXAMPLE_STRING_INPUTS[0]];
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::EXAMPLE_SOLUTIONS[0];
        $this->assertEquals(strval($expected1), $ans1);
        $this->assertEquals(strval($expected2), $ans2);
    }

    /**
     * @covers \TBali\Aoc2015\Aoc2015Day02
     */
    public function testDay02Example2(): void
    {
        $solver = new Aoc2015Day02();
        $input = [$solver::EXAMPLE_STRING_INPUTS[1]];
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::EXAMPLE_SOLUTIONS[1];
        $this->assertEquals(strval($expected1), $ans1);
        $this->assertEquals(strval($expected2), $ans2);
    }

    /**
     * @covers \TBali\Aoc2015\Aoc2015Day02
     */
    public function testDay02(): void
    {
        $solver = new Aoc2015Day02();
        $baseFileName = 'input/' . $solver::YEAR . '/Aoc' . $solver::YEAR . 'Day'
            . str_pad(strval($solver::DAY), 2, '0', STR_PAD_LEFT);
        $input = $solver->readInput($baseFileName . '.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::SOLUTIONS;
        $this->assertEquals(strval($expected1), $ans1);
        $this->assertEquals(strval($expected2), $ans2);
    }

    /**
     * @covers \TBali\Aoc2015\Aoc2015Day02
     */
    public function testDay02InvalidInput(): void
    {
        $solver = new Aoc2015Day02();
        $input = ['2x3x4x5'];
        $this->expectException(\Exception::class);
        [$ans1, $ans2] = $solver->solve($input);
    }

    // --------------------------------------------------------------------

    /**
     * @covers \TBali\Aoc2015\Aoc2015Day03
     */
    public function testDay03Example1(): void
    {
        $solver = new Aoc2015Day03();
        $input = [$solver::EXAMPLE_STRING_INPUTS[0]];
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::EXAMPLE_SOLUTIONS[0];
        $this->assertEquals(strval($expected1), $ans1);
        $this->assertEquals(strval($expected2), $ans2);
    }

    /**
     * @covers \TBali\Aoc2015\Aoc2015Day03
     */
    public function testDay03Example2(): void
    {
        $solver = new Aoc2015Day03();
        $input = [$solver::EXAMPLE_STRING_INPUTS[1]];
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::EXAMPLE_SOLUTIONS[1];
        $this->assertEquals(strval($expected1), $ans1);
        $this->assertEquals(strval($expected2), $ans2);
    }

    /**
     * @covers \TBali\Aoc2015\Aoc2015Day03
     */
    public function testDay03(): void
    {
        $solver = new Aoc2015Day03();
        $baseFileName = 'input/' . $solver::YEAR . '/Aoc' . $solver::YEAR . 'Day'
            . str_pad(strval($solver::DAY), 2, '0', STR_PAD_LEFT);
        $input = $solver->readInput($baseFileName . '.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::SOLUTIONS;
        $this->assertEquals(strval($expected1), $ans1);
        $this->assertEquals(strval($expected2), $ans2);
    }

    // --------------------------------------------------------------------

    /**
     * @covers \TBali\Aoc2015\Aoc2015Day04
     */
    public function testDay04Example1(): void
    {
        $this->markTestSkipped();
        $solver = new Aoc2015Day04();
        $input = [$solver::EXAMPLE_STRING_INPUTS[0]];
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::EXAMPLE_SOLUTIONS[0];
        $this->assertEquals(strval($expected1), $ans1);
        // $this->assertEquals(strval($expected2), $ans2);
    }

    /**
     * @covers \TBali\Aoc2015\Aoc2015Day04
     */
    public function testDay04Example2(): void
    {
        $this->markTestSkipped();
        $solver = new Aoc2015Day04();
        $input = [$solver::EXAMPLE_STRING_INPUTS[1]];
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::EXAMPLE_SOLUTIONS[1];
        $this->assertEquals(strval($expected1), $ans1);
        // $this->assertEquals(strval($expected2), $ans2);
    }

    /**
     * @covers \TBali\Aoc2015\Aoc2015Day04
     */
    public function testDay04(): void
    {
        $this->markTestSkipped();
        $solver = new Aoc2015Day04();
        $input = [$solver::STRING_INPUT];
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::SOLUTIONS;
        $this->assertEquals(strval($expected1), $ans1);
        $this->assertEquals(strval($expected2), $ans2);
    }

    // --------------------------------------------------------------------

    /**
     * @covers \TBali\Aoc2015\Aoc2015Day05
     */
    public function testDay05Example1(): void
    {
        $solver = new Aoc2015Day05();
        $baseFileName = 'input/' . $solver::YEAR . '/Aoc' . $solver::YEAR . 'Day'
            . str_pad(strval($solver::DAY), 2, '0', STR_PAD_LEFT);
        $input = $solver->readInput($baseFileName . 'ex1.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::EXAMPLE_SOLUTIONS[0];
        $this->assertEquals(strval($expected1), $ans1);
        // $this->assertEquals(strval($expected2), $ans2);
    }

    /**
     * @covers \TBali\Aoc2015\Aoc2015Day05
     */
    public function testDay05Example2(): void
    {
        $solver = new Aoc2015Day05();
        $baseFileName = 'input/' . $solver::YEAR . '/Aoc' . $solver::YEAR . 'Day'
            . str_pad(strval($solver::DAY), 2, '0', STR_PAD_LEFT);
        $input = $solver->readInput($baseFileName . 'ex2.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::EXAMPLE_SOLUTIONS[1];
        // $this->assertEquals(strval($expected1), $ans1);
        $this->assertEquals(strval($expected2), $ans2);
    }

    /**
     * @covers \TBali\Aoc2015\Aoc2015Day05
     */
    public function testDay05(): void
    {
        $solver = new Aoc2015Day05();
        $baseFileName = 'input/' . $solver::YEAR . '/Aoc' . $solver::YEAR . 'Day'
            . str_pad(strval($solver::DAY), 2, '0', STR_PAD_LEFT);
        $input = $solver->readInput($baseFileName . '.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::SOLUTIONS;
        $this->assertEquals(strval($expected1), $ans1);
        $this->assertEquals(strval($expected2), $ans2);
    }

    // --------------------------------------------------------------------

    /**
     * @covers \TBali\Aoc2015\Aoc2015Day06
     * @covers \TBali\Aoc2015\Instruction
     */
    public function testDay06Example1(): void
    {
        $this->markTestSkipped();
        $solver = new Aoc2015Day06();
        $input = [$solver::EXAMPLE_STRING_INPUTS[0]];
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::EXAMPLE_SOLUTIONS[0];
        $this->assertEquals(strval($expected1), $ans1);
        $this->assertEquals(strval($expected2), $ans2);
    }

    /**
     * @covers \TBali\Aoc2015\Aoc2015Day06
     * @covers \TBali\Aoc2015\Instruction
     */
    public function testDay06Example2(): void
    {
        $solver = new Aoc2015Day06();
        $input = [$solver::EXAMPLE_STRING_INPUTS[1]];
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::EXAMPLE_SOLUTIONS[1];
        $this->assertEquals(strval($expected1), $ans1);
        $this->assertEquals(strval($expected2), $ans2);
    }

    /**
     * @covers \TBali\Aoc2015\Aoc2015Day06
     * @covers \TBali\Aoc2015\Instruction
     */
    public function testDay06(): void
    {
        $this->markTestSkipped();
        $solver = new Aoc2015Day06();
        $baseFileName = 'input/' . $solver::YEAR . '/Aoc' . $solver::YEAR . 'Day'
            . str_pad(strval($solver::DAY), 2, '0', STR_PAD_LEFT);
        $input = $solver->readInput($baseFileName . '.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::SOLUTIONS;
        $this->assertEquals(strval($expected1), $ans1);
        $this->assertEquals(strval($expected2), $ans2);
    }

    // --------------------------------------------------------------------

    /**
     * @covers \TBali\Aoc2015\Aoc2015Day07
     * @covers \TBali\Aoc2015\Circuit
     * @covers \TBali\Aoc2015\Gate
     */
    public function testDay07Example1(): void
    {
        $solver = new Aoc2015Day07();
        $baseFileName = 'input/' . $solver::YEAR . '/Aoc' . $solver::YEAR . 'Day'
            . str_pad(strval($solver::DAY), 2, '0', STR_PAD_LEFT);
        $input = $solver->readInput($baseFileName . 'ex1.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::EXAMPLE_SOLUTIONS[0];
        $this->assertEquals(strval($expected1), $ans1);
        // $this->assertEquals(strval($expected2), $ans2);
    }

    /**
     * @covers \TBali\Aoc2015\Aoc2015Day07
     * @covers \TBali\Aoc2015\Circuit
     * @covers \TBali\Aoc2015\Gate
     */
    public function testDay07(): void
    {
        $solver = new Aoc2015Day07();
        $baseFileName = 'input/' . $solver::YEAR . '/Aoc' . $solver::YEAR . 'Day'
            . str_pad(strval($solver::DAY), 2, '0', STR_PAD_LEFT);
        $input = $solver->readInput($baseFileName . '.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::SOLUTIONS;
        $this->assertEquals(strval($expected1), $ans1);
        $this->assertEquals(strval($expected2), $ans2);
    }

    // --------------------------------------------------------------------

    /**
     * @covers \TBali\Aoc2015\Aoc2015Day08
     */
    public function testDay08Example1(): void
    {
        $solver = new Aoc2015Day08();
        $baseFileName = 'input/' . $solver::YEAR . '/Aoc' . $solver::YEAR . 'Day'
            . str_pad(strval($solver::DAY), 2, '0', STR_PAD_LEFT);
        $input = $solver->readInput($baseFileName . 'ex1.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::EXAMPLE_SOLUTIONS[0];
        $this->assertEquals(strval($expected1), $ans1);
        $this->assertEquals(strval($expected2), $ans2);
    }

    /**
     * @covers \TBali\Aoc2015\Aoc2015Day08
     */
    public function testDay08(): void
    {
        $solver = new Aoc2015Day08();
        $baseFileName = 'input/' . $solver::YEAR . '/Aoc' . $solver::YEAR . 'Day'
            . str_pad(strval($solver::DAY), 2, '0', STR_PAD_LEFT);
        $input = $solver->readInput($baseFileName . '.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::SOLUTIONS;
        $this->assertEquals(strval($expected1), $ans1);
        $this->assertEquals(strval($expected2), $ans2);
    }

    // --------------------------------------------------------------------

    /**
     * @covers \TBali\Aoc2015\Aoc2015Day09
     * @covers \TBali\Aoc2015\CityGraph
     */
    public function testDay09Example1(): void
    {
        $solver = new Aoc2015Day09();
        $baseFileName = 'input/' . $solver::YEAR . '/Aoc' . $solver::YEAR . 'Day'
            . str_pad(strval($solver::DAY), 2, '0', STR_PAD_LEFT);
        $input = $solver->readInput($baseFileName . 'ex1.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::EXAMPLE_SOLUTIONS[0];
        $this->assertEquals(strval($expected1), $ans1);
        $this->assertEquals(strval($expected2), $ans2);
    }

    /**
     * @covers \TBali\Aoc2015\Aoc2015Day09
     * @covers \TBali\Aoc2015\CityGraph
     */
    public function testDay09(): void
    {
        $solver = new Aoc2015Day09();
        $baseFileName = 'input/' . $solver::YEAR . '/Aoc' . $solver::YEAR . 'Day'
            . str_pad(strval($solver::DAY), 2, '0', STR_PAD_LEFT);
        $input = $solver->readInput($baseFileName . '.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::SOLUTIONS;
        $this->assertEquals(strval($expected1), $ans1);
        $this->assertEquals(strval($expected2), $ans2);
    }

    // --------------------------------------------------------------------
    // Day 10 tests are too slow, so disabled

    /**
     * @covers \TBali\Aoc2015\Aoc2015Day10
     */
    public function testDay10Example1(): void
    {
        $this->markTestSkipped();
        $solver = new Aoc2015Day10();
        $input = [$solver::EXAMPLE_STRING_INPUTS[0]];
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::EXAMPLE_SOLUTIONS[0];
        $this->assertEquals(strval($expected1), $ans1);
        // $this->assertEquals(strval($expected2), $ans2);
    }

    /**
     * @covers \TBali\Aoc2015\Aoc2015Day10
     */
    public function testDay10(): void
    {
        $this->markTestSkipped();
        $solver = new Aoc2015Day10();
        $input = [$solver::STRING_INPUT];
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::SOLUTIONS;
        $this->assertEquals(strval($expected1), $ans1);
        $this->assertEquals(strval($expected2), $ans2);
    }

    // --------------------------------------------------------------------

    /**
     * @covers \TBali\Aoc2015\Aoc2015Day11
     */
    public function testDay11Example1(): void
    {
        $solver = new Aoc2015Day11();
        $input = [$solver::EXAMPLE_STRING_INPUTS[0]];
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::EXAMPLE_SOLUTIONS[0];
        $this->assertEquals(strval($expected1), $ans1);
        // $this->assertEquals(strval($expected2), $ans2);
    }

    /**
     * @covers \TBali\Aoc2015\Aoc2015Day11
     */
    public function testDay11(): void
    {
        $this->markTestSkipped();
        $solver = new Aoc2015Day11();
        $input = [$solver::STRING_INPUT];
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::SOLUTIONS;
        $this->assertEquals(strval($expected1), $ans1);
        $this->assertEquals(strval($expected2), $ans2);
    }

    // --------------------------------------------------------------------

    /**
     * @covers \TBali\Aoc2015\Aoc2015Day12
     */
    public function testDay12Example1(): void
    {
        $solver = new Aoc2015Day12();
        $baseFileName = 'input/' . $solver::YEAR . '/Aoc' . $solver::YEAR . 'Day'
            . str_pad(strval($solver::DAY), 2, '0', STR_PAD_LEFT);
        $input = $solver->readInput($baseFileName . 'ex1.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::EXAMPLE_SOLUTIONS[0];
        $this->assertEquals(strval($expected1), $ans1);
        // $this->assertEquals(strval($expected2), $ans2);
    }

    /**
     * @covers \TBali\Aoc2015\Aoc2015Day12
     */
    public function testDay12Example2(): void
    {
        $solver = new Aoc2015Day12();
        $baseFileName = 'input/' . $solver::YEAR . '/Aoc' . $solver::YEAR . 'Day'
            . str_pad(strval($solver::DAY), 2, '0', STR_PAD_LEFT);
        $input = $solver->readInput($baseFileName . 'ex2.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::EXAMPLE_SOLUTIONS[1];
        // $this->assertEquals(strval($expected1), $ans1);
        $this->assertEquals(strval($expected2), $ans2);
    }

    /**
     * @covers \TBali\Aoc2015\Aoc2015Day12
     */
    public function testDay12(): void
    {
        $solver = new Aoc2015Day12();
        $baseFileName = 'input/' . $solver::YEAR . '/Aoc' . $solver::YEAR . 'Day'
            . str_pad(strval($solver::DAY), 2, '0', STR_PAD_LEFT);
        $input = $solver->readInput($baseFileName . '.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::SOLUTIONS;
        $this->assertEquals(strval($expected1), $ans1);
        $this->assertEquals(strval($expected2), $ans2);
    }

    // --------------------------------------------------------------------

    /**
     * @covers \TBali\Aoc2015\Aoc2015Day13
     * @covers \TBali\Aoc2015\KnightsTable
     */
    public function testDay13Example1(): void
    {
        $solver = new Aoc2015Day13();
        $baseFileName = 'input/' . $solver::YEAR . '/Aoc' . $solver::YEAR . 'Day'
            . str_pad(strval($solver::DAY), 2, '0', STR_PAD_LEFT);
        $input = $solver->readInput($baseFileName . 'ex1.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::EXAMPLE_SOLUTIONS[0];
        $this->assertEquals(strval($expected1), $ans1);
        // $this->assertEquals(strval($expected2), $ans2);
    }

    /**
     * @covers \TBali\Aoc2015\Aoc2015Day13
     * @covers \TBali\Aoc2015\KnightsTable
     */
    public function testDay13(): void
    {
        $solver = new Aoc2015Day13();
        $baseFileName = 'input/' . $solver::YEAR . '/Aoc' . $solver::YEAR . 'Day'
            . str_pad(strval($solver::DAY), 2, '0', STR_PAD_LEFT);
        $input = $solver->readInput($baseFileName . '.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::SOLUTIONS;
        $this->assertEquals(strval($expected1), $ans1);
        $this->assertEquals(strval($expected2), $ans2);
    }

    // --------------------------------------------------------------------

    /**
     * @covers \TBali\Aoc2015\Aoc2015Day14
     * @covers \TBali\Aoc2015\Reindeer
     */
    public function testDay14Example1(): void
    {
        $solver = new Aoc2015Day14();
        $baseFileName = 'input/' . $solver::YEAR . '/Aoc' . $solver::YEAR . 'Day'
            . str_pad(strval($solver::DAY), 2, '0', STR_PAD_LEFT);
        $input = $solver->readInput($baseFileName . 'ex1.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::EXAMPLE_SOLUTIONS[0];
        $this->assertEquals(strval($expected1), $ans1);
        $this->assertEquals(strval($expected2), $ans2);
    }

    /**
     * @covers \TBali\Aoc2015\Aoc2015Day14
     * @covers \TBali\Aoc2015\Reindeer
     */
    public function testDay14(): void
    {
        $solver = new Aoc2015Day14();
        $baseFileName = 'input/' . $solver::YEAR . '/Aoc' . $solver::YEAR . 'Day'
            . str_pad(strval($solver::DAY), 2, '0', STR_PAD_LEFT);
        $input = $solver->readInput($baseFileName . '.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::SOLUTIONS;
        $this->assertEquals(strval($expected1), $ans1);
        $this->assertEquals(strval($expected2), $ans2);
    }

    // --------------------------------------------------------------------

    /**
     * @covers \TBali\Aoc2015\Aoc2015Day15
     */
    public function testDay15Example1(): void
    {
        $solver = new Aoc2015Day15();
        $baseFileName = 'input/' . $solver::YEAR . '/Aoc' . $solver::YEAR . 'Day'
            . str_pad(strval($solver::DAY), 2, '0', STR_PAD_LEFT);
        $input = $solver->readInput($baseFileName . 'ex1.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::EXAMPLE_SOLUTIONS[0];
        $this->assertEquals(strval($expected1), $ans1);
        $this->assertEquals(strval($expected2), $ans2);
    }

    /**
     * @covers \TBali\Aoc2015\Aoc2015Day15
     */
    public function testDay15(): void
    {
        $this->markTestSkipped();
        $solver = new Aoc2015Day15();
        $baseFileName = 'input/' . $solver::YEAR . '/Aoc' . $solver::YEAR . 'Day'
            . str_pad(strval($solver::DAY), 2, '0', STR_PAD_LEFT);
        $input = $solver->readInput($baseFileName . '.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::SOLUTIONS;
        $this->assertEquals(strval($expected1), $ans1);
        $this->assertEquals(strval($expected2), $ans2);
    }

    // --------------------------------------------------------------------

    /**
     * @covers \TBali\Aoc2015\Aoc2015Day16
     */
    public function testDay16(): void
    {
        $solver = new Aoc2015Day16();
        $baseFileName = 'input/' . $solver::YEAR . '/Aoc' . $solver::YEAR . 'Day'
            . str_pad(strval($solver::DAY), 2, '0', STR_PAD_LEFT);
        $input = $solver->readInput($baseFileName . '.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::SOLUTIONS;
        $this->assertEquals(strval($expected1), $ans1);
        $this->assertEquals(strval($expected2), $ans2);
    }

    // --------------------------------------------------------------------

    /**
     * @covers \TBali\Aoc2015\Aoc2015Day17
     */
    public function testDay17Example1(): void
    {
        $solver = new Aoc2015Day17();
        $baseFileName = 'input/' . $solver::YEAR . '/Aoc' . $solver::YEAR . 'Day'
            . str_pad(strval($solver::DAY), 2, '0', STR_PAD_LEFT);
        $input = $solver->readInput($baseFileName . 'ex1.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::EXAMPLE_SOLUTIONS[0];
        $this->assertEquals(strval($expected1), $ans1);
        $this->assertEquals(strval($expected2), $ans2);
    }

    /**
     * @covers \TBali\Aoc2015\Aoc2015Day17
     */
    public function testDay17(): void
    {
        $solver = new Aoc2015Day17();
        $baseFileName = 'input/' . $solver::YEAR . '/Aoc' . $solver::YEAR . 'Day'
            . str_pad(strval($solver::DAY), 2, '0', STR_PAD_LEFT);
        $input = $solver->readInput($baseFileName . '.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::SOLUTIONS;
        $this->assertEquals(strval($expected1), $ans1);
        $this->assertEquals(strval($expected2), $ans2);
    }

    // --------------------------------------------------------------------

    /**
     * @covers \TBali\Aoc2015\Aoc2015Day18
     */
    public function testDay18Example1(): void
    {
        $solver = new Aoc2015Day18();
        $baseFileName = 'input/' . $solver::YEAR . '/Aoc' . $solver::YEAR . 'Day'
            . str_pad(strval($solver::DAY), 2, '0', STR_PAD_LEFT);
        $input = $solver->readInput($baseFileName . 'ex1.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::EXAMPLE_SOLUTIONS[0];
        $this->assertEquals(strval($expected1), $ans1);
        $this->assertEquals(strval($expected2), $ans2);
    }

    /**
     * @covers \TBali\Aoc2015\Aoc2015Day18
     */
    public function testDay18(): void
    {
        $this->markTestSkipped();
        $solver = new Aoc2015Day18();
        $baseFileName = 'input/' . $solver::YEAR . '/Aoc' . $solver::YEAR . 'Day'
            . str_pad(strval($solver::DAY), 2, '0', STR_PAD_LEFT);
        $input = $solver->readInput($baseFileName . '.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::SOLUTIONS;
        $this->assertEquals(strval($expected1), $ans1);
        $this->assertEquals(strval($expected2), $ans2);
    }

    // --------------------------------------------------------------------

    /**
     * @covers \TBali\Aoc2015\Aoc2015Day19
     */
    public function testDay19(): void
    {
        $solver = new Aoc2015Day19();
        $baseFileName = 'input/' . $solver::YEAR . '/Aoc' . $solver::YEAR . 'Day'
            . str_pad(strval($solver::DAY), 2, '0', STR_PAD_LEFT);
        $input = $solver->readInput($baseFileName . '.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::SOLUTIONS;
        $this->assertEquals(strval($expected1), $ans1);
        $this->assertEquals(strval($expected2), $ans2);
    }

    // --------------------------------------------------------------------

    /**
     * @covers \TBali\Aoc2015\Aoc2015Day20
     */
    public function testDay20Example1(): void
    {
        $solver = new Aoc2015Day20();
        $input = [$solver::EXAMPLE_STRING_INPUTS[0]];
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::EXAMPLE_SOLUTIONS[0];
        $this->assertEquals(strval($expected1), $ans1);
        // $this->assertEquals(strval($expected2), $ans2);
    }

    /**
     * @covers \TBali\Aoc2015\Aoc2015Day20
     */
    public function testDay20Example2(): void
    {
        $solver = new Aoc2015Day20();
        $input = [$solver::EXAMPLE_STRING_INPUTS[1]];
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::EXAMPLE_SOLUTIONS[1];
        $this->assertEquals(strval($expected1), $ans1);
        // $this->assertEquals(strval($expected2), $ans2);
    }

    /**
     * @covers \TBali\Aoc2015\Aoc2015Day20
     */
    public function testDay20(): void
    {
        $this->markTestSkipped();
        $solver = new Aoc2015Day20();
        $input = [$solver::STRING_INPUT];
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::SOLUTIONS;
        $this->assertEquals(strval($expected1), $ans1);
        $this->assertEquals(strval($expected2), $ans2);
    }

    // --------------------------------------------------------------------

    /**
     * @covers \TBali\Aoc2015\Aoc2015Day21
     * @covers \TBali\Aoc2015\Character
     */
    public function testDay21(): void
    {
        $solver = new Aoc2015Day21();
        $baseFileName = 'input/' . $solver::YEAR . '/Aoc' . $solver::YEAR . 'Day'
            . str_pad(strval($solver::DAY), 2, '0', STR_PAD_LEFT);
        $input = $solver->readInput($baseFileName . '.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::SOLUTIONS;
        $this->assertEquals(strval($expected1), $ans1);
        $this->assertEquals(strval($expected2), $ans2);
    }

    // --------------------------------------------------------------------

    /**
     * @covers \TBali\Aoc2015\Aoc2015Day22
     * @covers \TBali\Aoc2015\WizardGameState
     * @covers \TBali\Aoc2015\WizardSimulator
     * @covers \TBali\Aoc2015\WizardSimulatorHardMode
     */
    public function testDay22(): void
    {
        $solver = new Aoc2015Day22();
        $baseFileName = 'input/' . $solver::YEAR . '/Aoc' . $solver::YEAR . 'Day'
            . str_pad(strval($solver::DAY), 2, '0', STR_PAD_LEFT);
        $input = $solver->readInput($baseFileName . '.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::SOLUTIONS;
        $this->assertEquals(strval($expected1), $ans1);
        $this->assertEquals(strval($expected2), $ans2);
    }

    // --------------------------------------------------------------------

    /**
     * @covers \TBali\Aoc2015\Aoc2015Day23
     */
    public function testDay23Example1(): void
    {
        $solver = new Aoc2015Day23();
        $baseFileName = 'input/' . $solver::YEAR . '/Aoc' . $solver::YEAR . 'Day'
            . str_pad(strval($solver::DAY), 2, '0', STR_PAD_LEFT);
        $input = $solver->readInput($baseFileName . 'ex1.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::EXAMPLE_SOLUTIONS[0];
        $this->assertEquals(strval($expected1), $ans1);
        $this->assertEquals(strval($expected2), $ans2);
    }

    /**
     * @covers \TBali\Aoc2015\Aoc2015Day23
     */
    public function testDay23(): void
    {
        $solver = new Aoc2015Day23();
        $baseFileName = 'input/' . $solver::YEAR . '/Aoc' . $solver::YEAR . 'Day'
            . str_pad(strval($solver::DAY), 2, '0', STR_PAD_LEFT);
        $input = $solver->readInput($baseFileName . '.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::SOLUTIONS;
        $this->assertEquals(strval($expected1), $ans1);
        $this->assertEquals(strval($expected2), $ans2);
    }

    // --------------------------------------------------------------------

    /**
     * @covers \TBali\Aoc2015\Aoc2015Day24
     */
    public function testDay24Example1(): void
    {
        $solver = new Aoc2015Day24();
        $baseFileName = 'input/' . $solver::YEAR . '/Aoc' . $solver::YEAR . 'Day'
            . str_pad(strval($solver::DAY), 2, '0', STR_PAD_LEFT);
        $input = $solver->readInput($baseFileName . 'ex1.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::EXAMPLE_SOLUTIONS[0];
        $this->assertEquals(strval($expected1), $ans1);
        $this->assertEquals(strval($expected2), $ans2);
    }

    /**
     * @covers \TBali\Aoc2015\Aoc2015Day24
     */
    public function testDay24(): void
    {
        $solver = new Aoc2015Day24();
        $baseFileName = 'input/' . $solver::YEAR . '/Aoc' . $solver::YEAR . 'Day'
            . str_pad(strval($solver::DAY), 2, '0', STR_PAD_LEFT);
        $input = $solver->readInput($baseFileName . '.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::SOLUTIONS;
        $this->assertEquals(strval($expected1), $ans1);
        $this->assertEquals(strval($expected2), $ans2);
    }

    // --------------------------------------------------------------------

    /**
     * @covers \TBali\Aoc2015\Aoc2015Day25
     */
    public function testDay25Example1(): void
    {
        $solver = new Aoc2015Day25();
        $baseFileName = 'input/' . $solver::YEAR . '/Aoc' . $solver::YEAR . 'Day'
            . str_pad(strval($solver::DAY), 2, '0', STR_PAD_LEFT);
        $input = $solver->readInput($baseFileName . 'ex1.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::EXAMPLE_SOLUTIONS[0];
        $this->assertEquals(strval($expected1), $ans1);
        // $this->assertEquals(strval($expected2), $ans2);
    }

    /**
     * @covers \TBali\Aoc2015\Aoc2015Day25
     */
    public function testDay25Example2(): void
    {
        $solver = new Aoc2015Day25();
        $baseFileName = 'input/' . $solver::YEAR . '/Aoc' . $solver::YEAR . 'Day'
            . str_pad(strval($solver::DAY), 2, '0', STR_PAD_LEFT);
        $input = $solver->readInput($baseFileName . 'ex2.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::EXAMPLE_SOLUTIONS[1];
        $this->assertEquals(strval($expected1), $ans1);
        // $this->assertEquals(strval($expected2), $ans2);
    }

    /**
     * @covers \TBali\Aoc2015\Aoc2015Day25
     */
    public function testDay25(): void
    {
        $this->markTestSkipped();
        $solver = new Aoc2015Day25();
        $baseFileName = 'input/' . $solver::YEAR . '/Aoc' . $solver::YEAR . 'Day'
            . str_pad(strval($solver::DAY), 2, '0', STR_PAD_LEFT);
        $input = $solver->readInput($baseFileName . '.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::SOLUTIONS;
        $this->assertEquals(strval($expected1), $ans1);
        // $this->assertEquals(strval($expected2), $ans2);
    }

    // --------------------------------------------------------------------
}
