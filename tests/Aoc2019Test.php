<?php

declare(strict_types=1);

namespace TBali\Tests;

use PHPUnit\Framework\Attributes\IgnoreClassForCodeCoverage;
use PHPUnit\Framework\Attributes\RequiresPhp;
use PHPUnit\Framework\Attributes\RequiresPhpunit;
use PHPUnit\Framework\TestCase;
use TBali\Aoc2019\Aoc2019Day01;
use TBali\Aoc2019\Aoc2019Day02;
use TBali\Aoc2019\Aoc2019Day03;
use TBali\Aoc2019\Aoc2019Day04;
use TBali\Aoc2019\Aoc2019Day05;
use TBali\Aoc2019\Aoc2019Day06;
use TBali\Aoc2019\Aoc2019Day07;
use TBali\Aoc2019\Aoc2019Day08;
use TBali\Aoc2019\Aoc2019Day09;
use TBali\Aoc2019\Aoc2019Day10;
use TBali\Aoc2019\Aoc2019Day11;
use TBali\Aoc2019\Aoc2019Day12;
use TBali\Aoc2019\Aoc2019Day13;
use TBali\Aoc2019\Aoc2019Day14;
use TBali\Aoc2019\Aoc2019Day15;
use TBali\Aoc2019\Aoc2019Day16;
use TBali\Aoc2019\Aoc2019Day17;
use TBali\Aoc2019\Aoc2019Day18;
use TBali\Aoc2019\Aoc2019Day19;
use TBali\Aoc2019\Aoc2019Day20;
use TBali\Aoc2019\Aoc2019Day21;
use TBali\Aoc2019\Aoc2019Day22;
use TBali\Aoc2019\Aoc2019Day23;
use TBali\Aoc2019\Aoc2019Day24;
use TBali\Aoc2019\Aoc2019Day25;

/**
 * Unit tests for Advent of Code season 2019.
 *
 * Instead of using this file with phpunit, it is a better way to run the solutions by using AoCRunner.
 *
 * @internal
 *
 * @coversNothing
 */
#[RequiresPhp('^8.2')]
#[RequiresPhpunit('^10.3')]
#[IgnoreClassForCodeCoverage(\TBali\Aoc\SolutionBase::class)]
#[IgnoreClassForCodeCoverage(Aoc2019Day13::class)]
#[IgnoreClassForCodeCoverage(\TBali\Aoc2019\ArcadeSimulator::class)]
#[IgnoreClassForCodeCoverage(Aoc2019Day15::class)]
#[IgnoreClassForCodeCoverage(\TBali\Aoc2019\DroidSimulator::class)]
#[IgnoreClassForCodeCoverage(\TBali\Aoc2019\Map::class)]
#[IgnoreClassForCodeCoverage(Aoc2019Day19::class)]
#[IgnoreClassForCodeCoverage(\TBali\Aoc2019\DroneSimulator::class)]
#[IgnoreClassForCodeCoverage(Aoc2019Day25::class)]
#[IgnoreClassForCodeCoverage(\TBali\Aoc2019\AdventureSimulator::class)]
final class Aoc2019Test extends TestCase
{
    // --------------------------------------------------------------------

    /**
     * @covers \TBali\Aoc2019\Aoc2019Day01
     */
    public function testDay01Example1(): void
    {
        $solver = new Aoc2019Day01();
        $input = $solver->readInput($solver->inputBaseFileName() . 'ex1.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::EXAMPLE_SOLUTIONS[0];
        self::assertSame(strval($expected1), $ans1);
        self::assertSame(strval($expected2), $ans2);
    }

    /**
     * @covers \TBali\Aoc2019\Aoc2019Day01
     */
    public function testDay01(): void
    {
        $solver = new Aoc2019Day01();
        $input = $solver->readInput($solver->inputBaseFileName() . '.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::SOLUTIONS;
        self::assertSame(strval($expected1), $ans1);
        self::assertSame(strval($expected2), $ans2);
    }

    // --------------------------------------------------------------------

    /**
     * @covers \TBali\Aoc2019\Aoc2019Day02
     */
    public function testDay02Example1(): void
    {
        $solver = new Aoc2019Day02();
        $input = $solver->readInput($solver->inputBaseFileName() . 'ex1.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::EXAMPLE_SOLUTIONS[0];
        self::assertSame(strval($expected1), $ans1);
        // self::assertSame(strval($expected2), $ans2);
    }

    /**
     * @covers \TBali\Aoc2019\Aoc2019Day02
     */
    public function testDay02Example2(): void
    {
        $solver = new Aoc2019Day02();
        $input = $solver->readInput($solver->inputBaseFileName() . 'ex2.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::EXAMPLE_SOLUTIONS[1];
        self::assertSame(strval($expected1), $ans1);
        // self::assertSame(strval($expected2), $ans2);
    }

    /**
     * @covers \TBali\Aoc2019\Aoc2019Day02
     */
    public function testDay02(): void
    {
        $solver = new Aoc2019Day02();
        $input = $solver->readInput($solver->inputBaseFileName() . '.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::SOLUTIONS;
        self::assertSame(strval($expected1), $ans1);
        self::assertSame(strval($expected2), $ans2);
    }

    /**
     * @covers \TBali\Aoc2019\Aoc2019Day02
     */
    public function testDay02InvalidInput1(): void
    {
        $solver = new Aoc2019Day02();
        $input = ['1,1,1,3'];
        $this->expectException(\Exception::class);
        [$ans1, $ans2] = $solver->solve($input);
    }

    /**
     * @covers \TBali\Aoc2019\Aoc2019Day02
     */
    public function testDay02InvalidInput2(): void
    {
        $solver = new Aoc2019Day02();
        $input = ['1,1,1,3,2,1,1'];
        $this->expectException(\Exception::class);
        [$ans1, $ans2] = $solver->solve($input);
    }

    // --------------------------------------------------------------------

    /**
     * @covers \TBali\Aoc2019\Aoc2019Day03
     */
    public function testDay03Example1(): void
    {
        $solver = new Aoc2019Day03();
        $input = $solver->readInput($solver->inputBaseFileName() . 'ex1.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::EXAMPLE_SOLUTIONS[0];
        self::assertSame(strval($expected1), $ans1);
        self::assertSame(strval($expected2), $ans2);
    }

    /**
     * @covers \TBali\Aoc2019\Aoc2019Day03
     */
    public function testDay03Example2(): void
    {
        $solver = new Aoc2019Day03();
        $input = $solver->readInput($solver->inputBaseFileName() . 'ex2.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::EXAMPLE_SOLUTIONS[1];
        self::assertSame(strval($expected1), $ans1);
        self::assertSame(strval($expected2), $ans2);
    }

    /**
     * @covers \TBali\Aoc2019\Aoc2019Day03
     */
    public function testDay03Example3(): void
    {
        $solver = new Aoc2019Day03();
        $input = $solver->readInput($solver->inputBaseFileName() . 'ex3.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::EXAMPLE_SOLUTIONS[2];
        self::assertSame(strval($expected1), $ans1);
        self::assertSame(strval($expected2), $ans2);
    }

    /**
     * @covers \TBali\Aoc2019\Aoc2019Day03
     */
    public function testDay03(): void
    {
        $solver = new Aoc2019Day03();
        $input = $solver->readInput($solver->inputBaseFileName() . '.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::SOLUTIONS;
        self::assertSame(strval($expected1), $ans1);
        self::assertSame(strval($expected2), $ans2);
    }

    /**
     * @covers \TBali\Aoc2019\Aoc2019Day03
     */
    public function testDay03InvalidInput1(): void
    {
        $solver = new Aoc2019Day03();
        $input = ['A1'];
        $this->expectException(\Exception::class);
        [$ans1, $ans2] = $solver->solve($input);
    }

    // --------------------------------------------------------------------

    /**
     * @covers \TBali\Aoc2019\Aoc2019Day04
     */
    public function testDay04Example1(): void
    {
        $solver = new Aoc2019Day04();
        $input = [$solver::EXAMPLE_STRING_INPUTS[0]];
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::EXAMPLE_SOLUTIONS[0];
        self::assertSame(strval($expected1), $ans1);
        self::assertSame(strval($expected2), $ans2);
    }

    /**
     * @covers \TBali\Aoc2019\Aoc2019Day04
     *
     * @group medium
     */
    public function testDay04(): void
    {
        $solver = new Aoc2019Day04();
        $input = [$solver::STRING_INPUT];
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::SOLUTIONS;
        self::assertSame(strval($expected1), $ans1);
        self::assertSame(strval($expected2), $ans2);
    }

    // --------------------------------------------------------------------

    /**
     * @covers \TBali\Aoc2019\Aoc2019Day05
     */
    public function testDay05(): void
    {
        $solver = new Aoc2019Day05();
        $input = $solver->readInput($solver->inputBaseFileName() . '.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::SOLUTIONS;
        self::assertSame(strval($expected1), $ans1);
        self::assertSame(strval($expected2), $ans2);
    }

    /**
     * @covers \TBali\Aoc2019\Aoc2019Day05
     */
    public function testDay05InvalidInput1(): void
    {
        $solver = new Aoc2019Day05();
        $input = ['1,1,1,3'];
        $this->expectException(\Exception::class);
        [$ans1, $ans2] = $solver->solve($input);
    }

    /**
     * @covers \TBali\Aoc2019\Aoc2019Day05
     */
    public function testDay05InvalidInput2(): void
    {
        $solver = new Aoc2019Day05();
        $input = ['1,1'];
        $this->expectException(\Exception::class);
        [$ans1, $ans2] = $solver->solve($input);
    }

    // --------------------------------------------------------------------

    /**
     * @covers \TBali\Aoc2019\Aoc2019Day06
     */
    public function testDay06Example1(): void
    {
        $solver = new Aoc2019Day06();
        $input = $solver->readInput($solver->inputBaseFileName() . 'ex1.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::EXAMPLE_SOLUTIONS[0];
        self::assertSame(strval($expected1), $ans1);
        // self::assertSame(strval($expected2), $ans2);
    }

    /**
     * @covers \TBali\Aoc2019\Aoc2019Day06
     */
    public function testDay06Example2(): void
    {
        $solver = new Aoc2019Day06();
        $input = $solver->readInput($solver->inputBaseFileName() . 'ex2.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::EXAMPLE_SOLUTIONS[1];
        // self::assertSame(strval($expected1), $ans1);
        self::assertSame(strval($expected2), $ans2);
    }

    /**
     * @covers \TBali\Aoc2019\Aoc2019Day06
     */
    public function testDay06(): void
    {
        $solver = new Aoc2019Day06();
        $input = $solver->readInput($solver->inputBaseFileName() . '.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::SOLUTIONS;
        self::assertSame(strval($expected1), $ans1);
        self::assertSame(strval($expected2), $ans2);
    }

    /**
     * @covers \TBali\Aoc2019\Aoc2019Day06
     */
    public function testDay06InvalidInput1(): void
    {
        $solver = new Aoc2019Day06();
        $input = ['a'];
        $this->expectException(\Exception::class);
        [$ans1, $ans2] = $solver->solve($input);
    }

    /**
     * @covers \TBali\Aoc2019\Aoc2019Day06
     */
    public function testDay06InvalidInput2(): void
    {
        $solver = new Aoc2019Day06();
        $input = ['A)YOU', 'B)SAN'];
        $this->expectException(\Exception::class);
        [$ans1, $ans2] = $solver->solve($input);
    }

    // --------------------------------------------------------------------

    /**
     * @covers \TBali\Aoc2019\AmplifierSimulator
     * @covers \TBali\Aoc2019\Aoc2019Day07
     */
    public function testDay07Example1(): void
    {
        $solver = new Aoc2019Day07();
        $input = $solver->readInput($solver->inputBaseFileName() . 'ex1.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::EXAMPLE_SOLUTIONS[0];
        self::assertSame(strval($expected1), $ans1);
        // self::assertSame(strval($expected2), $ans2);
    }

    /**
     * @covers \TBali\Aoc2019\AmplifierSimulator
     * @covers \TBali\Aoc2019\Aoc2019Day07
     */
    public function testDay07Example2(): void
    {
        $solver = new Aoc2019Day07();
        $input = $solver->readInput($solver->inputBaseFileName() . 'ex2.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::EXAMPLE_SOLUTIONS[1];
        self::assertSame(strval($expected1), $ans1);
        // self::assertSame(strval($expected2), $ans2);
    }

    /**
     * @covers \TBali\Aoc2019\AmplifierSimulator
     * @covers \TBali\Aoc2019\Aoc2019Day07
     */
    public function testDay07Example3(): void
    {
        $solver = new Aoc2019Day07();
        $input = $solver->readInput($solver->inputBaseFileName() . 'ex3.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::EXAMPLE_SOLUTIONS[2];
        self::assertSame(strval($expected1), $ans1);
        // self::assertSame(strval($expected2), $ans2);
    }

    /**
     * @covers \TBali\Aoc2019\AmplifierSimulator
     * @covers \TBali\Aoc2019\Aoc2019Day07
     */
    public function testDay07Example4(): void
    {
        $solver = new Aoc2019Day07();
        $input = $solver->readInput($solver->inputBaseFileName() . 'ex4.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::EXAMPLE_SOLUTIONS[3];
        // self::assertSame(strval($expected1), $ans1);
        self::assertSame(strval($expected2), $ans2);
    }

    /**
     * @covers \TBali\Aoc2019\AmplifierSimulator
     * @covers \TBali\Aoc2019\Aoc2019Day07
     */
    public function testDay07Example5(): void
    {
        $solver = new Aoc2019Day07();
        $input = $solver->readInput($solver->inputBaseFileName() . 'ex5.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::EXAMPLE_SOLUTIONS[4];
        // self::assertSame(strval($expected1), $ans1);
        self::assertSame(strval($expected2), $ans2);
    }

    /**
     * @covers \TBali\Aoc2019\AmplifierSimulator
     * @covers \TBali\Aoc2019\Aoc2019Day07
     */
    public function testDay07(): void
    {
        $solver = new Aoc2019Day07();
        $input = $solver->readInput($solver->inputBaseFileName() . '.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::SOLUTIONS;
        self::assertSame(strval($expected1), $ans1);
        self::assertSame(strval($expected2), $ans2);
    }

    /**
     * @covers \TBali\Aoc2019\AmplifierSimulator
     * @covers \TBali\Aoc2019\Aoc2019Day07
     */
    public function testDay07InvalidInput1(): void
    {
        $solver = new Aoc2019Day07();
        $input = ['1,1,1,3'];
        $this->expectException(\Exception::class);
        [$ans1, $ans2] = $solver->solve($input);
    }

    /**
     * @covers \TBali\Aoc2019\AmplifierSimulator
     * @covers \TBali\Aoc2019\Aoc2019Day07
     */
    public function testDay07InvalidInput2(): void
    {
        $solver = new Aoc2019Day07();
        $input = ['1,1'];
        $this->expectException(\Exception::class);
        [$ans1, $ans2] = $solver->solve($input);
    }

    // --------------------------------------------------------------------

    /**
     * @covers \TBali\Aoc2019\Aoc2019Day08
     */
    public function testDay08(): void
    {
        $solver = new Aoc2019Day08();
        $input = $solver->readInput($solver->inputBaseFileName() . '.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::SOLUTIONS;
        self::assertSame(strval($expected1), $ans1);
        self::assertSame(strval($expected2), $ans2);
    }

    // --------------------------------------------------------------------

    /**
     * @covers \TBali\Aoc2019\Aoc2019Day09
     * @covers \TBali\Aoc2019\BoostSimulator
     */
    public function testDay09Example1(): void
    {
        $solver = new Aoc2019Day09();
        $input = $solver->readInput($solver->inputBaseFileName() . 'ex1.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::EXAMPLE_SOLUTIONS[0];
        self::assertSame(strval($expected1), $ans1);
        // self::assertSame(strval($expected2), $ans2);
    }

    /**
     * @covers \TBali\Aoc2019\Aoc2019Day09
     * @covers \TBali\Aoc2019\BoostSimulator
     *
     * @group medium
     */
    public function testDay09(): void
    {
        $solver = new Aoc2019Day09();
        $input = $solver->readInput($solver->inputBaseFileName() . '.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::SOLUTIONS;
        self::assertSame(strval($expected1), $ans1);
        self::assertSame(strval($expected2), $ans2);
    }

    /**
     * @covers \TBali\Aoc2019\Aoc2019Day09
     * @covers \TBali\Aoc2019\BoostSimulator
     */
    public function testDay09InvalidInput1(): void
    {
        $solver = new Aoc2019Day09();
        $input = ['1,1,1,3'];
        $this->expectException(\Exception::class);
        [$ans1, $ans2] = $solver->solve($input);
    }

    /**
     * @covers \TBali\Aoc2019\Aoc2019Day09
     * @covers \TBali\Aoc2019\BoostSimulator
     */
    public function testDay09InvalidInput2(): void
    {
        $solver = new Aoc2019Day09();
        $input = ['1,1'];
        $this->expectException(\Exception::class);
        [$ans1, $ans2] = $solver->solve($input);
    }

    // --------------------------------------------------------------------

    /**
     * @covers \TBali\Aoc2019\Aoc2019Day10
     */
    public function testDay10Example1(): void
    {
        $solver = new Aoc2019Day10();
        $input = $solver->readInput($solver->inputBaseFileName() . 'ex1.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::EXAMPLE_SOLUTIONS[0];
        self::assertSame(strval($expected1), $ans1);
        // self::assertSame(strval($expected2), $ans2);
    }

    /**
     * @covers \TBali\Aoc2019\Aoc2019Day10
     */
    public function testDay10Example2(): void
    {
        $solver = new Aoc2019Day10();
        $input = $solver->readInput($solver->inputBaseFileName() . 'ex2.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::EXAMPLE_SOLUTIONS[1];
        self::assertSame(strval($expected1), $ans1);
        // self::assertSame(strval($expected2), $ans2);
    }

    /**
     * @covers \TBali\Aoc2019\Aoc2019Day10
     */
    public function testDay10Example3(): void
    {
        $solver = new Aoc2019Day10();
        $input = $solver->readInput($solver->inputBaseFileName() . 'ex3.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::EXAMPLE_SOLUTIONS[2];
        self::assertSame(strval($expected1), $ans1);
        // self::assertSame(strval($expected2), $ans2);
    }

    /**
     * @covers \TBali\Aoc2019\Aoc2019Day10
     */
    public function testDay10Example4(): void
    {
        $solver = new Aoc2019Day10();
        $input = $solver->readInput($solver->inputBaseFileName() . 'ex4.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::EXAMPLE_SOLUTIONS[3];
        self::assertSame(strval($expected1), $ans1);
        // self::assertSame(strval($expected2), $ans2);
    }

    /**
     * @covers \TBali\Aoc2019\Aoc2019Day10
     *
     * @group medium
     */
    public function testDay10Example5(): void
    {
        $solver = new Aoc2019Day10();
        $input = $solver->readInput($solver->inputBaseFileName() . 'ex5.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::EXAMPLE_SOLUTIONS[4];
        self::assertSame(strval($expected1), $ans1);
        self::assertSame(strval($expected2), $ans2);
    }

    /**
     * @covers \TBali\Aoc2019\Aoc2019Day10
     */
    public function testDay10Example6(): void
    {
        $solver = new Aoc2019Day10();
        $input = $solver->readInput($solver->inputBaseFileName() . 'ex6.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::EXAMPLE_SOLUTIONS[5];
        // self::assertSame(strval($expected1), $ans1);
        self::assertSame(strval($expected2), $ans2);
    }

    /**
     * @covers \TBali\Aoc2019\Aoc2019Day10
     *
     * @group medium
     */
    public function testDay10(): void
    {
        $solver = new Aoc2019Day10();
        $input = $solver->readInput($solver->inputBaseFileName() . '.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::SOLUTIONS;
        self::assertSame(strval($expected1), $ans1);
        self::assertSame(strval($expected2), $ans2);
    }

    // --------------------------------------------------------------------

    /**
     * @covers \TBali\Aoc2019\Aoc2019Day11
     * @covers \TBali\Aoc2019\HullPaintSimulator
     */
    public function testDay11(): void
    {
        $solver = new Aoc2019Day11();
        $input = $solver->readInput($solver->inputBaseFileName() . '.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::SOLUTIONS;
        self::assertSame(strval($expected1), $ans1);
        self::assertSame(strval($expected2), $ans2);
    }

    /**
     * @covers \TBali\Aoc2019\Aoc2019Day11
     * @covers \TBali\Aoc2019\HullPaintSimulator
     */
    public function testDay11InvalidInput1(): void
    {
        $solver = new Aoc2019Day11();
        $input = ['1,1,1,3'];
        $this->expectException(\Exception::class);
        [$ans1, $ans2] = $solver->solve($input);
    }

    /**
     * @covers \TBali\Aoc2019\Aoc2019Day11
     * @covers \TBali\Aoc2019\HullPaintSimulator
     */
    public function testDay11InvalidInput2(): void
    {
        $solver = new Aoc2019Day11();
        $input = ['1,1'];
        $this->expectException(\Exception::class);
        [$ans1, $ans2] = $solver->solve($input);
    }

    // --------------------------------------------------------------------

    /**
     * @covers \TBali\Aoc2019\Aoc2019Day12
     * @covers \TBali\Aoc2019\Moon
     */
    public function testDay12Example1(): void
    {
        $solver = new Aoc2019Day12();
        $input = $solver->readInput($solver->inputBaseFileName() . 'ex1.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::EXAMPLE_SOLUTIONS[0];
        self::assertSame(strval($expected1), $ans1);
        self::assertSame(strval($expected2), $ans2);
    }

    /**
     * @covers \TBali\Aoc2019\Aoc2019Day12
     * @covers \TBali\Aoc2019\Moon
     */
    public function testDay12Example2(): void
    {
        $solver = new Aoc2019Day12();
        $input = $solver->readInput($solver->inputBaseFileName() . 'ex2.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::EXAMPLE_SOLUTIONS[1];
        self::assertSame(strval($expected1), $ans1);
        self::assertSame(strval($expected2), $ans2);
    }

    /**
     * @covers \TBali\Aoc2019\Aoc2019Day12
     * @covers \TBali\Aoc2019\Moon
     *
     * @group large
     */
    public function testDay12(): void
    {
        $solver = new Aoc2019Day12();
        $input = $solver->readInput($solver->inputBaseFileName() . '.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::SOLUTIONS;
        self::assertSame(strval($expected1), $ans1);
        self::assertSame(strval($expected2), $ans2);
    }

    /**
     * @covers \TBali\Aoc2019\Aoc2019Day12
     * @covers \TBali\Aoc2019\Moon
     */
    public function testDay12InvalidInput1(): void
    {
        $solver = new Aoc2019Day12();
        $input = ['<x=0, y=0>'];
        $this->expectException(\Exception::class);
        [$ans1, $ans2] = $solver->solve($input);
    }

    // --------------------------------------------------------------------

    /**
     * @covers \TBali\Aoc2019\Aoc2019Day13
     * @covers \TBali\Aoc2019\ArcadeSimulator
     *
     * @group medium
     */
    public function testDay13(): void
    {
        $solver = new Aoc2019Day13();
        $input = $solver->readInput($solver->inputBaseFileName() . '.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::SOLUTIONS;
        self::assertSame(strval($expected1), $ans1);
        self::assertSame(strval($expected2), $ans2);
    }

    /**
     * @covers \TBali\Aoc2019\Aoc2019Day13
     * @covers \TBali\Aoc2019\ArcadeSimulator
     */
    public function testDay13InvalidInput1(): void
    {
        $solver = new Aoc2019Day13();
        $input = ['1,1,1,3'];
        $this->expectException(\Exception::class);
        [$ans1, $ans2] = $solver->solve($input);
    }

    /**
     * @covers \TBali\Aoc2019\Aoc2019Day13
     * @covers \TBali\Aoc2019\ArcadeSimulator
     */
    public function testDay13InvalidInput2(): void
    {
        $solver = new Aoc2019Day13();
        $input = ['1,1'];
        $this->expectException(\Exception::class);
        [$ans1, $ans2] = $solver->solve($input);
    }

    // --------------------------------------------------------------------

    /**
     * @covers \TBali\Aoc2019\Aoc2019Day14
     * @covers \TBali\Aoc2019\Recipe
     */
    public function testDay14Example1(): void
    {
        $solver = new Aoc2019Day14();
        $input = $solver->readInput($solver->inputBaseFileName() . 'ex1.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::EXAMPLE_SOLUTIONS[0];
        self::assertSame(strval($expected1), $ans1);
        // self::assertSame(strval($expected2), $ans2);
    }

    /**
     * @covers \TBali\Aoc2019\Aoc2019Day14
     * @covers \TBali\Aoc2019\Recipe
     */
    public function testDay14Example2(): void
    {
        $solver = new Aoc2019Day14();
        $input = $solver->readInput($solver->inputBaseFileName() . 'ex2.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::EXAMPLE_SOLUTIONS[1];
        self::assertSame(strval($expected1), $ans1);
        // self::assertSame(strval($expected2), $ans2);
    }

    /**
     * @covers \TBali\Aoc2019\Aoc2019Day14
     * @covers \TBali\Aoc2019\Recipe
     */
    public function testDay14Example3(): void
    {
        $solver = new Aoc2019Day14();
        $input = $solver->readInput($solver->inputBaseFileName() . 'ex3.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::EXAMPLE_SOLUTIONS[2];
        self::assertSame(strval($expected1), $ans1);
        self::assertSame(strval($expected2), $ans2);
    }

    /**
     * @covers \TBali\Aoc2019\Aoc2019Day14
     * @covers \TBali\Aoc2019\Recipe
     */
    public function testDay14Example4(): void
    {
        $solver = new Aoc2019Day14();
        $input = $solver->readInput($solver->inputBaseFileName() . 'ex4.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::EXAMPLE_SOLUTIONS[3];
        self::assertSame(strval($expected1), $ans1);
        self::assertSame(strval($expected2), $ans2);
    }

    /**
     * @covers \TBali\Aoc2019\Aoc2019Day14
     * @covers \TBali\Aoc2019\Recipe
     */
    public function testDay14Example5(): void
    {
        $solver = new Aoc2019Day14();
        $input = $solver->readInput($solver->inputBaseFileName() . 'ex5.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::EXAMPLE_SOLUTIONS[4];
        self::assertSame(strval($expected1), $ans1);
        self::assertSame(strval($expected2), $ans2);
    }

    /**
     * @covers \TBali\Aoc2019\Aoc2019Day14
     * @covers \TBali\Aoc2019\Recipe
     */
    public function testDay14(): void
    {
        $solver = new Aoc2019Day14();
        $input = $solver->readInput($solver->inputBaseFileName() . '.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::SOLUTIONS;
        self::assertSame(strval($expected1), $ans1);
        self::assertSame(strval($expected2), $ans2);
    }

    /**
     * @covers \TBali\Aoc2019\Aoc2019Day14
     * @covers \TBali\Aoc2019\Recipe
     */
    public function testDay14InvalidInput1(): void
    {
        $solver = new Aoc2019Day14();
        $input = ['1 ORE'];
        $this->expectException(\Exception::class);
        [$ans1, $ans2] = $solver->solve($input);
    }

    /**
     * @covers \TBali\Aoc2019\Aoc2019Day14
     * @covers \TBali\Aoc2019\Recipe
     */
    public function testDay14InvalidInput2(): void
    {
        $solver = new Aoc2019Day14();
        $input = ['1 ORE => FUEL'];
        $this->expectException(\Exception::class);
        [$ans1, $ans2] = $solver->solve($input);
    }

    /**
     * @covers \TBali\Aoc2019\Aoc2019Day14
     * @covers \TBali\Aoc2019\Recipe
     */
    public function testDay14InvalidInput3(): void
    {
        $solver = new Aoc2019Day14();
        $input = ['ORE => 1 FUEL'];
        $this->expectException(\Exception::class);
        [$ans1, $ans2] = $solver->solve($input);
    }

    // --------------------------------------------------------------------

    /**
     * @covers \TBali\Aoc2019\Aoc2019Day15
     * @covers \TBali\Aoc2019\DroidSimulator
     * @covers \TBali\Aoc2019\Map
     *
     * @group medium
     */
    public function testDay15(): void
    {
        $solver = new Aoc2019Day15();
        $input = $solver->readInput($solver->inputBaseFileName() . '.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::SOLUTIONS;
        self::assertSame(strval($expected1), $ans1);
        self::assertSame(strval($expected2), $ans2);
    }

    // --------------------------------------------------------------------

    /**
     * @covers \TBali\Aoc2019\Aoc2019Day16
     */
    public function testDay16Example1(): void
    {
        $solver = new Aoc2019Day16();
        $input = $solver->readInput($solver->inputBaseFileName() . 'ex1.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::EXAMPLE_SOLUTIONS[0];
        self::assertSame(strval($expected1), $ans1);
        // self::assertSame(strval($expected2), $ans2);
    }

    /**
     * @covers \TBali\Aoc2019\Aoc2019Day16
     */
    public function testDay16Example2(): void
    {
        $solver = new Aoc2019Day16();
        $input = $solver->readInput($solver->inputBaseFileName() . 'ex2.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::EXAMPLE_SOLUTIONS[1];
        self::assertSame(strval($expected1), $ans1);
        // self::assertSame(strval($expected2), $ans2);
    }

    /**
     * @covers \TBali\Aoc2019\Aoc2019Day16
     */
    public function testDay16Example3(): void
    {
        $solver = new Aoc2019Day16();
        $input = $solver->readInput($solver->inputBaseFileName() . 'ex3.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::EXAMPLE_SOLUTIONS[2];
        self::assertSame(strval($expected1), $ans1);
        // self::assertSame(strval($expected2), $ans2);
    }

    /**
     * @covers \TBali\Aoc2019\Aoc2019Day16
     *
     * @group large
     */
    public function testDay16(): void
    {
        $solver = new Aoc2019Day16();
        $input = $solver->readInput($solver->inputBaseFileName() . '.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::SOLUTIONS;
        self::assertSame(strval($expected1), $ans1);
        self::assertSame(strval($expected2), $ans2);
    }

    // --------------------------------------------------------------------

    /**
     * @covers \TBali\Aoc2019\Aoc2019Day17
     * @covers \TBali\Aoc2019\AsciiSimulator
     */
    public function testDay17(): void
    {
        $solver = new Aoc2019Day17();
        $input = $solver->readInput($solver->inputBaseFileName() . '.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::SOLUTIONS;
        self::assertSame(strval($expected1), $ans1);
        self::assertSame(strval($expected2), $ans2);
    }

    // --------------------------------------------------------------------

    /**
     * @covers \TBali\Aoc2019\Aoc2019Day18
     */
    public function testDay18Example1(): void
    {
        $solver = new Aoc2019Day18();
        $input = $solver->readInput($solver->inputBaseFileName() . 'ex1.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::EXAMPLE_SOLUTIONS[0];
        self::assertSame(strval($expected1), $ans1);
        // self::assertSame(strval($expected2), $ans2);
    }

    /**
     * @covers \TBali\Aoc2019\Aoc2019Day18
     */
    public function testDay18Example2(): void
    {
        $solver = new Aoc2019Day18();
        $input = $solver->readInput($solver->inputBaseFileName() . 'ex2.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::EXAMPLE_SOLUTIONS[1];
        self::assertSame(strval($expected1), $ans1);
        // self::assertSame(strval($expected2), $ans2);
    }

    /**
     * @covers \TBali\Aoc2019\Aoc2019Day18
     */
    public function testDay18Example3(): void
    {
        $solver = new Aoc2019Day18();
        $input = $solver->readInput($solver->inputBaseFileName() . 'ex3.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::EXAMPLE_SOLUTIONS[2];
        self::assertSame(strval($expected1), $ans1);
        // self::assertSame(strval($expected2), $ans2);
    }

    /**
     * @covers \TBali\Aoc2019\Aoc2019Day18
     */
    public function testDay18Example4(): void
    {
        $solver = new Aoc2019Day18();
        $input = $solver->readInput($solver->inputBaseFileName() . 'ex4.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::EXAMPLE_SOLUTIONS[3];
        self::assertSame(strval($expected1), $ans1);
        // self::assertSame(strval($expected2), $ans2);
    }

    /**
     * @covers \TBali\Aoc2019\Aoc2019Day18
     */
    public function testDay18Example5(): void
    {
        $solver = new Aoc2019Day18();
        $input = $solver->readInput($solver->inputBaseFileName() . 'ex5.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::EXAMPLE_SOLUTIONS[4];
        self::assertSame(strval($expected1), $ans1);
        // self::assertSame(strval($expected2), $ans2);
    }

    /**
     * @covers \TBali\Aoc2019\Aoc2019Day18
     */
    public function testDay18Example6(): void
    {
        $solver = new Aoc2019Day18();
        $input = $solver->readInput($solver->inputBaseFileName() . 'ex6.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::EXAMPLE_SOLUTIONS[5];
        // self::assertSame(strval($expected1), $ans1);
        self::assertSame(strval($expected2), $ans2);
    }

    /**
     * @covers \TBali\Aoc2019\Aoc2019Day18
     */
    public function testDay18Example7(): void
    {
        $solver = new Aoc2019Day18();
        $input = $solver->readInput($solver->inputBaseFileName() . 'ex7.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::EXAMPLE_SOLUTIONS[6];
        // self::assertSame(strval($expected1), $ans1);
        self::assertSame(strval($expected2), $ans2);
    }

    /**
     * @covers \TBali\Aoc2019\Aoc2019Day18
     */
    public function testDay18Example8(): void
    {
        $solver = new Aoc2019Day18();
        $input = $solver->readInput($solver->inputBaseFileName() . 'ex8.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::EXAMPLE_SOLUTIONS[7];
        // self::assertSame(strval($expected1), $ans1);
        self::assertSame(strval($expected2), $ans2);
    }

    /**
     * @covers \TBali\Aoc2019\Aoc2019Day18
     *
     * @group large
     */
    public function testDay18(): void
    {
        $solver = new Aoc2019Day18();
        $input = $solver->readInput($solver->inputBaseFileName() . '.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::SOLUTIONS;
        self::assertSame(strval($expected1), $ans1);
        self::assertSame(strval($expected2), $ans2);
    }

    /**
     * @covers \TBali\Aoc2019\Aoc2019Day18
     */
    public function testDay18InvalidInput1(): void
    {
        $solver = new Aoc2019Day18();
        $input = ['###', '#.#', '###'];
        $this->expectException(\Exception::class);
        [$ans1, $ans2] = $solver->solve($input);
    }

    // --------------------------------------------------------------------

    /**
     * @covers \TBali\Aoc2019\Aoc2019Day19
     * @covers \TBali\Aoc2019\DroneSimulator
     *
     * @group large
     */
    public function testDay19(): void
    {
        $solver = new Aoc2019Day19();
        $input = $solver->readInput($solver->inputBaseFileName() . '.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::SOLUTIONS;
        self::assertSame(strval($expected1), $ans1);
        self::assertSame(strval($expected2), $ans2);
    }

    // --------------------------------------------------------------------

    /**
     * @covers \TBali\Aoc2019\Aoc2019Day20
     */
    public function testDay20Example1(): void
    {
        $solver = new Aoc2019Day20();
        $input = $solver->readInput($solver->inputBaseFileName() . 'ex1.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::EXAMPLE_SOLUTIONS[0];
        self::assertSame(strval($expected1), $ans1);
        // self::assertSame(strval($expected2), $ans2);
    }

    /**
     * @covers \TBali\Aoc2019\Aoc2019Day20
     */
    public function testDay20Example2(): void
    {
        $solver = new Aoc2019Day20();
        $input = $solver->readInput($solver->inputBaseFileName() . 'ex2.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::EXAMPLE_SOLUTIONS[1];
        self::assertSame(strval($expected1), $ans1);
        // self::assertSame(strval($expected2), $ans2);
    }

    /**
     * @covers \TBali\Aoc2019\Aoc2019Day20
     */
    public function testDay20Example3(): void
    {
        $solver = new Aoc2019Day20();
        $input = $solver->readInput($solver->inputBaseFileName() . 'ex3.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::EXAMPLE_SOLUTIONS[2];
        // self::assertSame(strval($expected1), $ans1);
        self::assertSame(strval($expected2), $ans2);
    }

    /**
     * @covers \TBali\Aoc2019\Aoc2019Day20
     *
     * @group medium
     */
    public function testDay20(): void
    {
        $solver = new Aoc2019Day20();
        $input = $solver->readInput($solver->inputBaseFileName() . '.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::SOLUTIONS;
        self::assertSame(strval($expected1), $ans1);
        self::assertSame(strval($expected2), $ans2);
    }

    // --------------------------------------------------------------------

    /**
     * @covers \TBali\Aoc2019\Aoc2019Day21
     * @covers \TBali\Aoc2019\SpringDroidSimulator
     */
    public function testDay21(): void
    {
        $solver = new Aoc2019Day21();
        $input = $solver->readInput($solver->inputBaseFileName() . '.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::SOLUTIONS;
        self::assertSame(strval($expected1), $ans1);
        self::assertSame(strval($expected2), $ans2);
    }

    // --------------------------------------------------------------------

    /**
     * @covers \TBali\Aoc2019\Aoc2019Day22
     * @covers \TBali\Aoc2019\Deck
     * @covers \TBali\Aoc2019\LCF
     * @covers \TBali\Aoc2019\Modulo
     */
    public function testDay22Example1(): void
    {
        $solver = new Aoc2019Day22();
        $input = $solver->readInput($solver->inputBaseFileName() . 'ex1.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::EXAMPLE_SOLUTIONS[0];
        self::assertSame(strval($expected1), $ans1);
        // self::assertSame(strval($expected2), $ans2);
    }

    /**
     * @covers \TBali\Aoc2019\Aoc2019Day22
     * @covers \TBali\Aoc2019\Deck
     * @covers \TBali\Aoc2019\LCF
     * @covers \TBali\Aoc2019\Modulo
     */
    public function testDay22Example2(): void
    {
        $solver = new Aoc2019Day22();
        $input = $solver->readInput($solver->inputBaseFileName() . 'ex2.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::EXAMPLE_SOLUTIONS[1];
        self::assertSame(strval($expected1), $ans1);
        // self::assertSame(strval($expected2), $ans2);
    }

    /**
     * @covers \TBali\Aoc2019\Aoc2019Day22
     * @covers \TBali\Aoc2019\Deck
     * @covers \TBali\Aoc2019\LCF
     * @covers \TBali\Aoc2019\Modulo
     * @covers \TBali\Aoc2019\LCF
     * @covers \TBali\Aoc2019\Modulo
     */
    public function testDay22Example3(): void
    {
        $solver = new Aoc2019Day22();
        $input = $solver->readInput($solver->inputBaseFileName() . 'ex3.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::EXAMPLE_SOLUTIONS[2];
        self::assertSame(strval($expected1), $ans1);
        // self::assertSame(strval($expected2), $ans2);
    }

    /**
     * @covers \TBali\Aoc2019\Aoc2019Day22
     * @covers \TBali\Aoc2019\Deck
     * @covers \TBali\Aoc2019\LCF
     * @covers \TBali\Aoc2019\Modulo
     */
    public function testDay22Example4(): void
    {
        $solver = new Aoc2019Day22();
        $input = $solver->readInput($solver->inputBaseFileName() . 'ex4.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::EXAMPLE_SOLUTIONS[3];
        self::assertSame(strval($expected1), $ans1);
        // self::assertSame(strval($expected2), $ans2);
    }

    /**
     * @covers \TBali\Aoc2019\Aoc2019Day22
     * @covers \TBali\Aoc2019\Deck
     * @covers \TBali\Aoc2019\LCF
     * @covers \TBali\Aoc2019\Modulo
     */
    public function testDay22(): void
    {
        $solver = new Aoc2019Day22();
        $input = $solver->readInput($solver->inputBaseFileName() . '.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::SOLUTIONS;
        self::assertSame(strval($expected1), $ans1);
        self::assertSame(strval($expected2), $ans2);
    }

    /**
     * @covers \TBali\Aoc2019\Aoc2019Day22
     * @covers \TBali\Aoc2019\Deck
     * @covers \TBali\Aoc2019\LCF
     * @covers \TBali\Aoc2019\Modulo
     */
    public function testDay22InvalidInput1(): void
    {
        $solver = new Aoc2019Day22();
        $input = ['shuffle'];
        $this->expectException(\Exception::class);
        [$ans1, $ans2] = $solver->solve($input);
    }

    // --------------------------------------------------------------------

    /**
     * @covers \TBali\Aoc2019\Aoc2019Day23
     * @covers \TBali\Aoc2019\NICSimulator
     */
    public function testDay23(): void
    {
        $solver = new Aoc2019Day23();
        $input = $solver->readInput($solver->inputBaseFileName() . '.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::SOLUTIONS;
        self::assertSame(strval($expected1), $ans1);
        self::assertSame(strval($expected2), $ans2);
    }

    // --------------------------------------------------------------------

    /**
     * @covers \TBali\Aoc2019\Aoc2019Day24
     */
    public function testDay24Example1(): void
    {
        $solver = new Aoc2019Day24();
        $input = $solver->readInput($solver->inputBaseFileName() . 'ex1.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::EXAMPLE_SOLUTIONS[0];
        self::assertSame(strval($expected1), $ans1);
        self::assertSame(strval($expected2), $ans2);
    }

    /**
     * @covers \TBali\Aoc2019\Aoc2019Day24
     *
     * @group medium
     */
    public function testDay24(): void
    {
        $solver = new Aoc2019Day24();
        $input = $solver->readInput($solver->inputBaseFileName() . '.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::SOLUTIONS;
        self::assertSame(strval($expected1), $ans1);
        self::assertSame(strval($expected2), $ans2);
    }

    /**
     * @covers \TBali\Aoc2019\Aoc2019Day24
     */
    public function testDay24InvalidInput1(): void
    {
        $solver = new Aoc2019Day24();
        $input = ['#.'];
        $this->expectException(\Exception::class);
        [$ans1, $ans2] = $solver->solve($input);
    }

    // --------------------------------------------------------------------

    /**
     * @covers \TBali\Aoc2019\AdventureSimulator
     * @covers \TBali\Aoc2019\Aoc2019Day25
     *
     * @group large
     */
    public function testDay25(): void
    {
        $solver = new Aoc2019Day25();
        $input = $solver->readInput($solver->inputBaseFileName() . '.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::SOLUTIONS;
        self::assertSame(strval($expected1), $ans1);
        // self::assertSame(strval($expected2), $ans2);
    }

    // --------------------------------------------------------------------
}
