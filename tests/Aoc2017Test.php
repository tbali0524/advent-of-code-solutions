<?php

declare(strict_types=1);

namespace TBali\Tests;

use PHPUnit\Framework\TestCase;
use TBali\Aoc2017\Aoc2017Day01;
use TBali\Aoc2017\Aoc2017Day02;
use TBali\Aoc2017\Aoc2017Day03;
use TBali\Aoc2017\Aoc2017Day04;
use TBali\Aoc2017\Aoc2017Day05;
use TBali\Aoc2017\Aoc2017Day06;
use TBali\Aoc2017\Aoc2017Day07;
use TBali\Aoc2017\Aoc2017Day08;
use TBali\Aoc2017\Aoc2017Day09;
use TBali\Aoc2017\Aoc2017Day10;
use TBali\Aoc2017\Aoc2017Day11;
use TBali\Aoc2017\Aoc2017Day12;
use TBali\Aoc2017\Aoc2017Day13;
use TBali\Aoc2017\Aoc2017Day14;
use TBali\Aoc2017\Aoc2017Day15;
use TBali\Aoc2017\Aoc2017Day16;
use TBali\Aoc2017\Aoc2017Day17;
use TBali\Aoc2017\Aoc2017Day18;
use TBali\Aoc2017\Aoc2017Day19;
use TBali\Aoc2017\Aoc2017Day20;
// use TBali\Aoc2017\Aoc2017Day21;
// use TBali\Aoc2017\Aoc2017Day22;
use TBali\Aoc2017\Aoc2017Day23;

// use TBali\Aoc2017\Aoc2017Day24;
// use TBali\Aoc2017\Aoc2017Day25;

/**
 * Unit tests for Advent of Code season 2017.
 *
 * Instead of using this file with phpunit, it is a better way to run the solutions by using AoCRunner.
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

    /**
     * @covers \TBali\Aoc2017\Aoc2017Day06
     */
    public function testDay06Example1(): void
    {
        $solver = new Aoc2017Day06();
        $input = $solver->readInput($solver->inputBaseFileName() . 'ex1.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::EXAMPLE_SOLUTIONS[0];
        $this->assertEquals(strval($expected1), $ans1);
        $this->assertEquals(strval($expected2), $ans2);
    }

    /**
     * @covers \TBali\Aoc2017\Aoc2017Day06
     */
    public function testDay06(): void
    {
        $solver = new Aoc2017Day06();
        $input = $solver->readInput($solver->inputBaseFileName() . '.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::SOLUTIONS;
        $this->assertEquals(strval($expected1), $ans1);
        $this->assertEquals(strval($expected2), $ans2);
    }

    // --------------------------------------------------------------------

    /**
     * @covers \TBali\Aoc2017\Aoc2017Day07
     */
    public function testDay07Example1(): void
    {
        $solver = new Aoc2017Day07();
        $input = $solver->readInput($solver->inputBaseFileName() . 'ex1.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::EXAMPLE_SOLUTIONS[0];
        $this->assertEquals(strval($expected1), $ans1);
        $this->assertEquals(strval($expected2), $ans2);
    }

    /**
     * @covers \TBali\Aoc2017\Aoc2017Day07
     */
    public function testDay07(): void
    {
        $solver = new Aoc2017Day07();
        $input = $solver->readInput($solver->inputBaseFileName() . '.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::SOLUTIONS;
        $this->assertEquals(strval($expected1), $ans1);
        $this->assertEquals(strval($expected2), $ans2);
    }

    /**
     * @covers \TBali\Aoc2017\Aoc2017Day07
     */
    public function testDay07InvalidInput1(): void
    {
        $solver = new Aoc2017Day07();
        $input = ['a (1) -> b -> c'];
        $this->expectException(\Exception::class);
        [$ans1, $ans2] = $solver->solve($input);
    }

    /**
     * @covers \TBali\Aoc2017\Aoc2017Day07
     */
    public function testDay07InvalidInput2(): void
    {
        $solver = new Aoc2017Day07();
        $input = ['a -> b'];
        $this->expectException(\Exception::class);
        [$ans1, $ans2] = $solver->solve($input);
    }

    // --------------------------------------------------------------------

    /**
     * @covers \TBali\Aoc2017\Aoc2017Day08
     */
    public function testDay08Example1(): void
    {
        $solver = new Aoc2017Day08();
        $input = $solver->readInput($solver->inputBaseFileName() . 'ex1.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::EXAMPLE_SOLUTIONS[0];
        $this->assertEquals(strval($expected1), $ans1);
        $this->assertEquals(strval($expected2), $ans2);
    }

    /**
     * @covers \TBali\Aoc2017\Aoc2017Day08
     */
    public function testDay08(): void
    {
        $solver = new Aoc2017Day08();
        $input = $solver->readInput($solver->inputBaseFileName() . '.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::SOLUTIONS;
        $this->assertEquals(strval($expected1), $ans1);
        $this->assertEquals(strval($expected2), $ans2);
    }

    /**
     * @covers \TBali\Aoc2017\Aoc2017Day08
     */
    public function testDay08InvalidInput1(): void
    {
        $solver = new Aoc2017Day08();
        $input = ['a'];
        $this->expectException(\Exception::class);
        [$ans1, $ans2] = $solver->solve($input);
    }

    /**
     * @covers \TBali\Aoc2017\Aoc2017Day08
     */
    public function testDay08InvalidInput2(): void
    {
        $solver = new Aoc2017Day08();
        $input = ['a inc 1 if b lt 1'];
        $this->expectException(\Exception::class);
        [$ans1, $ans2] = $solver->solve($input);
    }

    /**
     * @covers \TBali\Aoc2017\Aoc2017Day08
     */
    public function testDay08InvalidInput3(): void
    {
        $solver = new Aoc2017Day08();
        $input = ['a set 1 if b < 1'];
        $this->expectException(\Exception::class);
        [$ans1, $ans2] = $solver->solve($input);
    }

    // --------------------------------------------------------------------

    /**
     * @covers \TBali\Aoc2017\Aoc2017Day09
     */
    public function testDay09Example1(): void
    {
        $solver = new Aoc2017Day09();
        $input = $solver->readInput($solver->inputBaseFileName() . 'ex1.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::EXAMPLE_SOLUTIONS[0];
        $this->assertEquals(strval($expected1), $ans1);
        // $this->assertEquals(strval($expected2), $ans2);
    }

    /**
     * @covers \TBali\Aoc2017\Aoc2017Day09
     */
    public function testDay09Example2(): void
    {
        $solver = new Aoc2017Day09();
        $input = $solver->readInput($solver->inputBaseFileName() . 'ex2.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::EXAMPLE_SOLUTIONS[1];
        // $this->assertEquals(strval($expected1), $ans1);
        $this->assertEquals(strval($expected2), $ans2);
    }

    /**
     * @covers \TBali\Aoc2017\Aoc2017Day09
     */
    public function testDay09(): void
    {
        $solver = new Aoc2017Day09();
        $input = $solver->readInput($solver->inputBaseFileName() . '.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::SOLUTIONS;
        $this->assertEquals(strval($expected1), $ans1);
        $this->assertEquals(strval($expected2), $ans2);
    }

    // --------------------------------------------------------------------

    /**
     * @covers \TBali\Aoc2017\Aoc2017Day10
     */
    public function testDay10Example1(): void
    {
        $solver = new Aoc2017Day10();
        $input = [$solver::EXAMPLE_STRING_INPUTS[0]];
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::EXAMPLE_SOLUTIONS[0];
        $this->assertEquals(strval($expected1), $ans1);
        // $this->assertEquals(strval($expected2), $ans2);
    }

    /**
     * @covers \TBali\Aoc2017\Aoc2017Day10
     */
    public function testDay10Example2(): void
    {
        $solver = new Aoc2017Day10();
        $input = [$solver::EXAMPLE_STRING_INPUTS[1]];
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::EXAMPLE_SOLUTIONS[1];
        // $this->assertEquals(strval($expected1), $ans1);
        $this->assertEquals(strval($expected2), $ans2);
    }

    /**
     * @covers \TBali\Aoc2017\Aoc2017Day10
     */
    public function testDay10(): void
    {
        $solver = new Aoc2017Day10();
        $input = $solver->readInput($solver->inputBaseFileName() . '.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::SOLUTIONS;
        $this->assertEquals(strval($expected1), $ans1);
        $this->assertEquals(strval($expected2), $ans2);
    }

    /**
     * @covers \TBali\Aoc2017\Aoc2017Day10
     */
    public function testDay10InvalidInput1(): void
    {
        $solver = new Aoc2017Day10();
        $input = ['257'];
        $this->expectException(\Exception::class);
        [$ans1, $ans2] = $solver->solve($input);
    }

    // --------------------------------------------------------------------

    /**
     * @covers \TBali\Aoc2017\Aoc2017Day11
     */
    public function testDay11Example1(): void
    {
        $solver = new Aoc2017Day11();
        $input = [$solver::EXAMPLE_STRING_INPUTS[0]];
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::EXAMPLE_SOLUTIONS[0];
        $this->assertEquals(strval($expected1), $ans1);
        $this->assertEquals(strval($expected2), $ans2);
    }

    /**
     * @covers \TBali\Aoc2017\Aoc2017Day11
     */
    public function testDay11Example2(): void
    {
        $solver = new Aoc2017Day11();
        $input = [$solver::EXAMPLE_STRING_INPUTS[1]];
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::EXAMPLE_SOLUTIONS[1];
        $this->assertEquals(strval($expected1), $ans1);
        $this->assertEquals(strval($expected2), $ans2);
    }

    /**
     * @covers \TBali\Aoc2017\Aoc2017Day11
     */
    public function testDay11Example3(): void
    {
        $solver = new Aoc2017Day11();
        $input = [$solver::EXAMPLE_STRING_INPUTS[2]];
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::EXAMPLE_SOLUTIONS[2];
        $this->assertEquals(strval($expected1), $ans1);
        $this->assertEquals(strval($expected2), $ans2);
    }

    /**
     * @covers \TBali\Aoc2017\Aoc2017Day11
     */
    public function testDay11(): void
    {
        $solver = new Aoc2017Day11();
        $input = $solver->readInput($solver->inputBaseFileName() . '.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::SOLUTIONS;
        $this->assertEquals(strval($expected1), $ans1);
        $this->assertEquals(strval($expected2), $ans2);
    }

    /**
     * @covers \TBali\Aoc2017\Aoc2017Day11
     */
    public function testDay11InvalidInput1(): void
    {
        $solver = new Aoc2017Day11();
        $input = ['w'];
        $this->expectException(\Exception::class);
        [$ans1, $ans2] = $solver->solve($input);
    }

    // --------------------------------------------------------------------

    /**
     * @covers \TBali\Aoc2017\Aoc2017Day12
     */
    public function testDay12Example1(): void
    {
        $solver = new Aoc2017Day12();
        $input = $solver->readInput($solver->inputBaseFileName() . 'ex1.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::EXAMPLE_SOLUTIONS[0];
        $this->assertEquals(strval($expected1), $ans1);
        $this->assertEquals(strval($expected2), $ans2);
    }

    /**
     * @covers \TBali\Aoc2017\Aoc2017Day12
     */
    public function testDay12(): void
    {
        $solver = new Aoc2017Day12();
        $input = $solver->readInput($solver->inputBaseFileName() . '.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::SOLUTIONS;
        $this->assertEquals(strval($expected1), $ans1);
        $this->assertEquals(strval($expected2), $ans2);
    }

    // --------------------------------------------------------------------

    /**
     * @covers \TBali\Aoc2017\Aoc2017Day13
     */
    public function testDay13Example1(): void
    {
        $solver = new Aoc2017Day13();
        $input = $solver->readInput($solver->inputBaseFileName() . 'ex1.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::EXAMPLE_SOLUTIONS[0];
        $this->assertEquals(strval($expected1), $ans1);
        $this->assertEquals(strval($expected2), $ans2);
    }

    /**
     * @covers \TBali\Aoc2017\Aoc2017Day13
     */
    public function testDay13(): void
    {
        $solver = new Aoc2017Day13();
        $input = $solver->readInput($solver->inputBaseFileName() . '.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::SOLUTIONS;
        $this->assertEquals(strval($expected1), $ans1);
        $this->assertEquals(strval($expected2), $ans2);
    }

    /**
     * @covers \TBali\Aoc2017\Aoc2017Day13
     */
    public function testDay13InvalidInput1(): void
    {
        $solver = new Aoc2017Day13();
        $input = ['0'];
        $this->expectException(\Exception::class);
        [$ans1, $ans2] = $solver->solve($input);
    }

    // --------------------------------------------------------------------

    /**
     * @covers \TBali\Aoc2017\Aoc2017Day14
     */
    public function testDay14Example1(): void
    {
        $this->markTestSkipped();
        $solver = new Aoc2017Day14();
        $input = [$solver::EXAMPLE_STRING_INPUTS[0]];
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::EXAMPLE_SOLUTIONS[0];
        $this->assertEquals(strval($expected1), $ans1);
        $this->assertEquals(strval($expected2), $ans2);
    }

    /**
     * @covers \TBali\Aoc2017\Aoc2017Day14
     */
    public function testDay14(): void
    {
        $this->markTestSkipped();
        $solver = new Aoc2017Day14();
        $input = [$solver::STRING_INPUT];
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::SOLUTIONS;
        $this->assertEquals(strval($expected1), $ans1);
        $this->assertEquals(strval($expected2), $ans2);
    }

    // --------------------------------------------------------------------

    /**
     * @covers \TBali\Aoc2017\Aoc2017Day15
     */
    public function testDay15Example1(): void
    {
        $this->markTestSkipped();
        $solver = new Aoc2017Day15();
        $input = $solver->readInput($solver->inputBaseFileName() . 'ex1.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::EXAMPLE_SOLUTIONS[0];
        $this->assertEquals(strval($expected1), $ans1);
        $this->assertEquals(strval($expected2), $ans2);
    }

    /**
     * @covers \TBali\Aoc2017\Aoc2017Day15
     */
    public function testDay15(): void
    {
        $this->markTestSkipped();
        $solver = new Aoc2017Day15();
        $input = $solver->readInput($solver->inputBaseFileName() . '.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::SOLUTIONS;
        $this->assertEquals(strval($expected1), $ans1);
        $this->assertEquals(strval($expected2), $ans2);
    }

    /**
     * @covers \TBali\Aoc2017\Aoc2017Day15
     */
    public function testDay15InvalidInput1(): void
    {
        $solver = new Aoc2017Day15();
        $input = ['a'];
        $this->expectException(\Exception::class);
        [$ans1, $ans2] = $solver->solve($input);
    }

    // --------------------------------------------------------------------

    /**
     * @covers \TBali\Aoc2017\Aoc2017Day16
     */
    public function testDay16Example1(): void
    {
        $solver = new Aoc2017Day16();
        $input = $solver->readInput($solver->inputBaseFileName() . 'ex1.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::EXAMPLE_SOLUTIONS[0];
        $this->assertEquals(strval($expected1), $ans1);
        // $this->assertEquals(strval($expected2), $ans2);
    }

    /**
     * @covers \TBali\Aoc2017\Aoc2017Day16
     */
    public function testDay16(): void
    {
        $solver = new Aoc2017Day16();
        $input = $solver->readInput($solver->inputBaseFileName() . '.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::SOLUTIONS;
        $this->assertEquals(strval($expected1), $ans1);
        $this->assertEquals(strval($expected2), $ans2);
    }

    /**
     * @covers \TBali\Aoc2017\Aoc2017Day16
     */
    public function testDay16InvalidInput1(): void
    {
        $solver = new Aoc2017Day16();
        $input = ['a'];
        $this->expectException(\Exception::class);
        [$ans1, $ans2] = $solver->solve($input);
    }

    // --------------------------------------------------------------------

    /**
     * @covers \TBali\Aoc2017\Aoc2017Day17
     * @covers \TBali\Aoc2017\ListItem
     */
    public function testDay17Example1(): void
    {
        $solver = new Aoc2017Day17();
        $input = [$solver::EXAMPLE_STRING_INPUTS[0]];
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::EXAMPLE_SOLUTIONS[0];
        $this->assertEquals(strval($expected1), $ans1);
        // $this->assertEquals(strval($expected2), $ans2);
    }

    /**
     * @covers \TBali\Aoc2017\Aoc2017Day17
     * @covers \TBali\Aoc2017\ListItem
     */
    public function testDay17(): void
    {
        $this->markTestSkipped();
        $solver = new Aoc2017Day17();
        $input = [$solver::STRING_INPUT];
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::SOLUTIONS;
        $this->assertEquals(strval($expected1), $ans1);
        $this->assertEquals(strval($expected2), $ans2);
    }

    // --------------------------------------------------------------------

    /**
     * @covers \TBali\Aoc2017\Aoc2017Day18
     * @covers \TBali\Aoc2017\Thread
     */
    public function testDay18Example1(): void
    {
        $solver = new Aoc2017Day18();
        $input = $solver->readInput($solver->inputBaseFileName() . 'ex1.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::EXAMPLE_SOLUTIONS[0];
        $this->assertEquals(strval($expected1), $ans1);
        // $this->assertEquals(strval($expected2), $ans2);
    }

    /**
     * @covers \TBali\Aoc2017\Aoc2017Day18
     * @covers \TBali\Aoc2017\Thread
     */
    public function testDay18Example2(): void
    {
        $solver = new Aoc2017Day18();
        $input = $solver->readInput($solver->inputBaseFileName() . 'ex2.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::EXAMPLE_SOLUTIONS[1];
        // $this->assertEquals(strval($expected1), $ans1);
        $this->assertEquals(strval($expected2), $ans2);
    }

    /**
     * @covers \TBali\Aoc2017\Aoc2017Day18
     * @covers \TBali\Aoc2017\Thread
     */
    public function testDay18(): void
    {
        $solver = new Aoc2017Day18();
        $input = $solver->readInput($solver->inputBaseFileName() . '.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::SOLUTIONS;
        $this->assertEquals(strval($expected1), $ans1);
        $this->assertEquals(strval($expected2), $ans2);
    }

    /**
     * @covers \TBali\Aoc2017\Aoc2017Day18
     * @covers \TBali\Aoc2017\Thread
     */
    public function testDay18InvalidInput1(): void
    {
        $solver = new Aoc2017Day18();
        $input = ['a'];
        $this->expectException(\Exception::class);
        [$ans1, $ans2] = $solver->solve($input);
    }

    /**
     * @covers \TBali\Aoc2017\Aoc2017Day18
     * @covers \TBali\Aoc2017\Thread
     */
    public function testDay18InvalidInput2(): void
    {
        $solver = new Aoc2017Day18();
        $input = ['div 0'];
        $this->expectException(\Exception::class);
        [$ans1, $ans2] = $solver->solve($input);
    }

    /**
     * @covers \TBali\Aoc2017\Aoc2017Day18
     * @covers \TBali\Aoc2017\Thread
     */
    public function testDay18InvalidInput3(): void
    {
        $solver = new Aoc2017Day18();
        $input = ['div x 2'];
        $this->expectException(\Exception::class);
        [$ans1, $ans2] = $solver->solve($input);
    }

    // --------------------------------------------------------------------

    /**
     * @covers \TBali\Aoc2017\Aoc2017Day19
     */
    public function testDay19Example1(): void
    {
        $solver = new Aoc2017Day19();
        $input = $solver->readInput($solver->inputBaseFileName() . 'ex1.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::EXAMPLE_SOLUTIONS[0];
        $this->assertEquals(strval($expected1), $ans1);
        $this->assertEquals(strval($expected2), $ans2);
    }

    /**
     * @covers \TBali\Aoc2017\Aoc2017Day19
     */
    public function testDay19(): void
    {
        $solver = new Aoc2017Day19();
        $input = $solver->readInput($solver->inputBaseFileName() . '.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::SOLUTIONS;
        $this->assertEquals(strval($expected1), $ans1);
        $this->assertEquals(strval($expected2), $ans2);
    }

    /**
     * @covers \TBali\Aoc2017\Aoc2017Day19
     */
    public function testDay19InvalidInput1(): void
    {
        $solver = new Aoc2017Day19();
        $input = ['-'];
        $this->expectException(\Exception::class);
        [$ans1, $ans2] = $solver->solve($input);
    }

    // --------------------------------------------------------------------

    /**
     * @covers \TBali\Aoc2017\Aoc2017Day20
     * @covers \TBali\Aoc2017\Particle
     * @covers \TBali\Aoc2017\Vector3D
     */
    public function testDay20Example1(): void
    {
        $solver = new Aoc2017Day20();
        $input = $solver->readInput($solver->inputBaseFileName() . 'ex1.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::EXAMPLE_SOLUTIONS[0];
        $this->assertEquals(strval($expected1), $ans1);
        $this->assertEquals(strval($expected2), $ans2);
    }

    /**
     * @covers \TBali\Aoc2017\Aoc2017Day20
     * @covers \TBali\Aoc2017\Particle
     * @covers \TBali\Aoc2017\Vector3D
     */
    public function testDay20Example2(): void
    {
        $solver = new Aoc2017Day20();
        $input = $solver->readInput($solver->inputBaseFileName() . 'ex1.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::EXAMPLE_SOLUTIONS[0];
        $this->assertEquals(strval($expected1), $ans1);
        $this->assertEquals(strval($expected2), $ans2);
    }

    /**
     * @covers \TBali\Aoc2017\Aoc2017Day20
     * @covers \TBali\Aoc2017\Particle
     * @covers \TBali\Aoc2017\Vector3D
     */
    public function testDay20(): void
    {
        $solver = new Aoc2017Day20();
        $input = $solver->readInput($solver->inputBaseFileName() . '.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::SOLUTIONS;
        $this->assertEquals(strval($expected1), $ans1);
        $this->assertEquals(strval($expected2), $ans2);
    }

    /**
     * @covers \TBali\Aoc2017\Aoc2017Day20
     * @covers \TBali\Aoc2017\Particle
     * @covers \TBali\Aoc2017\Vector3D
     */
    public function testDay20InvalidInput1(): void
    {
        $solver = new Aoc2017Day20();
        $input = ['p=<0,0,0>, v=<0,0,0>, a=<0,0'];
        $this->expectException(\Exception::class);
        [$ans1, $ans2] = $solver->solve($input);
    }

    // --------------------------------------------------------------------

    /**
     * @covers \TBali\Aoc2017\Aoc2017Day23
     * @covers \TBali\Aoc2017\CoProcessor
     */
    public function testDay23(): void
    {
        $solver = new Aoc2017Day23();
        $input = $solver->readInput($solver->inputBaseFileName() . '.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::SOLUTIONS;
        $this->assertEquals(strval($expected1), $ans1);
        // $this->assertEquals(strval($expected2), $ans2);
    }

    /**
     * @covers \TBali\Aoc2017\Aoc2017Day23
     * @covers \TBali\Aoc2017\CoProcessor
     */
    public function testDay23InvalidInput1(): void
    {
        $solver = new Aoc2017Day23();
        $input = ['a'];
        $this->expectException(\Exception::class);
        [$ans1, $ans2] = $solver->solve($input);
    }

    /**
     * @covers \TBali\Aoc2017\Aoc2017Day23
     * @covers \TBali\Aoc2017\CoProcessor
     */
    public function testDay23InvalidInput2(): void
    {
        $solver = new Aoc2017Day23();
        $input = ['add a 1'];
        $this->expectException(\Exception::class);
        [$ans1, $ans2] = $solver->solve($input);
    }

    // --------------------------------------------------------------------
}
