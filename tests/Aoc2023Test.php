<?php

declare(strict_types=1);

namespace TBali\Tests;

use PHPUnit\Framework\Attributes\IgnoreClassForCodeCoverage;
use PHPUnit\Framework\Attributes\RequiresPhp;
use PHPUnit\Framework\Attributes\RequiresPhpunit;
use PHPUnit\Framework\TestCase;
use TBali\Aoc2023\Aoc2023Day01;
use TBali\Aoc2023\Aoc2023Day02;
use TBali\Aoc2023\Aoc2023Day03;
use TBali\Aoc2023\Aoc2023Day04;
use TBali\Aoc2023\Aoc2023Day05;

// use TBali\Aoc2023\Aoc2023Day06;
// use TBali\Aoc2023\Aoc2023Day07;
// use TBali\Aoc2023\Aoc2023Day08;
// use TBali\Aoc2023\Aoc2023Day09;
// use TBali\Aoc2023\Aoc2023Day10;
// use TBali\Aoc2023\Aoc2023Day11;
// use TBali\Aoc2023\Aoc2023Day12;
// use TBali\Aoc2023\Aoc2023Day13;
// use TBali\Aoc2023\Aoc2023Day14;
// use TBali\Aoc2023\Aoc2023Day15;
// use TBali\Aoc2023\Aoc2023Day16;
// use TBali\Aoc2023\Aoc2023Day17;
// use TBali\Aoc2023\Aoc2023Day18;
// use TBali\Aoc2023\Aoc2023Day19;
// use TBali\Aoc2023\Aoc2023Day20;
// use TBali\Aoc2023\Aoc2023Day21;
// use TBali\Aoc2023\Aoc2023Day22;
// use TBali\Aoc2023\Aoc2023Day23;
// use TBali\Aoc2023\Aoc2023Day24;
// use TBali\Aoc2023\Aoc2023Day25;

/**
 * Unit tests for Advent of Code season 2023.
 *
 * Instead of using this file with phpunit, it is a better way to run the solutions by using AoCRunner.
 *
 * @internal
 *
 * @coversNothing
 */
#[RequiresPhp('^8.3')]
#[RequiresPhpunit('^10.5')]
#[IgnoreClassForCodeCoverage(\TBali\Aoc\SolutionBase::class)]
final class Aoc2023Test extends TestCase
{
    // --------------------------------------------------------------------

    /**
     * @covers \TBali\Aoc2023\Aoc2023Day01
     */
    public function testDay01Example1(): void
    {
        $solver = new Aoc2023Day01();
        $input = $solver->readInput($solver->inputBaseFileName() . 'ex1.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::EXAMPLE_SOLUTIONS[0];
        self::assertSame(strval($expected1), $ans1);
        // self::assertSame(strval($expected2), $ans2);
    }

    /**
     * @covers \TBali\Aoc2023\Aoc2023Day01
     */
    public function testDay01Example2(): void
    {
        $solver = new Aoc2023Day01();
        $input = $solver->readInput($solver->inputBaseFileName() . 'ex2.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::EXAMPLE_SOLUTIONS[1];
        // self::assertSame(strval($expected1), $ans1);
        self::assertSame(strval($expected2), $ans2);
    }

    /**
     * @covers \TBali\Aoc2023\Aoc2023Day01
     */
    public function testDay01(): void
    {
        $solver = new Aoc2023Day01();
        $input = $solver->readInput($solver->inputBaseFileName() . '.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::SOLUTIONS;
        self::assertSame(strval($expected1), $ans1);
        self::assertSame(strval($expected2), $ans2);
    }

    // --------------------------------------------------------------------

    /**
     * @covers \TBali\Aoc2023\Aoc2023Day02
     * @covers \TBali\Aoc2023\Hand
     */
    public function testDay02Example1(): void
    {
        $solver = new Aoc2023Day02();
        $input = $solver->readInput($solver->inputBaseFileName() . 'ex1.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::EXAMPLE_SOLUTIONS[0];
        self::assertSame(strval($expected1), $ans1);
        self::assertSame(strval($expected2), $ans2);
    }

    /**
     * @covers \TBali\Aoc2023\Aoc2023Day02
     * @covers \TBali\Aoc2023\Hand
     */
    public function testDay02(): void
    {
        $solver = new Aoc2023Day02();
        $input = $solver->readInput($solver->inputBaseFileName() . '.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::SOLUTIONS;
        self::assertSame(strval($expected1), $ans1);
        self::assertSame(strval($expected2), $ans2);
    }

    /**
     * @covers \TBali\Aoc2023\Aoc2023Day02
     * @covers \TBali\Aoc2023\Hand
     */
    public function testDay02InvalidInput1(): void
    {
        $solver = new Aoc2023Day02();
        $input = ['Game 1'];
        $this->expectException(\Exception::class);
        [$ans1, $ans2] = $solver->solve($input);
    }

    /**
     * @covers \TBali\Aoc2023\Aoc2023Day02
     * @covers \TBali\Aoc2023\Hand
     */
    public function testDay02InvalidInput2(): void
    {
        $solver = new Aoc2023Day02();
        $input = ['Game 1: 1 Blue, 2 Yellow'];
        $this->expectException(\Exception::class);
        [$ans1, $ans2] = $solver->solve($input);
    }

    // --------------------------------------------------------------------

    /**
     * @covers \TBali\Aoc2023\Aoc2023Day03
     */
    public function testDay03Example1(): void
    {
        $solver = new Aoc2023Day03();
        $input = $solver->readInput($solver->inputBaseFileName() . 'ex1.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::EXAMPLE_SOLUTIONS[0];
        self::assertSame(strval($expected1), $ans1);
        self::assertSame(strval($expected2), $ans2);
    }

    /**
     * @covers \TBali\Aoc2023\Aoc2023Day03
     */
    public function testDay03(): void
    {
        $solver = new Aoc2023Day03();
        $input = $solver->readInput($solver->inputBaseFileName() . '.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::SOLUTIONS;
        self::assertSame(strval($expected1), $ans1);
        self::assertSame(strval($expected2), $ans2);
    }

    // --------------------------------------------------------------------

    /**
     * @covers \TBali\Aoc2023\Aoc2023Day04
     */
    public function testDay04Example1(): void
    {
        $solver = new Aoc2023Day04();
        $input = $solver->readInput($solver->inputBaseFileName() . 'ex1.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::EXAMPLE_SOLUTIONS[0];
        self::assertSame(strval($expected1), $ans1);
        self::assertSame(strval($expected2), $ans2);
    }

    /**
     * @covers \TBali\Aoc2023\Aoc2023Day04
     */
    public function testDay04(): void
    {
        $solver = new Aoc2023Day04();
        $input = $solver->readInput($solver->inputBaseFileName() . '.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::SOLUTIONS;
        self::assertSame(strval($expected1), $ans1);
        self::assertSame(strval($expected2), $ans2);
    }

    /**
     * @covers \TBali\Aoc2023\Aoc2023Day04
     */
    public function testDay04InvalidInput1(): void
    {
        $solver = new Aoc2023Day04();
        $input = ['a'];
        $this->expectException(\Exception::class);
        [$ans1, $ans2] = $solver->solve($input);
    }

    /**
     * @covers \TBali\Aoc2023\Aoc2023Day04
     */
    public function testDay04InvalidInput2(): void
    {
        $solver = new Aoc2023Day04();
        $input = ['Card 1: 2'];
        $this->expectException(\Exception::class);
        [$ans1, $ans2] = $solver->solve($input);
    }

    // --------------------------------------------------------------------

    /**
     * @covers \TBali\Aoc2023\Aoc2023Day05
     */
    public function testDay05Example1(): void
    {
        $solver = new Aoc2023Day05();
        $input = $solver->readInput($solver->inputBaseFileName() . 'ex1.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::EXAMPLE_SOLUTIONS[0];
        self::assertSame(strval($expected1), $ans1);
        self::assertSame(strval($expected2), $ans2);
    }

    /**
     * @covers \TBali\Aoc2023\Aoc2023Day05
     */
    public function testDay05(): void
    {
        $solver = new Aoc2023Day05();
        $input = $solver->readInput($solver->inputBaseFileName() . '.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::SOLUTIONS;
        self::assertSame(strval($expected1), $ans1);
        self::assertSame(strval($expected2), $ans2);
    }

    /**
     * @covers \TBali\Aoc2023\Aoc2023Day05
     */
    public function testDay05InvalidInput1(): void
    {
        $solver = new Aoc2023Day05();
        $input = ['a'];
        $this->expectException(\Exception::class);
        [$ans1, $ans2] = $solver->solve($input);
    }

    /**
     * @covers \TBali\Aoc2023\Aoc2023Day05
     */
    public function testDay05InvalidInput2(): void
    {
        $solver = new Aoc2023Day05();
        $input = ['seeds: 1', '', 'a', '0 1 2'];
        $this->expectException(\Exception::class);
        [$ans1, $ans2] = $solver->solve($input);
    }

    /**
     * @covers \TBali\Aoc2023\Aoc2023Day05
     */
    public function testDay05InvalidInput3(): void
    {
        $solver = new Aoc2023Day05();
        $input = ['seeds: 1', '', 'seed-to-soil map:', '0 1'];
        $this->expectException(\Exception::class);
        [$ans1, $ans2] = $solver->solve($input);
    }

    // --------------------------------------------------------------------

    // /**
    //  * @covers \TBali\Aoc2023\Aoc2023Day06
    //  */
    // public function testDay06Example1(): void
    // {
    //     $solver = new Aoc2023Day06();
    //     $input = $solver->readInput($solver->inputBaseFileName() . 'ex1.txt');
    //     [$ans1, $ans2] = $solver->solve($input);
    //     [$expected1, $expected2] = $solver::EXAMPLE_SOLUTIONS[0];
    //     self::assertSame(strval($expected1), $ans1);
    //     self::assertSame(strval($expected2), $ans2);
    // }

    // /**
    //  * @covers \TBali\Aoc2023\Aoc2023Day06
    //  */
    // public function testDay06Example2(): void
    // {
    //     $solver = new Aoc2023Day06();
    //     $input = $solver->readInput($solver->inputBaseFileName() . 'ex2.txt');
    //     [$ans1, $ans2] = $solver->solve($input);
    //     [$expected1, $expected2] = $solver::EXAMPLE_SOLUTIONS[1];
    //     self::assertSame(strval($expected1), $ans1);
    //     self::assertSame(strval($expected2), $ans2);
    // }

    // /**
    //  * @covers \TBali\Aoc2023\Aoc2023Day06
    //  */
    // public function testDay06(): void
    // {
    //     $solver = new Aoc2023Day06();
    //     $input = $solver->readInput($solver->inputBaseFileName() . '.txt');
    //     [$ans1, $ans2] = $solver->solve($input);
    //     [$expected1, $expected2] = $solver::SOLUTIONS;
    //     self::assertSame(strval($expected1), $ans1);
    //     self::assertSame(strval($expected2), $ans2);
    // }

    // // --------------------------------------------------------------------

    // /**
    //  * @covers \TBali\Aoc2023\Aoc2023Day07
    //  */
    // public function testDay07Example1(): void
    // {
    //     $solver = new Aoc2023Day07();
    //     $input = $solver->readInput($solver->inputBaseFileName() . 'ex1.txt');
    //     [$ans1, $ans2] = $solver->solve($input);
    //     [$expected1, $expected2] = $solver::EXAMPLE_SOLUTIONS[0];
    //     self::assertSame(strval($expected1), $ans1);
    //     self::assertSame(strval($expected2), $ans2);
    // }

    // /**
    //  * @covers \TBali\Aoc2023\Aoc2023Day07
    //  */
    // public function testDay07(): void
    // {
    //     $solver = new Aoc2023Day07();
    //     $input = $solver->readInput($solver->inputBaseFileName() . '.txt');
    //     [$ans1, $ans2] = $solver->solve($input);
    //     [$expected1, $expected2] = $solver::SOLUTIONS;
    //     self::assertSame(strval($expected1), $ans1);
    //     self::assertSame(strval($expected2), $ans2);
    // }

    // /**
    //  * @covers \TBali\Aoc2023\Aoc2023Day07
    //  */
    // public function testDay07InvalidInput1(): void
    // {
    //     $solver = new Aoc2023Day07();
    //     $input = ['a'];
    //     $this->expectException(\Exception::class);
    //     [$ans1, $ans2] = $solver->solve($input);
    // }

    // // --------------------------------------------------------------------

    // /**
    //  * @covers \TBali\Aoc2023\Aoc2023Day08
    //  */
    // public function testDay08Example1(): void
    // {
    //     $solver = new Aoc2023Day08();
    //     $input = $solver->readInput($solver->inputBaseFileName() . 'ex1.txt');
    //     [$ans1, $ans2] = $solver->solve($input);
    //     [$expected1, $expected2] = $solver::EXAMPLE_SOLUTIONS[0];
    //     self::assertSame(strval($expected1), $ans1);
    //     self::assertSame(strval($expected2), $ans2);
    // }

    // /**
    //  * @covers \TBali\Aoc2023\Aoc2023Day08
    //  */
    // public function testDay08(): void
    // {
    //     $solver = new Aoc2023Day08();
    //     $input = $solver->readInput($solver->inputBaseFileName() . '.txt');
    //     [$ans1, $ans2] = $solver->solve($input);
    //     [$expected1, $expected2] = $solver::SOLUTIONS;
    //     self::assertSame(strval($expected1), $ans1);
    //     self::assertSame(strval($expected2), $ans2);
    // }

    // // --------------------------------------------------------------------

    // /**
    //  * @covers \TBali\Aoc2023\Aoc2023Day09
    //  */
    // public function testDay09Example1(): void
    // {
    //     $solver = new Aoc2023Day09();
    //     $input = $solver->readInput($solver->inputBaseFileName() . 'ex1.txt');
    //     [$ans1, $ans2] = $solver->solve($input);
    //     [$expected1, $expected2] = $solver::EXAMPLE_SOLUTIONS[0];
    //     self::assertSame(strval($expected1), $ans1);
    //     self::assertSame(strval($expected2), $ans2);
    // }

    // /**
    //  * @covers \TBali\Aoc2023\Aoc2023Day09
    //  */
    // public function testDay09Example2(): void
    // {
    //     $solver = new Aoc2023Day09();
    //     $input = $solver->readInput($solver->inputBaseFileName() . 'ex2.txt');
    //     [$ans1, $ans2] = $solver->solve($input);
    //     [$expected1, $expected2] = $solver::EXAMPLE_SOLUTIONS[1];
    //     self::assertSame(strval($expected1), $ans1);
    //     self::assertSame(strval($expected2), $ans2);
    // }

    // /**
    //  * @covers \TBali\Aoc2023\Aoc2023Day09
    //  */
    // public function testDay09(): void
    // {
    //     $solver = new Aoc2023Day09();
    //     $input = $solver->readInput($solver->inputBaseFileName() . '.txt');
    //     [$ans1, $ans2] = $solver->solve($input);
    //     [$expected1, $expected2] = $solver::SOLUTIONS;
    //     self::assertSame(strval($expected1), $ans1);
    //     self::assertSame(strval($expected2), $ans2);
    // }

    // // --------------------------------------------------------------------

    // /**
    //  * @covers \TBali\Aoc2023\Aoc2023Day10
    //  */
    // public function testDay10Example1(): void
    // {
    //     $solver = new Aoc2023Day10();
    //     $input = $solver->readInput($solver->inputBaseFileName() . 'ex1.txt');
    //     [$ans1, $ans2] = $solver->solve($input);
    //     [$expected1, $expected2] = $solver::EXAMPLE_SOLUTIONS[0];
    //     self::assertSame(strval($expected1), $ans1);
    //     self::assertSame(strval($expected2), $ans2);
    // }

    // /**
    //  * @covers \TBali\Aoc2023\Aoc2023Day10
    //  */
    // public function testDay10(): void
    // {
    //     $solver = new Aoc2023Day10();
    //     $input = $solver->readInput($solver->inputBaseFileName() . '.txt');
    //     [$ans1, $ans2] = $solver->solve($input);
    //     [$expected1, $expected2] = $solver::SOLUTIONS;
    //     self::assertSame(strval($expected1), $ans1);
    //     self::assertSame(strval($expected2), $ans2);
    // }

    // // --------------------------------------------------------------------

    // /**
    //  * @covers \TBali\Aoc2023\Aoc2023Day11
    //  */
    // public function testDay11Example1(): void
    // {
    //     $solver = new Aoc2023Day11();
    //     $input = $solver->readInput($solver->inputBaseFileName() . 'ex1.txt');
    //     [$ans1, $ans2] = $solver->solve($input);
    //     [$expected1, $expected2] = $solver::EXAMPLE_SOLUTIONS[0];
    //     self::assertSame(strval($expected1), $ans1);
    //     self::assertSame(strval($expected2), $ans2);
    // }

    // /**
    //  * @covers \TBali\Aoc2023\Aoc2023Day11
    //  */
    // public function testDay11(): void
    // {
    //     $solver = new Aoc2023Day11();
    //     $input = $solver->readInput($solver->inputBaseFileName() . '.txt');
    //     [$ans1, $ans2] = $solver->solve($input);
    //     [$expected1, $expected2] = $solver::SOLUTIONS;
    //     self::assertSame(strval($expected1), $ans1);
    //     self::assertSame(strval($expected2), $ans2);
    // }

    // /**
    //  * @covers \TBali\Aoc2023\Aoc2023Day11
    //  */
    // public function testDay11InvalidInput1(): void
    // {
    //     $solver = new Aoc2023Day11();
    //     $input = ['a'];
    //     $this->expectException(\Exception::class);
    //     [$ans1, $ans2] = $solver->solve($input);
    // }

    // // --------------------------------------------------------------------

    // /**
    //  * @covers \TBali\Aoc2023\Aoc2023Day12
    //  */
    // public function testDay12Example1(): void
    // {
    //     $solver = new Aoc2023Day12();
    //     $input = $solver->readInput($solver->inputBaseFileName() . 'ex1.txt');
    //     [$ans1, $ans2] = $solver->solve($input);
    //     [$expected1, $expected2] = $solver::EXAMPLE_SOLUTIONS[0];
    //     self::assertSame(strval($expected1), $ans1);
    //     self::assertSame(strval($expected2), $ans2);
    // }

    // /**
    //  * @covers \TBali\Aoc2023\Aoc2023Day12
    //  */
    // public function testDay12(): void
    // {
    //     $solver = new Aoc2023Day12();
    //     $input = $solver->readInput($solver->inputBaseFileName() . '.txt');
    //     [$ans1, $ans2] = $solver->solve($input);
    //     [$expected1, $expected2] = $solver::SOLUTIONS;
    //     self::assertSame(strval($expected1), $ans1);
    //     self::assertSame(strval($expected2), $ans2);
    // }

    // /**
    //  * @covers \TBali\Aoc2023\Aoc2023Day12
    //  */
    // public function testDay12InvalidInput1(): void
    // {
    //     $solver = new Aoc2023Day12();
    //     $input = ['a'];
    //     $this->expectException(\Exception::class);
    //     [$ans1, $ans2] = $solver->solve($input);
    // }

    // // --------------------------------------------------------------------

    // /**
    //  * @covers \TBali\Aoc2023\Aoc2023Day13
    //  */
    // public function testDay13Example1(): void
    // {
    //     $solver = new Aoc2023Day13();
    //     $input = $solver->readInput($solver->inputBaseFileName() . 'ex1.txt');
    //     [$ans1, $ans2] = $solver->solve($input);
    //     [$expected1, $expected2] = $solver::EXAMPLE_SOLUTIONS[0];
    //     self::assertSame(strval($expected1), $ans1);
    //     self::assertSame(strval($expected2), $ans2);
    // }

    // /**
    //  * @covers \TBali\Aoc2023\Aoc2023Day13
    //  */
    // public function testDay13(): void
    // {
    //     $solver = new Aoc2023Day13();
    //     $input = $solver->readInput($solver->inputBaseFileName() . '.txt');
    //     [$ans1, $ans2] = $solver->solve($input);
    //     [$expected1, $expected2] = $solver::SOLUTIONS;
    //     self::assertSame(strval($expected1), $ans1);
    //     self::assertSame(strval($expected2), $ans2);
    // }

    // /**
    //  * @covers \TBali\Aoc2023\Aoc2023Day13
    //  */
    // public function testDay13InvalidInput1(): void
    // {
    //     $solver = new Aoc2023Day13();
    //     $input = ['a'];
    //     $this->expectException(\Exception::class);
    //     [$ans1, $ans2] = $solver->solve($input);
    // }

    // // --------------------------------------------------------------------

    // /**
    //  * @covers \TBali\Aoc2023\Aoc2023Day14
    //  */
    // public function testDay14Example1(): void
    // {
    //     $solver = new Aoc2023Day14();
    //     $input = $solver->readInput($solver->inputBaseFileName() . 'ex1.txt');
    //     [$ans1, $ans2] = $solver->solve($input);
    //     [$expected1, $expected2] = $solver::EXAMPLE_SOLUTIONS[0];
    //     self::assertSame(strval($expected1), $ans1);
    //     self::assertSame(strval($expected2), $ans2);
    // }

    // /**
    //  * @covers \TBali\Aoc2023\Aoc2023Day14
    //  */
    // public function testDay14(): void
    // {
    //     $solver = new Aoc2023Day14();
    //     $input = $solver->readInput($solver->inputBaseFileName() . '.txt');
    //     [$ans1, $ans2] = $solver->solve($input);
    //     [$expected1, $expected2] = $solver::SOLUTIONS;
    //     self::assertSame(strval($expected1), $ans1);
    //     self::assertSame(strval($expected2), $ans2);
    // }

    // /**
    //  * @covers \TBali\Aoc2023\Aoc2023Day14
    //  */
    // public function testDay14InvalidInput1(): void
    // {
    //     $solver = new Aoc2023Day14();
    //     $input = ['a'];
    //     $this->expectException(\Exception::class);
    //     [$ans1, $ans2] = $solver->solve($input);
    // }

    // // --------------------------------------------------------------------

    // /**
    //  * @covers \TBali\Aoc2023\Aoc2023Day15
    //  */
    // public function testDay15Example1(): void
    // {
    //     $solver = new Aoc2023Day15();
    //     $input = $solver->readInput($solver->inputBaseFileName() . 'ex1.txt');
    //     [$ans1, $ans2] = $solver->solve($input);
    //     [$expected1, $expected2] = $solver::EXAMPLE_SOLUTIONS[0];
    //     self::assertSame(strval($expected1), $ans1);
    //     self::assertSame(strval($expected2), $ans2);
    // }

    // /**
    //  * @covers \TBali\Aoc2023\Aoc2023Day15
    //  */
    // public function testDay15(): void
    // {
    //     $solver = new Aoc2023Day15();
    //     $input = $solver->readInput($solver->inputBaseFileName() . '.txt');
    //     [$ans1, $ans2] = $solver->solve($input);
    //     [$expected1, $expected2] = $solver::SOLUTIONS;
    //     self::assertSame(strval($expected1), $ans1);
    //     self::assertSame(strval($expected2), $ans2);
    // }

    // /**
    //  * @covers \TBali\Aoc2023\Aoc2023Day15
    //  */
    // public function testDay15InvalidInput1(): void
    // {
    //     $solver = new Aoc2023Day15();
    //     $input = ['a'];
    //     $this->expectException(\Exception::class);
    //     [$ans1, $ans2] = $solver->solve($input);
    // }

    // // --------------------------------------------------------------------

    // /**
    //  * @covers \TBali\Aoc2023\Aoc2023Day16
    //  */
    // public function testDay16Example1(): void
    // {
    //     $solver = new Aoc2023Day16();
    //     $input = $solver->readInput($solver->inputBaseFileName() . 'ex1.txt');
    //     [$ans1, $ans2] = $solver->solve($input);
    //     [$expected1, $expected2] = $solver::EXAMPLE_SOLUTIONS[0];
    //     self::assertSame(strval($expected1), $ans1);
    //     self::assertSame(strval($expected2), $ans2);
    // }

    // /**
    //  * @covers \TBali\Aoc2023\Aoc2023Day16
    //  */
    // public function testDay16(): void
    // {
    //     $solver = new Aoc2023Day16();
    //     $input = $solver->readInput($solver->inputBaseFileName() . '.txt');
    //     [$ans1, $ans2] = $solver->solve($input);
    //     [$expected1, $expected2] = $solver::SOLUTIONS;
    //     self::assertSame(strval($expected1), $ans1);
    //     self::assertSame(strval($expected2), $ans2);
    // }

    // /**
    //  * @covers \TBali\Aoc2023\Aoc2023Day16
    //  */
    // public function testDay16InvalidInput1(): void
    // {
    //     $solver = new Aoc2023Day16();
    //     $input = ['a'];
    //     $this->expectException(\Exception::class);
    //     [$ans1, $ans2] = $solver->solve($input);
    // }

    // // --------------------------------------------------------------------

    // /**
    //  * @covers \TBali\Aoc2023\Aoc2023Day17
    //  */
    // public function testDay17Example1(): void
    // {
    //     $solver = new Aoc2023Day17();
    //     $input = [$solver::EXAMPLE_STRING_INPUTS[0]];
    //     [$ans1, $ans2] = $solver->solve($input);
    //     [$expected1, $expected2] = $solver::EXAMPLE_SOLUTIONS[0];
    //     self::assertSame(strval($expected1), $ans1);
    //     self::assertSame(strval($expected2), $ans2);
    // }

    // /**
    //  * @covers \TBali\Aoc2023\Aoc2023Day17
    //  */
    // public function testDay17(): void
    // {
    //     $solver = new Aoc2023Day17();
    //     $input = $solver->readInput($solver->inputBaseFileName() . '.txt');
    //     [$ans1, $ans2] = $solver->solve($input);
    //     [$expected1, $expected2] = $solver::SOLUTIONS;
    //     self::assertSame(strval($expected1), $ans1);
    //     self::assertSame(strval($expected2), $ans2);
    // }

    // /**
    //  * @covers \TBali\Aoc2023\Aoc2023Day17
    //  */
    // public function testDay17InvalidInput1(): void
    // {
    //     $solver = new Aoc2023Day17();
    //     $input = ['a'];
    //     $this->expectException(\Exception::class);
    //     [$ans1, $ans2] = $solver->solve($input);
    // }

    // // --------------------------------------------------------------------

    // /**
    //  * @covers \TBali\Aoc2023\Aoc2023Day18
    //  */
    // public function testDay18Example1(): void
    // {
    //     $solver = new Aoc2023Day18();
    //     $input = $solver->readInput($solver->inputBaseFileName() . 'ex1.txt');
    //     [$ans1, $ans2] = $solver->solve($input);
    //     [$expected1, $expected2] = $solver::EXAMPLE_SOLUTIONS[0];
    //     self::assertSame(strval($expected1), $ans1);
    //     self::assertSame(strval($expected2), $ans2);
    // }

    // /**
    //  * @covers \TBali\Aoc2023\Aoc2023Day18
    //  */
    // public function testDay18Example2(): void
    // {
    //     $solver = new Aoc2023Day18();
    //     $input = $solver->readInput($solver->inputBaseFileName() . 'ex2.txt');
    //     [$ans1, $ans2] = $solver->solve($input);
    //     [$expected1, $expected2] = $solver::EXAMPLE_SOLUTIONS[1];
    //     self::assertSame(strval($expected1), $ans1);
    //     self::assertSame(strval($expected2), $ans2);
    // }

    // /**
    //  * @covers \TBali\Aoc2023\Aoc2023Day18
    //  */
    // public function testDay18(): void
    // {
    //     $solver = new Aoc2023Day18();
    //     $input = $solver->readInput($solver->inputBaseFileName() . '.txt');
    //     [$ans1, $ans2] = $solver->solve($input);
    //     [$expected1, $expected2] = $solver::SOLUTIONS;
    //     self::assertSame(strval($expected1), $ans1);
    //     self::assertSame(strval($expected2), $ans2);
    // }

    // /**
    //  * @covers \TBali\Aoc2023\Aoc2023Day18
    //  */
    // public function testDay18InvalidInput1(): void
    // {
    //     $solver = new Aoc2023Day18();
    //     $input = ['a'];
    //     $this->expectException(\Exception::class);
    //     [$ans1, $ans2] = $solver->solve($input);
    // }

    // // --------------------------------------------------------------------

    // /**
    //  * @covers \TBali\Aoc2023\Aoc2023Day19
    //  */
    // public function testDay19Example1(): void
    // {
    //     $solver = new Aoc2023Day19();
    //     $input = $solver->readInput($solver->inputBaseFileName() . 'ex1.txt');
    //     [$ans1, $ans2] = $solver->solve($input);
    //     [$expected1, $expected2] = $solver::EXAMPLE_SOLUTIONS[0];
    //     self::assertSame(strval($expected1), $ans1);
    //     self::assertSame(strval($expected2), $ans2);
    // }

    // /**
    //  * @covers \TBali\Aoc2023\Aoc2023Day19
    //  */
    // public function testDay19(): void
    // {
    //     $solver = new Aoc2023Day19();
    //     $input = $solver->readInput($solver->inputBaseFileName() . '.txt');
    //     [$ans1, $ans2] = $solver->solve($input);
    //     [$expected1, $expected2] = $solver::SOLUTIONS;
    //     self::assertSame(strval($expected1), $ans1);
    //     self::assertSame(strval($expected2), $ans2);
    // }

    // /**
    //  * @covers \TBali\Aoc2023\Aoc2023Day19
    //  */
    // public function testDay19InvalidInput1(): void
    // {
    //     $solver = new Aoc2023Day19();
    //     $input = ['a'];
    //     $this->expectException(\Exception::class);
    //     [$ans1, $ans2] = $solver->solve($input);
    // }

    // // --------------------------------------------------------------------

    // /**
    //  * @covers \TBali\Aoc2023\Aoc2023Day20
    //  */
    // public function testDay20Example1(): void
    // {
    //     $solver = new Aoc2023Day20();
    //     $input = $solver->readInput($solver->inputBaseFileName() . 'ex1.txt');
    //     [$ans1, $ans2] = $solver->solve($input);
    //     [$expected1, $expected2] = $solver::EXAMPLE_SOLUTIONS[0];
    //     self::assertSame(strval($expected1), $ans1);
    //     self::assertSame(strval($expected2), $ans2);
    // }

    // /**
    //  * @covers \TBali\Aoc2023\Aoc2023Day20
    //  */
    // public function testDay20(): void
    // {
    //     $solver = new Aoc2023Day20();
    //     $input = $solver->readInput($solver->inputBaseFileName() . '.txt');
    //     [$ans1, $ans2] = $solver->solve($input);
    //     [$expected1, $expected2] = $solver::SOLUTIONS;
    //     self::assertSame(strval($expected1), $ans1);
    //     self::assertSame(strval($expected2), $ans2);
    // }

    // /**
    //  * @covers \TBali\Aoc2023\Aoc2023Day20
    //  */
    // public function testDay20InvalidInput1(): void
    // {
    //     $solver = new Aoc2023Day20();
    //     $input = ['a'];
    //     $this->expectException(\Exception::class);
    //     [$ans1, $ans2] = $solver->solve($input);
    // }

    // // --------------------------------------------------------------------

    // /**
    //  * @covers \TBali\Aoc2023\Aoc2023Day21
    //  */
    // public function testDay21Example1(): void
    // {
    //     $solver = new Aoc2023Day21();
    //     $input = $solver->readInput($solver->inputBaseFileName() . 'ex1.txt');
    //     [$ans1, $ans2] = $solver->solve($input);
    //     [$expected1, $expected2] = $solver::EXAMPLE_SOLUTIONS[0];
    //     self::assertSame(strval($expected1), $ans1);
    //     self::assertSame(strval($expected2), $ans2);
    // }

    // /**
    //  * @covers \TBali\Aoc2023\Aoc2023Day21
    //  */
    // public function testDay21(): void
    // {
    //     $solver = new Aoc2023Day21();
    //     $input = $solver->readInput($solver->inputBaseFileName() . '.txt');
    //     [$ans1, $ans2] = $solver->solve($input);
    //     [$expected1, $expected2] = $solver::SOLUTIONS;
    //     self::assertSame(strval($expected1), $ans1);
    //     self::assertSame(strval($expected2), $ans2);
    // }

    // /**
    //  * @covers \TBali\Aoc2023\Aoc2023Day21
    //  */
    // public function testDay21InvalidInput1(): void
    // {
    //     $solver = new Aoc2023Day21();
    //     $input = ['a'];
    //     $this->expectException(\Exception::class);
    //     [$ans1, $ans2] = $solver->solve($input);
    // }

    // // --------------------------------------------------------------------

    // /**
    //  * @covers \TBali\Aoc2023\Aoc2023Day22
    //  */
    // public function testDay22Example1(): void
    // {
    //     $solver = new Aoc2023Day22();
    //     $input = $solver->readInput($solver->inputBaseFileName() . 'ex1.txt');
    //     [$ans1, $ans2] = $solver->solve($input);
    //     [$expected1, $expected2] = $solver::EXAMPLE_SOLUTIONS[0];
    //     self::assertSame(strval($expected1), $ans1);
    //     self::assertSame(strval($expected2), $ans2);
    // }

    // /**
    //  * @covers \TBali\Aoc2023\Aoc2023Day22
    //  */
    // public function testDay22(): void
    // {
    //     $solver = new Aoc2023Day22();
    //     $input = $solver->readInput($solver->inputBaseFileName() . '.txt');
    //     [$ans1, $ans2] = $solver->solve($input);
    //     [$expected1, $expected2] = $solver::SOLUTIONS;
    //     self::assertSame(strval($expected1), $ans1);
    //     self::assertSame(strval($expected2), $ans2);
    // }

    // /**
    //  * @covers \TBali\Aoc2023\Aoc2023Day22
    //  */
    // public function testDay22InvalidInput1(): void
    // {
    //     $solver = new Aoc2023Day22();
    //     $input = ['a'];
    //     $this->expectException(\Exception::class);
    //     [$ans1, $ans2] = $solver->solve($input);
    // }

    // // --------------------------------------------------------------------

    // /**
    //  * @covers \TBali\Aoc2023\Aoc2023Day23
    //  */
    // public function testDay23Example1(): void
    // {
    //     $solver = new Aoc2023Day23();
    //     $input = $solver->readInput($solver->inputBaseFileName() . 'ex1.txt');
    //     [$ans1, $ans2] = $solver->solve($input);
    //     [$expected1, $expected2] = $solver::EXAMPLE_SOLUTIONS[0];
    //     self::assertSame(strval($expected1), $ans1);
    //     self::assertSame(strval($expected2), $ans2);
    // }

    // /**
    //  * @covers \TBali\Aoc2023\Aoc2023Day23
    //  */
    // public function testDay23(): void
    // {
    //     $solver = new Aoc2023Day23();
    //     $input = $solver->readInput($solver->inputBaseFileName() . '.txt');
    //     [$ans1, $ans2] = $solver->solve($input);
    //     [$expected1, $expected2] = $solver::SOLUTIONS;
    //     self::assertSame(strval($expected1), $ans1);
    //     self::assertSame(strval($expected2), $ans2);
    // }

    // /**
    //  * @covers \TBali\Aoc2023\Aoc2023Day23
    //  */
    // public function testDay23InvalidInput1(): void
    // {
    //     $solver = new Aoc2023Day23();
    //     $input = ['a'];
    //     $this->expectException(\Exception::class);
    //     [$ans1, $ans2] = $solver->solve($input);
    // }

    // // --------------------------------------------------------------------

    // /**
    //  * @covers \TBali\Aoc2023\Aoc2023Day24
    //  */
    // public function testDay24Example1(): void
    // {
    //     $solver = new Aoc2023Day24();
    //     $input = $solver->readInput($solver->inputBaseFileName() . 'ex1.txt');
    //     [$ans1, $ans2] = $solver->solve($input);
    //     [$expected1, $expected2] = $solver::EXAMPLE_SOLUTIONS[0];
    //     self::assertSame(strval($expected1), $ans1);
    //     self::assertSame(strval($expected2), $ans2);
    // }

    // /**
    //  * @covers \TBali\Aoc2023\Aoc2023Day24
    //  */
    // public function testDay24Example2(): void
    // {
    //     $solver = new Aoc2023Day24();
    //     $input = $solver->readInput($solver->inputBaseFileName() . 'ex2.txt');
    //     [$ans1, $ans2] = $solver->solve($input);
    //     [$expected1, $expected2] = $solver::EXAMPLE_SOLUTIONS[1];
    //     self::assertSame(strval($expected1), $ans1);
    //     self::assertSame(strval($expected2), $ans2);
    // }

    // /**
    //  * @covers \TBali\Aoc2023\Aoc2023Day24
    //  */
    // public function testDay24(): void
    // {
    //     self::markTestSkipped(); // very slow with xdebug coverage
    //     $solver = new Aoc2023Day24();
    //     $input = $solver->readInput($solver->inputBaseFileName() . '.txt');
    //     [$ans1, $ans2] = $solver->solve($input);
    //     [$expected1, $expected2] = $solver::SOLUTIONS;
    //     self::assertSame(strval($expected1), $ans1);
    //     self::assertSame(strval($expected2), $ans2);
    // }

    // /**
    //  * @covers \TBali\Aoc2023\Aoc2023Day24
    //  */
    // public function testDay24InvalidInput1(): void
    // {
    //     $solver = new Aoc2023Day24();
    //     $input = ['a'];
    //     $this->expectException(\Exception::class);
    //     [$ans1, $ans2] = $solver->solve($input);
    // }

    // // --------------------------------------------------------------------

    // /**
    //  * @covers \TBali\Aoc2023\Aoc2023Day25
    //  */
    // public function testDay25Example1(): void
    // {
    //     $solver = new Aoc2023Day25();
    //     $input = $solver->readInput($solver->inputBaseFileName() . 'ex1.txt');
    //     [$ans1, $ans2] = $solver->solve($input);
    //     [$expected1, $expected2] = $solver::EXAMPLE_SOLUTIONS[0];
    //     self::assertSame(strval($expected1), $ans1);
    //     self::assertSame(strval($expected2), $ans2);
    // }

    // /**
    //  * @covers \TBali\Aoc2023\Aoc2023Day25
    //  */
    // public function testDay25(): void
    // {
    //     $solver = new Aoc2023Day25();
    //     $input = $solver->readInput($solver->inputBaseFileName() . '.txt');
    //     [$ans1, $ans2] = $solver->solve($input);
    //     [$expected1, $expected2] = $solver::SOLUTIONS;
    //     self::assertSame(strval($expected1), $ans1);
    //     self::assertSame(strval($expected2), $ans2);
    // }

    // /**
    //  * @covers \TBali\Aoc2023\Aoc2023Day25
    //  */
    // public function testDay25InvalidInput1(): void
    // {
    //     $solver = new Aoc2023Day25();
    //     $input = ['a'];
    //     $this->expectException(\Exception::class);
    //     [$ans1, $ans2] = $solver->solve($input);
    // }

    // --------------------------------------------------------------------
}
