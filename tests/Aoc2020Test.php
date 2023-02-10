<?php

declare(strict_types=1);

namespace TBali\Tests;

use PHPUnit\Framework\TestCase;
use TBali\Aoc2020\Aoc2020Day01;
use TBali\Aoc2020\Aoc2020Day02;
use TBali\Aoc2020\Aoc2020Day03;
use TBali\Aoc2020\Aoc2020Day04;
use TBali\Aoc2020\Aoc2020Day05;
use TBali\Aoc2020\Aoc2020Day06;
use TBali\Aoc2020\Aoc2020Day07;
use TBali\Aoc2020\Aoc2020Day08;
use TBali\Aoc2020\Aoc2020Day09;
use TBali\Aoc2020\Aoc2020Day10;
use TBali\Aoc2020\Aoc2020Day11;
use TBali\Aoc2020\Aoc2020Day12;
use TBali\Aoc2020\Aoc2020Day13;
use TBali\Aoc2020\Aoc2020Day14;
use TBali\Aoc2020\Aoc2020Day15;
use TBali\Aoc2020\Aoc2020Day16;
use TBali\Aoc2020\Aoc2020Day17;
use TBali\Aoc2020\Aoc2020Day18;
use TBali\Aoc2020\Aoc2020Day19;
use TBali\Aoc2020\Aoc2020Day20;
use TBali\Aoc2020\Aoc2020Day21;
use TBali\Aoc2020\Aoc2020Day22;
use TBali\Aoc2020\Aoc2020Day23;
use TBali\Aoc2020\Aoc2020Day24;
use TBali\Aoc2020\Aoc2020Day25;

/**
 * Unit tests for Advent of Code season 2020.
 *
 * Instead of using this file with phpunit, it is a better way to run the solutions by using AoCRunner.
 *
 * @internal
 *
 * @coversNothing
 */
final class Aoc2020Test extends TestCase
{
    // --------------------------------------------------------------------

    /**
     * @covers \TBali\Aoc2020\Aoc2020Day01
     */
    public function testDay01Example1(): void
    {
        $solver = new Aoc2020Day01();
        $input = $solver->readInput($solver->inputBaseFileName() . 'ex1.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::EXAMPLE_SOLUTIONS[0];
        $this->assertEquals(strval($expected1), $ans1);
        $this->assertEquals(strval($expected2), $ans2);
    }

    /**
     * @covers \TBali\Aoc2020\Aoc2020Day01
     */
    public function testDay01(): void
    {
        $solver = new Aoc2020Day01();
        $input = $solver->readInput($solver->inputBaseFileName() . '.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::SOLUTIONS;
        $this->assertEquals(strval($expected1), $ans1);
        $this->assertEquals(strval($expected2), $ans2);
    }

    // --------------------------------------------------------------------

    /**
     * @covers \TBali\Aoc2020\Aoc2020Day02
     */
    public function testDay02Example1(): void
    {
        $solver = new Aoc2020Day02();
        $input = $solver->readInput($solver->inputBaseFileName() . 'ex1.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::EXAMPLE_SOLUTIONS[0];
        $this->assertEquals(strval($expected1), $ans1);
        $this->assertEquals(strval($expected2), $ans2);
    }

    /**
     * @covers \TBali\Aoc2020\Aoc2020Day02
     */
    public function testDay02(): void
    {
        $solver = new Aoc2020Day02();
        $input = $solver->readInput($solver->inputBaseFileName() . '.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::SOLUTIONS;
        $this->assertEquals(strval($expected1), $ans1);
        $this->assertEquals(strval($expected2), $ans2);
    }

    /**
     * @covers \TBali\Aoc2020\Aoc2020Day02
     */
    public function testDay02InvalidInput1(): void
    {
        $solver = new Aoc2020Day02();
        $input = ['1-1 a:'];
        $this->expectException(\Exception::class);
        [$ans1, $ans2] = $solver->solve($input);
    }

    // --------------------------------------------------------------------

    /**
     * @covers \TBali\Aoc2020\Aoc2020Day03
     */
    public function testDay03Example1(): void
    {
        $solver = new Aoc2020Day03();
        $input = $solver->readInput($solver->inputBaseFileName() . 'ex1.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::EXAMPLE_SOLUTIONS[0];
        $this->assertEquals(strval($expected1), $ans1);
        $this->assertEquals(strval($expected2), $ans2);
    }

    /**
     * @covers \TBali\Aoc2020\Aoc2020Day03
     */
    public function testDay03(): void
    {
        $solver = new Aoc2020Day03();
        $input = $solver->readInput($solver->inputBaseFileName() . '.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::SOLUTIONS;
        $this->assertEquals(strval($expected1), $ans1);
        $this->assertEquals(strval($expected2), $ans2);
    }

    // --------------------------------------------------------------------

    /**
     * @covers \TBali\Aoc2020\Aoc2020Day04
     */
    public function testDay04Example1(): void
    {
        $solver = new Aoc2020Day04();
        $input = $solver->readInput($solver->inputBaseFileName() . 'ex1.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::EXAMPLE_SOLUTIONS[0];
        $this->assertEquals(strval($expected1), $ans1);
        // $this->assertEquals(strval($expected2), $ans2);
    }

    /**
     * @covers \TBali\Aoc2020\Aoc2020Day04
     */
    public function testDay04Example2(): void
    {
        $solver = new Aoc2020Day04();
        $input = $solver->readInput($solver->inputBaseFileName() . 'ex2.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::EXAMPLE_SOLUTIONS[1];
        // $this->assertEquals(strval($expected1), $ans1);
        $this->assertEquals(strval($expected2), $ans2);
    }

    /**
     * @covers \TBali\Aoc2020\Aoc2020Day04
     */
    public function testDay04(): void
    {
        $solver = new Aoc2020Day04();
        $input = $solver->readInput($solver->inputBaseFileName() . '.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::SOLUTIONS;
        $this->assertEquals(strval($expected1), $ans1);
        $this->assertEquals(strval($expected2), $ans2);
    }

    /**
     * @covers \TBali\Aoc2020\Aoc2020Day04
     */
    public function testDay04InvalidInput1(): void
    {
        $solver = new Aoc2020Day04();
        $input = ['a'];
        $this->expectException(\Exception::class);
        [$ans1, $ans2] = $solver->solve($input);
    }

    // --------------------------------------------------------------------

    /**
     * @covers \TBali\Aoc2020\Aoc2020Day05
     */
    public function testDay05Example1(): void
    {
        $solver = new Aoc2020Day05();
        $input = [$solver::EXAMPLE_STRING_INPUTS[0]];
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::EXAMPLE_SOLUTIONS[0];
        $this->assertEquals(strval($expected1), $ans1);
        // $this->assertEquals(strval($expected2), $ans2);
    }

    /**
     * @covers \TBali\Aoc2020\Aoc2020Day05
     */
    public function testDay05Example2(): void
    {
        $solver = new Aoc2020Day05();
        $input = [$solver::EXAMPLE_STRING_INPUTS[1]];
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::EXAMPLE_SOLUTIONS[1];
        $this->assertEquals(strval($expected1), $ans1);
        // $this->assertEquals(strval($expected2), $ans2);
    }

    /**
     * @covers \TBali\Aoc2020\Aoc2020Day05
     */
    public function testDay05(): void
    {
        $solver = new Aoc2020Day05();
        $input = $solver->readInput($solver->inputBaseFileName() . '.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::SOLUTIONS;
        $this->assertEquals(strval($expected1), $ans1);
        $this->assertEquals(strval($expected2), $ans2);
    }

    // --------------------------------------------------------------------

    /**
     * @covers \TBali\Aoc2020\Aoc2020Day06
     */
    public function testDay06Example1(): void
    {
        $solver = new Aoc2020Day06();
        $input = $solver->readInput($solver->inputBaseFileName() . 'ex1.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::EXAMPLE_SOLUTIONS[0];
        $this->assertEquals(strval($expected1), $ans1);
        $this->assertEquals(strval($expected2), $ans2);
    }

    /**
     * @covers \TBali\Aoc2020\Aoc2020Day06
     */
    public function testDay06(): void
    {
        $solver = new Aoc2020Day06();
        $input = $solver->readInput($solver->inputBaseFileName() . '.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::SOLUTIONS;
        $this->assertEquals(strval($expected1), $ans1);
        $this->assertEquals(strval($expected2), $ans2);
    }

    // --------------------------------------------------------------------

    /**
     * @covers \TBali\Aoc2020\Aoc2020Day07
     * @covers \TBali\Aoc2020\BagRegulations
     */
    public function testDay07Example1(): void
    {
        $solver = new Aoc2020Day07();
        $input = $solver->readInput($solver->inputBaseFileName() . 'ex1.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::EXAMPLE_SOLUTIONS[0];
        $this->assertEquals(strval($expected1), $ans1);
        $this->assertEquals(strval($expected2), $ans2);
    }

    /**
     * @covers \TBali\Aoc2020\Aoc2020Day07
     * @covers \TBali\Aoc2020\BagRegulations
     */
    public function testDay07(): void
    {
        $solver = new Aoc2020Day07();
        $input = $solver->readInput($solver->inputBaseFileName() . '.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::SOLUTIONS;
        $this->assertEquals(strval($expected1), $ans1);
        $this->assertEquals(strval($expected2), $ans2);
    }

    /**
     * @covers \TBali\Aoc2020\Aoc2020Day07
     * @covers \TBali\Aoc2020\BagRegulations
     */
    public function testDay07InvalidInput1(): void
    {
        $solver = new Aoc2020Day07();
        $input = ['a'];
        $this->expectException(\Exception::class);
        [$ans1, $ans2] = $solver->solve($input);
    }

    /**
     * @covers \TBali\Aoc2020\Aoc2020Day07
     * @covers \TBali\Aoc2020\BagRegulations
     */
    public function testDay07InvalidInput2(): void
    {
        $solver = new Aoc2020Day07();
        $input = ['dim red bags contain 2 bright gold bags, 5 striped fuchsia.'];
        $this->expectException(\Exception::class);
        [$ans1, $ans2] = $solver->solve($input);
    }

    /**
     * @covers \TBali\Aoc2020\Aoc2020Day07
     * @covers \TBali\Aoc2020\BagRegulations
     */
    public function testDay07InvalidInput3(): void
    {
        $solver = new Aoc2020Day07();
        $input = ['dim red bags contain 2 bright gold boxes, 5 striped fuchsia bags.'];
        $this->expectException(\Exception::class);
        [$ans1, $ans2] = $solver->solve($input);
    }

    // --------------------------------------------------------------------

    /**
     * @covers \TBali\Aoc2020\Aoc2020Day08
     */
    public function testDay08Example1(): void
    {
        $solver = new Aoc2020Day08();
        $input = $solver->readInput($solver->inputBaseFileName() . 'ex1.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::EXAMPLE_SOLUTIONS[0];
        $this->assertEquals(strval($expected1), $ans1);
        $this->assertEquals(strval($expected2), $ans2);
    }

    /**
     * @covers \TBali\Aoc2020\Aoc2020Day08
     */
    public function testDay08(): void
    {
        $solver = new Aoc2020Day08();
        $input = $solver->readInput($solver->inputBaseFileName() . '.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::SOLUTIONS;
        $this->assertEquals(strval($expected1), $ans1);
        $this->assertEquals(strval($expected2), $ans2);
    }

    // --------------------------------------------------------------------

    /**
     * @covers \TBali\Aoc2020\Aoc2020Day09
     */
    public function testDay09Example1(): void
    {
        $solver = new Aoc2020Day09();
        $input = $solver->readInput($solver->inputBaseFileName() . 'ex1.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::EXAMPLE_SOLUTIONS[0];
        $this->assertEquals(strval($expected1), $ans1);
        $this->assertEquals(strval($expected2), $ans2);
    }

    /**
     * @covers \TBali\Aoc2020\Aoc2020Day09
     */
    public function testDay09(): void
    {
        $solver = new Aoc2020Day09();
        $input = $solver->readInput($solver->inputBaseFileName() . '.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::SOLUTIONS;
        $this->assertEquals(strval($expected1), $ans1);
        $this->assertEquals(strval($expected2), $ans2);
    }

    /**
     * @covers \TBali\Aoc2020\Aoc2020Day09
     */
    public function testDay09InvalidInput1(): void
    {
        $solver = new Aoc2020Day09();
        $input = ['1'];
        $this->expectException(\Exception::class);
        [$ans1, $ans2] = $solver->solve($input);
    }

    // --------------------------------------------------------------------

    /**
     * @covers \TBali\Aoc2020\Aoc2020Day10
     */
    public function testDay10Example1(): void
    {
        $solver = new Aoc2020Day10();
        $input = $solver->readInput($solver->inputBaseFileName() . 'ex1.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::EXAMPLE_SOLUTIONS[0];
        $this->assertEquals(strval($expected1), $ans1);
        $this->assertEquals(strval($expected2), $ans2);
    }

    /**
     * @covers \TBali\Aoc2020\Aoc2020Day10
     */
    public function testDay10Example2(): void
    {
        $solver = new Aoc2020Day10();
        $input = $solver->readInput($solver->inputBaseFileName() . 'ex2.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::EXAMPLE_SOLUTIONS[1];
        $this->assertEquals(strval($expected1), $ans1);
        $this->assertEquals(strval($expected2), $ans2);
    }

    /**
     * @covers \TBali\Aoc2020\Aoc2020Day10
     */
    public function testDay10(): void
    {
        $solver = new Aoc2020Day10();
        $input = $solver->readInput($solver->inputBaseFileName() . '.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::SOLUTIONS;
        $this->assertEquals(strval($expected1), $ans1);
        $this->assertEquals(strval($expected2), $ans2);
    }

    // --------------------------------------------------------------------

    /**
     * @covers \TBali\Aoc2020\Aoc2020Day11
     */
    public function testDay11Example1(): void
    {
        $solver = new Aoc2020Day11();
        $input = $solver->readInput($solver->inputBaseFileName() . 'ex1.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::EXAMPLE_SOLUTIONS[0];
        $this->assertEquals(strval($expected1), $ans1);
        $this->assertEquals(strval($expected2), $ans2);
    }

    /**
     * @covers \TBali\Aoc2020\Aoc2020Day11
     *
     * @group large
     */
    public function testDay11(): void
    {
        $solver = new Aoc2020Day11();
        $input = $solver->readInput($solver->inputBaseFileName() . '.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::SOLUTIONS;
        $this->assertEquals(strval($expected1), $ans1);
        $this->assertEquals(strval($expected2), $ans2);
    }

    // --------------------------------------------------------------------

    /**
     * @covers \TBali\Aoc2020\Aoc2020Day12
     */
    public function testDay12Example1(): void
    {
        $solver = new Aoc2020Day12();
        $input = $solver->readInput($solver->inputBaseFileName() . 'ex1.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::EXAMPLE_SOLUTIONS[0];
        $this->assertEquals(strval($expected1), $ans1);
        $this->assertEquals(strval($expected2), $ans2);
    }

    /**
     * @covers \TBali\Aoc2020\Aoc2020Day12
     */
    public function testDay12(): void
    {
        $solver = new Aoc2020Day12();
        $input = $solver->readInput($solver->inputBaseFileName() . '.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::SOLUTIONS;
        $this->assertEquals(strval($expected1), $ans1);
        $this->assertEquals(strval($expected2), $ans2);
    }

    // --------------------------------------------------------------------

    /**
     * @covers \TBali\Aoc2020\Aoc2020Day13
     */
    public function testDay13Example1(): void
    {
        $solver = new Aoc2020Day13();
        $input = $solver->readInput($solver->inputBaseFileName() . 'ex1.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::EXAMPLE_SOLUTIONS[0];
        $this->assertEquals(strval($expected1), $ans1);
        $this->assertEquals(strval($expected2), $ans2);
    }

    /**
     * @covers \TBali\Aoc2020\Aoc2020Day13
     */
    public function testDay13(): void
    {
        $solver = new Aoc2020Day13();
        $input = $solver->readInput($solver->inputBaseFileName() . '.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::SOLUTIONS;
        $this->assertEquals(strval($expected1), $ans1);
        $this->assertEquals(strval($expected2), $ans2);
    }

    /**
     * @covers \TBali\Aoc2020\Aoc2020Day13
     */
    public function testDay13InvalidInput1(): void
    {
        $solver = new Aoc2020Day13();
        $input = ['a'];
        $this->expectException(\Exception::class);
        [$ans1, $ans2] = $solver->solve($input);
    }

    /**
     * @covers \TBali\Aoc2020\Aoc2020Day13
     */
    public function testDay13InvalidInput2(): void
    {
        $solver = new Aoc2020Day13();
        $input = ['0', 'x'];
        $this->expectException(\Exception::class);
        [$ans1, $ans2] = $solver->solve($input);
    }

    // --------------------------------------------------------------------

    /**
     * @covers \TBali\Aoc2020\Aoc2020Day14
     */
    public function testDay14Example1(): void
    {
        $solver = new Aoc2020Day14();
        $input = $solver->readInput($solver->inputBaseFileName() . 'ex1.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::EXAMPLE_SOLUTIONS[0];
        $this->assertEquals(strval($expected1), $ans1);
        // $this->assertEquals(strval($expected2), $ans2);
    }

    /**
     * @covers \TBali\Aoc2020\Aoc2020Day14
     */
    public function testDay14Example2(): void
    {
        $solver = new Aoc2020Day14();
        $input = $solver->readInput($solver->inputBaseFileName() . 'ex2.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::EXAMPLE_SOLUTIONS[1];
        // $this->assertEquals(strval($expected1), $ans1);
        $this->assertEquals(strval($expected2), $ans2);
    }

    /**
     * @covers \TBali\Aoc2020\Aoc2020Day14
     */
    public function testDay14(): void
    {
        $solver = new Aoc2020Day14();
        $input = $solver->readInput($solver->inputBaseFileName() . '.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::SOLUTIONS;
        $this->assertEquals(strval($expected1), $ans1);
        $this->assertEquals(strval($expected2), $ans2);
    }

    /**
     * @covers \TBali\Aoc2020\Aoc2020Day14
     */
    public function testDay14InvalidInput1(): void
    {
        $solver = new Aoc2020Day14();
        $input = ['a'];
        $this->expectException(\Exception::class);
        [$ans1, $ans2] = $solver->solve($input);
    }

    // --------------------------------------------------------------------

    /**
     * @covers \TBali\Aoc2020\Aoc2020Day15
     *
     * @group large
     */
    public function testDay15Example1(): void
    {
        $solver = new Aoc2020Day15();
        $input = [$solver::EXAMPLE_STRING_INPUTS[0]];
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::EXAMPLE_SOLUTIONS[0];
        $this->assertEquals(strval($expected1), $ans1);
        $this->assertEquals(strval($expected2), $ans2);
    }

    /**
     * @covers \TBali\Aoc2020\Aoc2020Day15
     *
     * @group large
     */
    public function testDay15Example2(): void
    {
        $solver = new Aoc2020Day15();
        $input = [$solver::EXAMPLE_STRING_INPUTS[1]];
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::EXAMPLE_SOLUTIONS[1];
        $this->assertEquals(strval($expected1), $ans1);
        $this->assertEquals(strval($expected2), $ans2);
    }

    /**
     * @covers \TBali\Aoc2020\Aoc2020Day15
     *
     * @group large
     */
    public function testDay15(): void
    {
        $solver = new Aoc2020Day15();
        $input = [$solver::STRING_INPUT];
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::SOLUTIONS;
        $this->assertEquals(strval($expected1), $ans1);
        $this->assertEquals(strval($expected2), $ans2);
    }

    // --------------------------------------------------------------------

    /**
     * @covers \TBali\Aoc2020\Aoc2020Day16
     * @covers \TBali\Aoc2020\FieldValidator
     */
    public function testDay16Example1(): void
    {
        $solver = new Aoc2020Day16();
        $input = $solver->readInput($solver->inputBaseFileName() . 'ex1.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::EXAMPLE_SOLUTIONS[0];
        $this->assertEquals(strval($expected1), $ans1);
        // $this->assertEquals(strval($expected2), $ans2);
    }

    /**
     * @covers \TBali\Aoc2020\Aoc2020Day16
     * @covers \TBali\Aoc2020\FieldValidator
     */
    public function testDay16Example2(): void
    {
        $solver = new Aoc2020Day16();
        $input = $solver->readInput($solver->inputBaseFileName() . 'ex2.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::EXAMPLE_SOLUTIONS[1];
        // $this->assertEquals(strval($expected1), $ans1);
        $this->assertEquals(strval($expected2), $ans2);
    }

    /**
     * @covers \TBali\Aoc2020\Aoc2020Day16
     * @covers \TBali\Aoc2020\FieldValidator
     */
    public function testDay16(): void
    {
        $solver = new Aoc2020Day16();
        $input = $solver->readInput($solver->inputBaseFileName() . '.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::SOLUTIONS;
        $this->assertEquals(strval($expected1), $ans1);
        $this->assertEquals(strval($expected2), $ans2);
    }

    /**
     * @covers \TBali\Aoc2020\Aoc2020Day14
     * @covers \TBali\Aoc2020\FieldValidator
     */
    public function testDay16InvalidInput1(): void
    {
        $solver = new Aoc2020Day14();
        $input = ['a'];
        $this->expectException(\Exception::class);
        [$ans1, $ans2] = $solver->solve($input);
    }

    // --------------------------------------------------------------------

    /**
     * @covers \TBali\Aoc2020\Aoc2020Day17
     *
     * @group medium
     */
    public function testDay17Example1(): void
    {
        $solver = new Aoc2020Day17();
        $input = $solver->readInput($solver->inputBaseFileName() . 'ex1.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::EXAMPLE_SOLUTIONS[0];
        $this->assertEquals(strval($expected1), $ans1);
        $this->assertEquals(strval($expected2), $ans2);
    }

    /**
     * @covers \TBali\Aoc2020\Aoc2020Day17
     *
     * @group large
     */
    public function testDay17(): void
    {
        $solver = new Aoc2020Day17();
        $input = $solver->readInput($solver->inputBaseFileName() . '.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::SOLUTIONS;
        $this->assertEquals(strval($expected1), $ans1);
        $this->assertEquals(strval($expected2), $ans2);
    }

    // --------------------------------------------------------------------

    /**
     * @covers \TBali\Aoc2020\Aoc2020Day18
     * @covers \TBali\Aoc2020\Expression
     */
    public function testDay18Example1(): void
    {
        $solver = new Aoc2020Day18();
        $input = [$solver::EXAMPLE_STRING_INPUTS[0]];
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::EXAMPLE_SOLUTIONS[0];
        $this->assertEquals(strval($expected1), $ans1);
        $this->assertEquals(strval($expected2), $ans2);
    }

    /**
     * @covers \TBali\Aoc2020\Aoc2020Day18
     * @covers \TBali\Aoc2020\Expression
     */
    public function testDay18Example2(): void
    {
        $solver = new Aoc2020Day18();
        $input = [$solver::EXAMPLE_STRING_INPUTS[1]];
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::EXAMPLE_SOLUTIONS[1];
        $this->assertEquals(strval($expected1), $ans1);
        $this->assertEquals(strval($expected2), $ans2);
    }

    /**
     * @covers \TBali\Aoc2020\Aoc2020Day18
     * @covers \TBali\Aoc2020\Expression
     */
    public function testDay18(): void
    {
        $solver = new Aoc2020Day18();
        $input = $solver->readInput($solver->inputBaseFileName() . '.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::SOLUTIONS;
        $this->assertEquals(strval($expected1), $ans1);
        $this->assertEquals(strval($expected2), $ans2);
    }

    // --------------------------------------------------------------------

    /**
     * @covers \TBali\Aoc2020\Aoc2020Day19
     * @covers \TBali\Aoc2020\MessageNode
     */
    public function testDay19Example1(): void
    {
        $solver = new Aoc2020Day19();
        $input = $solver->readInput($solver->inputBaseFileName() . 'ex1.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::EXAMPLE_SOLUTIONS[0];
        $this->assertEquals(strval($expected1), $ans1);
        // $this->assertEquals(strval($expected2), $ans2);
    }

    /**
     * @covers \TBali\Aoc2020\Aoc2020Day19
     * @covers \TBali\Aoc2020\MessageNode
     */
    public function testDay19Example2(): void
    {
        $solver = new Aoc2020Day19();
        $input = $solver->readInput($solver->inputBaseFileName() . 'ex2.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::EXAMPLE_SOLUTIONS[1];
        $this->assertEquals(strval($expected1), $ans1);
        // $this->assertEquals(strval($expected2), $ans2);
    }

    /**
     * @covers \TBali\Aoc2020\Aoc2020Day19
     * @covers \TBali\Aoc2020\MessageNode
     *
     * @group large
     */
    public function testDay19(): void
    {
        $solver = new Aoc2020Day19();
        $input = $solver->readInput($solver->inputBaseFileName() . '.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::SOLUTIONS;
        $this->assertEquals(strval($expected1), $ans1);
        $this->assertEquals(strval($expected2), $ans2);
    }

    // --------------------------------------------------------------------

    /**
     * @covers \TBali\Aoc2020\Aoc2020Day20
     * @covers \TBali\Aoc2020\Image
     * @covers \TBali\Aoc2020\ImageTile
     * @covers \TBali\Aoc2020\Point
     * @covers \TBali\Aoc2020\SearchPattern
     */
    public function testDay20Example1(): void
    {
        $solver = new Aoc2020Day20();
        $input = $solver->readInput($solver->inputBaseFileName() . 'ex1.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::EXAMPLE_SOLUTIONS[0];
        $this->assertEquals(strval($expected1), $ans1);
        $this->assertEquals(strval($expected2), $ans2);
    }

    /**
     * @covers \TBali\Aoc2020\Aoc2020Day20
     * @covers \TBali\Aoc2020\Image
     * @covers \TBali\Aoc2020\ImageTile
     * @covers \TBali\Aoc2020\Point
     * @covers \TBali\Aoc2020\SearchPattern
     */
    public function testDay20(): void
    {
        $solver = new Aoc2020Day20();
        $input = $solver->readInput($solver->inputBaseFileName() . '.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::SOLUTIONS;
        $this->assertEquals(strval($expected1), $ans1);
        $this->assertEquals(strval($expected2), $ans2);
    }

    // --------------------------------------------------------------------

    /**
     * @covers \TBali\Aoc2020\Aoc2020Day21
     */
    public function testDay21Example1(): void
    {
        $solver = new Aoc2020Day21();
        $input = $solver->readInput($solver->inputBaseFileName() . 'ex1.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::EXAMPLE_SOLUTIONS[0];
        $this->assertEquals(strval($expected1), $ans1);
        $this->assertEquals(strval($expected2), $ans2);
    }

    /**
     * @covers \TBali\Aoc2020\Aoc2020Day21
     */
    public function testDay21(): void
    {
        $solver = new Aoc2020Day21();
        $input = $solver->readInput($solver->inputBaseFileName() . '.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::SOLUTIONS;
        $this->assertEquals(strval($expected1), $ans1);
        $this->assertEquals(strval($expected2), $ans2);
    }

    // --------------------------------------------------------------------

    /**
     * @covers \TBali\Aoc2020\Aoc2020Day22
     * @covers \TBali\Aoc2020\SpaceCardDeck
     * @covers \TBali\Aoc2020\SpaceCardGame
     * @covers \TBali\Aoc2020\SpaceCardRecursiveGame
     */
    public function testDay22Example1(): void
    {
        $solver = new Aoc2020Day22();
        $input = $solver->readInput($solver->inputBaseFileName() . 'ex1.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::EXAMPLE_SOLUTIONS[0];
        $this->assertEquals(strval($expected1), $ans1);
        $this->assertEquals(strval($expected2), $ans2);
    }

    /**
     * @covers \TBali\Aoc2020\Aoc2020Day22
     * @covers \TBali\Aoc2020\SpaceCardDeck
     * @covers \TBali\Aoc2020\SpaceCardGame
     * @covers \TBali\Aoc2020\SpaceCardRecursiveGame
     */
    public function testDay22Example2(): void
    {
        $solver = new Aoc2020Day22();
        $input = $solver->readInput($solver->inputBaseFileName() . 'ex2.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::EXAMPLE_SOLUTIONS[1];
        $this->assertEquals(strval($expected1), $ans1);
        $this->assertEquals(strval($expected2), $ans2);
    }

    /**
     * @covers \TBali\Aoc2020\Aoc2020Day22
     * @covers \TBali\Aoc2020\SpaceCardDeck
     * @covers \TBali\Aoc2020\SpaceCardGame
     * @covers \TBali\Aoc2020\SpaceCardRecursiveGame
     *
     * @group large
     */
    public function testDay22(): void
    {
        $solver = new Aoc2020Day22();
        $input = $solver->readInput($solver->inputBaseFileName() . '.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::SOLUTIONS;
        $this->assertEquals(strval($expected1), $ans1);
        $this->assertEquals(strval($expected2), $ans2);
    }

    /**
     * @covers \TBali\Aoc2020\Aoc2020Day22
     * @covers \TBali\Aoc2020\SpaceCardDeck
     * @covers \TBali\Aoc2020\SpaceCardGame
     * @covers \TBali\Aoc2020\SpaceCardRecursiveGame
     */
    public function testDay22InvalidInput1(): void
    {
        $solver = new Aoc2020Day22();
        $input = ['a'];
        $this->expectException(\Exception::class);
        [$ans1, $ans2] = $solver->solve($input);
    }

    // --------------------------------------------------------------------

    /**
     * @covers \TBali\Aoc2020\Aoc2020Day23
     *
     * @group large
     */
    public function testDay23Example1(): void
    {
        $solver = new Aoc2020Day23();
        $input = [$solver::EXAMPLE_STRING_INPUTS[0]];
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::EXAMPLE_SOLUTIONS[0];
        $this->assertEquals(strval($expected1), $ans1);
        $this->assertEquals(strval($expected2), $ans2);
    }

    /**
     * @covers \TBali\Aoc2020\Aoc2020Day23
     *
     * @group large
     */
    public function testDay23(): void
    {
        $solver = new Aoc2020Day23();
        $input = [$solver::STRING_INPUT];
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::SOLUTIONS;
        $this->assertEquals(strval($expected1), $ans1);
        $this->assertEquals(strval($expected2), $ans2);
    }

    // --------------------------------------------------------------------

    /**
     * @covers \TBali\Aoc2020\Aoc2020Day24
     *
     * @group medium
     */
    public function testDay24Example1(): void
    {
        $solver = new Aoc2020Day24();
        $input = $solver->readInput($solver->inputBaseFileName() . 'ex1.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::EXAMPLE_SOLUTIONS[0];
        $this->assertEquals(strval($expected1), $ans1);
        $this->assertEquals(strval($expected2), $ans2);
    }

    /**
     * @covers \TBali\Aoc2020\Aoc2020Day24
     *
     * @group large
     */
    public function testDay24(): void
    {
        $solver = new Aoc2020Day24();
        $input = $solver->readInput($solver->inputBaseFileName() . '.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::SOLUTIONS;
        $this->assertEquals(strval($expected1), $ans1);
        $this->assertEquals(strval($expected2), $ans2);
    }

    /**
     * @covers \TBali\Aoc2020\Aoc2020Day24
     */
    public function testDay24InvalidInput1(): void
    {
        $solver = new Aoc2020Day24();
        $input = ['a'];
        $this->expectException(\Exception::class);
        [$ans1, $ans2] = $solver->solve($input);
    }

    // --------------------------------------------------------------------

    /**
     * @covers \TBali\Aoc2020\Aoc2020Day25
     */
    public function testDay25Example1(): void
    {
        $solver = new Aoc2020Day25();
        $input = $solver->readInput($solver->inputBaseFileName() . 'ex1.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::EXAMPLE_SOLUTIONS[0];
        $this->assertEquals(strval($expected1), $ans1);
        // $this->assertEquals(strval($expected2), $ans2);
    }

    /**
     * @covers \TBali\Aoc2020\Aoc2020Day25
     */
    public function testDay25(): void
    {
        $solver = new Aoc2020Day25();
        $input = $solver->readInput($solver->inputBaseFileName() . '.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::SOLUTIONS;
        $this->assertEquals(strval($expected1), $ans1);
        // $this->assertEquals(strval($expected2), $ans2);
    }

    /**
     * @covers \TBali\Aoc2020\Aoc2020Day25
     */
    public function testDay25InvalidInput1(): void
    {
        $solver = new Aoc2020Day25();
        $input = ['1'];
        $this->expectException(\Exception::class);
        [$ans1, $ans2] = $solver->solve($input);
    }

    // --------------------------------------------------------------------
}
