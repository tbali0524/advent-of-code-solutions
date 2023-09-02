<?php

declare(strict_types=1);

namespace TBali\Tests;

use PHPUnit\Framework\Attributes\RequiresPhp;
use PHPUnit\Framework\Attributes\RequiresPhpunit;
use PHPUnit\Framework\TestCase;
use TBali\Aoc2021\Aoc2021Day01;
use TBali\Aoc2021\Aoc2021Day02;
use TBali\Aoc2021\Aoc2021Day03;
use TBali\Aoc2021\Aoc2021Day04;
use TBali\Aoc2021\Aoc2021Day05;
use TBali\Aoc2021\Aoc2021Day06;
use TBali\Aoc2021\Aoc2021Day07;
use TBali\Aoc2021\Aoc2021Day08;
use TBali\Aoc2021\Aoc2021Day09;
use TBali\Aoc2021\Aoc2021Day10;
use TBali\Aoc2021\Aoc2021Day11;
use TBali\Aoc2021\Aoc2021Day12;
use TBali\Aoc2021\Aoc2021Day13;
use TBali\Aoc2021\Aoc2021Day14;
use TBali\Aoc2021\Aoc2021Day15;
use TBali\Aoc2021\Aoc2021Day16;
use TBali\Aoc2021\Aoc2021Day17;
use TBali\Aoc2021\Aoc2021Day18;
use TBali\Aoc2021\Aoc2021Day19;
use TBali\Aoc2021\Aoc2021Day20;
use TBali\Aoc2021\Aoc2021Day21;
use TBali\Aoc2021\Aoc2021Day22;
use TBali\Aoc2021\Aoc2021Day23;
use TBali\Aoc2021\Aoc2021Day24;
use TBali\Aoc2021\Aoc2021Day25;

/**
 * Unit tests for Advent of Code season 2021.
 *
 * Instead of using this file with phpunit, it is a better way to run the solutions by using AoCRunner.
 *
 * @internal
 *
 * @coversNothing
 */
#[RequiresPhp('^8.2')]
#[RequiresPhpunit('^10.1')]
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
        self::assertSame(strval($expected1), $ans1);
        self::assertSame(strval($expected2), $ans2);
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
        self::assertSame(strval($expected1), $ans1);
        self::assertSame(strval($expected2), $ans2);
    }

    // --------------------------------------------------------------------

    /**
     * @covers \TBali\Aoc2021\Aoc2021Day02
     */
    public function testDay02Example1(): void
    {
        $solver = new Aoc2021Day02();
        $input = $solver->readInput($solver->inputBaseFileName() . 'ex1.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::EXAMPLE_SOLUTIONS[0];
        self::assertSame(strval($expected1), $ans1);
        self::assertSame(strval($expected2), $ans2);
    }

    /**
     * @covers \TBali\Aoc2021\Aoc2021Day02
     */
    public function testDay02(): void
    {
        $solver = new Aoc2021Day02();
        $input = $solver->readInput($solver->inputBaseFileName() . '.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::SOLUTIONS;
        self::assertSame(strval($expected1), $ans1);
        self::assertSame(strval($expected2), $ans2);
    }

    /**
     * @covers \TBali\Aoc2021\Aoc2021Day02
     */
    public function testDay02InvalidInput1(): void
    {
        $solver = new Aoc2021Day02();
        $input = ['forward'];
        $this->expectException(\Exception::class);
        [$ans1, $ans2] = $solver->solve($input);
    }

    // --------------------------------------------------------------------

    /**
     * @covers \TBali\Aoc2021\Aoc2021Day03
     */
    public function testDay03Example1(): void
    {
        $solver = new Aoc2021Day03();
        $input = $solver->readInput($solver->inputBaseFileName() . 'ex1.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::EXAMPLE_SOLUTIONS[0];
        self::assertSame(strval($expected1), $ans1);
        self::assertSame(strval($expected2), $ans2);
    }

    /**
     * @covers \TBali\Aoc2021\Aoc2021Day03
     */
    public function testDay03(): void
    {
        $solver = new Aoc2021Day03();
        $input = $solver->readInput($solver->inputBaseFileName() . '.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::SOLUTIONS;
        self::assertSame(strval($expected1), $ans1);
        self::assertSame(strval($expected2), $ans2);
    }

    // --------------------------------------------------------------------

    /**
     * @covers \TBali\Aoc2021\Aoc2021Day04
     * @covers \TBali\Aoc2021\Bingo
     */
    public function testDay04Example1(): void
    {
        $solver = new Aoc2021Day04();
        $input = $solver->readInput($solver->inputBaseFileName() . 'ex1.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::EXAMPLE_SOLUTIONS[0];
        self::assertSame(strval($expected1), $ans1);
        self::assertSame(strval($expected2), $ans2);
    }

    /**
     * @covers \TBali\Aoc2021\Aoc2021Day04
     * @covers \TBali\Aoc2021\Bingo
     */
    public function testDay04(): void
    {
        $solver = new Aoc2021Day04();
        $input = $solver->readInput($solver->inputBaseFileName() . '.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::SOLUTIONS;
        self::assertSame(strval($expected1), $ans1);
        self::assertSame(strval($expected2), $ans2);
    }

    /**
     * @covers \TBali\Aoc2021\Aoc2021Day04
     * @covers \TBali\Aoc2021\Bingo
     */
    public function testDay04InvalidInput1(): void
    {
        $solver = new Aoc2021Day04();
        $input = ['1', '', '1'];
        $this->expectException(\Exception::class);
        [$ans1, $ans2] = $solver->solve($input);
    }

    // --------------------------------------------------------------------

    /**
     * @covers \TBali\Aoc2021\Aoc2021Day05
     */
    public function testDay05Example1(): void
    {
        $solver = new Aoc2021Day05();
        $input = $solver->readInput($solver->inputBaseFileName() . 'ex1.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::EXAMPLE_SOLUTIONS[0];
        self::assertSame(strval($expected1), $ans1);
        self::assertSame(strval($expected2), $ans2);
    }

    /**
     * @covers \TBali\Aoc2021\Aoc2021Day05
     */
    public function testDay05(): void
    {
        $solver = new Aoc2021Day05();
        $input = $solver->readInput($solver->inputBaseFileName() . '.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::SOLUTIONS;
        self::assertSame(strval($expected1), $ans1);
        self::assertSame(strval($expected2), $ans2);
    }

    /**
     * @covers \TBali\Aoc2021\Aoc2021Day05
     */
    public function testDay05InvalidInput1(): void
    {
        $solver = new Aoc2021Day05();
        $input = ['0,0 -> '];
        $this->expectException(\Exception::class);
        [$ans1, $ans2] = $solver->solve($input);
    }

    // --------------------------------------------------------------------

    /**
     * @covers \TBali\Aoc2021\Aoc2021Day06
     */
    public function testDay06Example1(): void
    {
        $solver = new Aoc2021Day06();
        $input = $solver->readInput($solver->inputBaseFileName() . 'ex1.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::EXAMPLE_SOLUTIONS[0];
        self::assertSame(strval($expected1), $ans1);
        self::assertSame(strval($expected2), $ans2);
    }

    /**
     * @covers \TBali\Aoc2021\Aoc2021Day06
     */
    public function testDay06(): void
    {
        $solver = new Aoc2021Day06();
        $input = $solver->readInput($solver->inputBaseFileName() . '.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::SOLUTIONS;
        self::assertSame(strval($expected1), $ans1);
        self::assertSame(strval($expected2), $ans2);
    }

    // --------------------------------------------------------------------

    /**
     * @covers \TBali\Aoc2021\Aoc2021Day07
     */
    public function testDay07Example1(): void
    {
        $solver = new Aoc2021Day07();
        $input = $solver->readInput($solver->inputBaseFileName() . 'ex1.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::EXAMPLE_SOLUTIONS[0];
        self::assertSame(strval($expected1), $ans1);
        self::assertSame(strval($expected2), $ans2);
    }

    /**
     * @covers \TBali\Aoc2021\Aoc2021Day07
     *
     * @group large
     */
    public function testDay07(): void
    {
        $solver = new Aoc2021Day07();
        $input = $solver->readInput($solver->inputBaseFileName() . '.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::SOLUTIONS;
        self::assertSame(strval($expected1), $ans1);
        self::assertSame(strval($expected2), $ans2);
    }

    // --------------------------------------------------------------------

    /**
     * @covers \TBali\Aoc2021\Aoc2021Day08
     */
    public function testDay08Example1(): void
    {
        $solver = new Aoc2021Day08();
        $input = $solver->readInput($solver->inputBaseFileName() . 'ex1.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::EXAMPLE_SOLUTIONS[0];
        // $this->assertEquals(strval($expected1), $ans1);
        self::assertSame(strval($expected2), $ans2);
    }

    /**
     * @covers \TBali\Aoc2021\Aoc2021Day08
     */
    public function testDay08Example2(): void
    {
        $solver = new Aoc2021Day08();
        $input = $solver->readInput($solver->inputBaseFileName() . 'ex2.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::EXAMPLE_SOLUTIONS[1];
        self::assertSame(strval($expected1), $ans1);
        self::assertSame(strval($expected2), $ans2);
    }

    /**
     * @covers \TBali\Aoc2021\Aoc2021Day08
     */
    public function testDay08(): void
    {
        $solver = new Aoc2021Day08();
        $input = $solver->readInput($solver->inputBaseFileName() . '.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::SOLUTIONS;
        self::assertSame(strval($expected1), $ans1);
        self::assertSame(strval($expected2), $ans2);
    }

    /**
     * @covers \TBali\Aoc2021\Aoc2021Day08
     */
    public function testDay08InvalidInput1(): void
    {
        $solver = new Aoc2021Day08();
        $input = ['a'];
        $this->expectException(\Exception::class);
        [$ans1, $ans2] = $solver->solve($input);
    }

    // --------------------------------------------------------------------

    /**
     * @covers \TBali\Aoc2021\Aoc2021Day09
     */
    public function testDay09Example1(): void
    {
        $solver = new Aoc2021Day09();
        $input = $solver->readInput($solver->inputBaseFileName() . 'ex1.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::EXAMPLE_SOLUTIONS[0];
        self::assertSame(strval($expected1), $ans1);
        self::assertSame(strval($expected2), $ans2);
    }

    /**
     * @covers \TBali\Aoc2021\Aoc2021Day09
     */
    public function testDay09(): void
    {
        $solver = new Aoc2021Day09();
        $input = $solver->readInput($solver->inputBaseFileName() . '.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::SOLUTIONS;
        self::assertSame(strval($expected1), $ans1);
        self::assertSame(strval($expected2), $ans2);
    }

    // --------------------------------------------------------------------

    /**
     * @covers \TBali\Aoc2021\Aoc2021Day10
     */
    public function testDay10Example1(): void
    {
        $solver = new Aoc2021Day10();
        $input = $solver->readInput($solver->inputBaseFileName() . 'ex1.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::EXAMPLE_SOLUTIONS[0];
        self::assertSame(strval($expected1), $ans1);
        self::assertSame(strval($expected2), $ans2);
    }

    /**
     * @covers \TBali\Aoc2021\Aoc2021Day10
     */
    public function testDay10(): void
    {
        $solver = new Aoc2021Day10();
        $input = $solver->readInput($solver->inputBaseFileName() . '.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::SOLUTIONS;
        self::assertSame(strval($expected1), $ans1);
        self::assertSame(strval($expected2), $ans2);
    }

    /**
     * @covers \TBali\Aoc2021\Aoc2021Day10
     */
    public function testDay10InvalidInput1(): void
    {
        $solver = new Aoc2021Day10();
        $input = ['a'];
        $this->expectException(\Exception::class);
        [$ans1, $ans2] = $solver->solve($input);
    }

    // --------------------------------------------------------------------

    /**
     * @covers \TBali\Aoc2021\Aoc2021Day11
     */
    public function testDay11Example1(): void
    {
        $solver = new Aoc2021Day11();
        $input = $solver->readInput($solver->inputBaseFileName() . 'ex1.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::EXAMPLE_SOLUTIONS[0];
        self::assertSame(strval($expected1), $ans1);
        self::assertSame(strval($expected2), $ans2);
    }

    /**
     * @covers \TBali\Aoc2021\Aoc2021Day11
     */
    public function testDay11(): void
    {
        $solver = new Aoc2021Day11();
        $input = $solver->readInput($solver->inputBaseFileName() . '.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::SOLUTIONS;
        self::assertSame(strval($expected1), $ans1);
        self::assertSame(strval($expected2), $ans2);
    }

    /**
     * @covers \TBali\Aoc2021\Aoc2021Day11
     */
    public function testDay11InvalidInput1(): void
    {
        $solver = new Aoc2021Day11();
        $input = ['0'];
        $this->expectException(\Exception::class);
        [$ans1, $ans2] = $solver->solve($input);
    }

    // --------------------------------------------------------------------

    /**
     * @covers \TBali\Aoc2021\Aoc2021Day12
     */
    public function testDay12Example1(): void
    {
        $solver = new Aoc2021Day12();
        $input = $solver->readInput($solver->inputBaseFileName() . 'ex1.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::EXAMPLE_SOLUTIONS[0];
        self::assertSame(strval($expected1), $ans1);
        self::assertSame(strval($expected2), $ans2);
    }

    /**
     * @covers \TBali\Aoc2021\Aoc2021Day12
     */
    public function testDay12Example2(): void
    {
        $solver = new Aoc2021Day12();
        $input = $solver->readInput($solver->inputBaseFileName() . 'ex2.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::EXAMPLE_SOLUTIONS[1];
        self::assertSame(strval($expected1), $ans1);
        self::assertSame(strval($expected2), $ans2);
    }

    /**
     * @covers \TBali\Aoc2021\Aoc2021Day12
     */
    public function testDay12Example3(): void
    {
        $solver = new Aoc2021Day12();
        $input = $solver->readInput($solver->inputBaseFileName() . 'ex3.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::EXAMPLE_SOLUTIONS[2];
        self::assertSame(strval($expected1), $ans1);
        self::assertSame(strval($expected2), $ans2);
    }

    /**
     * @covers \TBali\Aoc2021\Aoc2021Day12
     *
     * @group medium
     */
    public function testDay12(): void
    {
        $solver = new Aoc2021Day12();
        $input = $solver->readInput($solver->inputBaseFileName() . '.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::SOLUTIONS;
        self::assertSame(strval($expected1), $ans1);
        self::assertSame(strval($expected2), $ans2);
    }

    /**
     * @covers \TBali\Aoc2021\Aoc2021Day12
     */
    public function testDay12InvalidInput1(): void
    {
        $solver = new Aoc2021Day12();
        $input = ['a'];
        $this->expectException(\Exception::class);
        [$ans1, $ans2] = $solver->solve($input);
    }

    // --------------------------------------------------------------------

    /**
     * @covers \TBali\Aoc2021\Aoc2021Day13
     */
    public function testDay13Example1(): void
    {
        $solver = new Aoc2021Day13();
        $input = $solver->readInput($solver->inputBaseFileName() . 'ex1.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::EXAMPLE_SOLUTIONS[0];
        self::assertSame(strval($expected1), $ans1);
        // $this->assertEquals(strval($expected2), $ans2);
    }

    /**
     * @covers \TBali\Aoc2021\Aoc2021Day13
     */
    public function testDay13(): void
    {
        $solver = new Aoc2021Day13();
        $input = $solver->readInput($solver->inputBaseFileName() . '.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::SOLUTIONS;
        self::assertSame(strval($expected1), $ans1);
        self::assertSame(strval($expected2), $ans2);
    }

    /**
     * @covers \TBali\Aoc2021\Aoc2021Day13
     */
    public function testDay13InvalidInput1(): void
    {
        $solver = new Aoc2021Day13();
        $input = ['0'];
        $this->expectException(\Exception::class);
        [$ans1, $ans2] = $solver->solve($input);
    }

    /**
     * @covers \TBali\Aoc2021\Aoc2021Day13
     */
    public function testDay13InvalidInput2(): void
    {
        $solver = new Aoc2021Day13();
        $input = ['0,0', '', 'a'];
        $this->expectException(\Exception::class);
        [$ans1, $ans2] = $solver->solve($input);
    }

    // --------------------------------------------------------------------

    /**
     * @covers \TBali\Aoc2021\Aoc2021Day14
     */
    public function testDay14Example1(): void
    {
        $solver = new Aoc2021Day14();
        $input = $solver->readInput($solver->inputBaseFileName() . 'ex1.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::EXAMPLE_SOLUTIONS[0];
        self::assertSame(strval($expected1), $ans1);
        self::assertSame(strval($expected2), $ans2);
    }

    /**
     * @covers \TBali\Aoc2021\Aoc2021Day14
     */
    public function testDay14(): void
    {
        $solver = new Aoc2021Day14();
        $input = $solver->readInput($solver->inputBaseFileName() . '.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::SOLUTIONS;
        self::assertSame(strval($expected1), $ans1);
        self::assertSame(strval($expected2), $ans2);
    }

    /**
     * @covers \TBali\Aoc2021\Aoc2021Day14
     */
    public function testDay14InvalidInput1(): void
    {
        $solver = new Aoc2021Day14();
        $input = ['A'];
        $this->expectException(\Exception::class);
        [$ans1, $ans2] = $solver->solve($input);
    }

    /**
     * @covers \TBali\Aoc2021\Aoc2021Day14
     */
    public function testDay14InvalidInput2(): void
    {
        $solver = new Aoc2021Day14();
        $input = ['AB', '', 'AB -> '];
        $this->expectException(\Exception::class);
        [$ans1, $ans2] = $solver->solve($input);
    }

    // --------------------------------------------------------------------

    /**
     * @covers \TBali\Aoc2021\Aoc2021Day15
     */
    public function testDay15Example1(): void
    {
        $solver = new Aoc2021Day15();
        $input = $solver->readInput($solver->inputBaseFileName() . 'ex1.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::EXAMPLE_SOLUTIONS[0];
        self::assertSame(strval($expected1), $ans1);
        self::assertSame(strval($expected2), $ans2);
    }

    /**
     * @covers \TBali\Aoc2021\Aoc2021Day15
     *
     * @group medium
     */
    public function testDay15(): void
    {
        $solver = new Aoc2021Day15();
        $input = $solver->readInput($solver->inputBaseFileName() . '.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::SOLUTIONS;
        self::assertSame(strval($expected1), $ans1);
        self::assertSame(strval($expected2), $ans2);
    }

    // --------------------------------------------------------------------

    /**
     * @covers \TBali\Aoc2021\Aoc2021Day16
     * @covers \TBali\Aoc2021\Packet
     */
    public function testDay16Example1(): void
    {
        $solver = new Aoc2021Day16();
        $input = $solver->readInput($solver->inputBaseFileName() . 'ex1.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::EXAMPLE_SOLUTIONS[0];
        self::assertSame(strval($expected1), $ans1);
        // $this->assertEquals(strval($expected2), $ans2);
    }

    /**
     * @covers \TBali\Aoc2021\Aoc2021Day16
     * @covers \TBali\Aoc2021\Packet
     */
    public function testDay16Example2(): void
    {
        $solver = new Aoc2021Day16();
        $input = $solver->readInput($solver->inputBaseFileName() . 'ex2.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::EXAMPLE_SOLUTIONS[1];
        self::assertSame(strval($expected1), $ans1);
        // $this->assertEquals(strval($expected2), $ans2);
    }

    /**
     * @covers \TBali\Aoc2021\Aoc2021Day16
     * @covers \TBali\Aoc2021\Packet
     */
    public function testDay16Example3(): void
    {
        $solver = new Aoc2021Day16();
        $input = $solver->readInput($solver->inputBaseFileName() . 'ex3.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::EXAMPLE_SOLUTIONS[2];
        self::assertSame(strval($expected1), $ans1);
        // $this->assertEquals(strval($expected2), $ans2);
    }

    /**
     * @covers \TBali\Aoc2021\Aoc2021Day16
     * @covers \TBali\Aoc2021\Packet
     */
    public function testDay16Example4(): void
    {
        $solver = new Aoc2021Day16();
        $input = $solver->readInput($solver->inputBaseFileName() . 'ex4.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::EXAMPLE_SOLUTIONS[3];
        self::assertSame(strval($expected1), $ans1);
        // $this->assertEquals(strval($expected2), $ans2);
    }

    /**
     * @covers \TBali\Aoc2021\Aoc2021Day16
     * @covers \TBali\Aoc2021\Packet
     */
    public function testDay16Example5(): void
    {
        $solver = new Aoc2021Day16();
        $input = $solver->readInput($solver->inputBaseFileName() . 'ex5.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::EXAMPLE_SOLUTIONS[4];
        self::assertSame(strval($expected1), $ans1);
        // $this->assertEquals(strval($expected2), $ans2);
    }

    /**
     * @covers \TBali\Aoc2021\Aoc2021Day16
     * @covers \TBali\Aoc2021\Packet
     */
    public function testDay16Example6(): void
    {
        $solver = new Aoc2021Day16();
        $input = $solver->readInput($solver->inputBaseFileName() . 'ex6.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::EXAMPLE_SOLUTIONS[5];
        self::assertSame(strval($expected1), $ans1);
        // $this->assertEquals(strval($expected2), $ans2);
    }

    /**
     * @covers \TBali\Aoc2021\Aoc2021Day16
     * @covers \TBali\Aoc2021\Packet
     */
    public function testDay16Example7(): void
    {
        $solver = new Aoc2021Day16();
        $input = $solver->readInput($solver->inputBaseFileName() . 'ex7.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::EXAMPLE_SOLUTIONS[6];
        self::assertSame(strval($expected1), $ans1);
        // $this->assertEquals(strval($expected2), $ans2);
    }

    /**
     * @covers \TBali\Aoc2021\Aoc2021Day16
     * @covers \TBali\Aoc2021\Packet
     */
    public function testDay16Example8(): void
    {
        $solver = new Aoc2021Day16();
        $input = $solver->readInput($solver->inputBaseFileName() . 'ex8.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::EXAMPLE_SOLUTIONS[7];
        // $this->assertEquals(strval($expected1), $ans1);
        self::assertSame(strval($expected2), $ans2);
    }

    /**
     * @covers \TBali\Aoc2021\Aoc2021Day16
     * @covers \TBali\Aoc2021\Packet
     */
    public function testDay16Example9(): void
    {
        $solver = new Aoc2021Day16();
        $input = $solver->readInput($solver->inputBaseFileName() . 'ex9.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::EXAMPLE_SOLUTIONS[8];
        // $this->assertEquals(strval($expected1), $ans1);
        self::assertSame(strval($expected2), $ans2);
    }

    /**
     * @covers \TBali\Aoc2021\Aoc2021Day16
     * @covers \TBali\Aoc2021\Packet
     */
    public function testDay16Example10(): void
    {
        $solver = new Aoc2021Day16();
        $input = $solver->readInput($solver->inputBaseFileName() . 'ex10.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::EXAMPLE_SOLUTIONS[9];
        // $this->assertEquals(strval($expected1), $ans1);
        self::assertSame(strval($expected2), $ans2);
    }

    /**
     * @covers \TBali\Aoc2021\Aoc2021Day16
     * @covers \TBali\Aoc2021\Packet
     */
    public function testDay16Example11(): void
    {
        $solver = new Aoc2021Day16();
        $input = $solver->readInput($solver->inputBaseFileName() . 'ex11.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::EXAMPLE_SOLUTIONS[10];
        // $this->assertEquals(strval($expected1), $ans1);
        self::assertSame(strval($expected2), $ans2);
    }

    /**
     * @covers \TBali\Aoc2021\Aoc2021Day16
     * @covers \TBali\Aoc2021\Packet
     */
    public function testDay16Example12(): void
    {
        $solver = new Aoc2021Day16();
        $input = $solver->readInput($solver->inputBaseFileName() . 'ex12.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::EXAMPLE_SOLUTIONS[11];
        // $this->assertEquals(strval($expected1), $ans1);
        self::assertSame(strval($expected2), $ans2);
    }

    /**
     * @covers \TBali\Aoc2021\Aoc2021Day16
     * @covers \TBali\Aoc2021\Packet
     */
    public function testDay16Example13(): void
    {
        $solver = new Aoc2021Day16();
        $input = $solver->readInput($solver->inputBaseFileName() . 'ex13.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::EXAMPLE_SOLUTIONS[12];
        // $this->assertEquals(strval($expected1), $ans1);
        self::assertSame(strval($expected2), $ans2);
    }

    /**
     * @covers \TBali\Aoc2021\Aoc2021Day16
     * @covers \TBali\Aoc2021\Packet
     */
    public function testDay16(): void
    {
        $solver = new Aoc2021Day16();
        $input = $solver->readInput($solver->inputBaseFileName() . '.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::SOLUTIONS;
        self::assertSame(strval($expected1), $ans1);
        self::assertSame(strval($expected2), $ans2);
    }

    /**
     * @covers \TBali\Aoc2021\Aoc2021Day16
     * @covers \TBali\Aoc2021\Packet
     */
    public function testDay16InvalidInput1(): void
    {
        $solver = new Aoc2021Day16();
        $input = ['G'];
        $this->expectException(\Exception::class);
        [$ans1, $ans2] = $solver->solve($input);
    }

    // --------------------------------------------------------------------

    /**
     * @covers \TBali\Aoc2021\Aoc2021Day17
     */
    public function testDay17Example1(): void
    {
        $solver = new Aoc2021Day17();
        $input = $solver->readInput($solver->inputBaseFileName() . 'ex1.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::EXAMPLE_SOLUTIONS[0];
        self::assertSame(strval($expected1), $ans1);
        self::assertSame(strval($expected2), $ans2);
    }

    /**
     * @covers \TBali\Aoc2021\Aoc2021Day17
     */
    public function testDay17(): void
    {
        $solver = new Aoc2021Day17();
        $input = $solver->readInput($solver->inputBaseFileName() . '.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::SOLUTIONS;
        self::assertSame(strval($expected1), $ans1);
        self::assertSame(strval($expected2), $ans2);
    }

    /**
     * @covers \TBali\Aoc2021\Aoc2021Day17
     */
    public function testDay17InvalidInput1(): void
    {
        $solver = new Aoc2021Day17();
        $input = ['target area: x=0..1, y=-1'];
        $this->expectException(\Exception::class);
        [$ans1, $ans2] = $solver->solve($input);
    }

    // --------------------------------------------------------------------

    /**
     * @covers \TBali\Aoc2021\Aoc2021Day18
     * @covers \TBali\Aoc2021\Snailfish
     */
    public function testDay18Example1(): void
    {
        $solver = new Aoc2021Day18();
        $input = $solver->readInput($solver->inputBaseFileName() . 'ex1.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::EXAMPLE_SOLUTIONS[0];
        self::assertSame(strval($expected1), $ans1);
        self::assertSame(strval($expected2), $ans2);
    }

    /**
     * @covers \TBali\Aoc2021\Aoc2021Day18
     * @covers \TBali\Aoc2021\Snailfish
     *
     * @group medium
     */
    public function testDay18(): void
    {
        $solver = new Aoc2021Day18();
        $input = $solver->readInput($solver->inputBaseFileName() . '.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::SOLUTIONS;
        self::assertSame(strval($expected1), $ans1);
        self::assertSame(strval($expected2), $ans2);
    }

    /**
     * @covers \TBali\Aoc2021\Aoc2021Day18
     * @covers \TBali\Aoc2021\Snailfish
     */
    public function testDay18InvalidInput1(): void
    {
        $solver = new Aoc2021Day18();
        $input = ['0'];
        $this->expectException(\Exception::class);
        [$ans1, $ans2] = $solver->solve($input);
    }

    /**
     * @covers \TBali\Aoc2021\Aoc2021Day18
     * @covers \TBali\Aoc2021\Snailfish
     */
    public function testDay18InvalidInput2(): void
    {
        $solver = new Aoc2021Day18();
        $input = ['0', '[1]'];
        $this->expectException(\Exception::class);
        [$ans1, $ans2] = $solver->solve($input);
    }

    /**
     * @covers \TBali\Aoc2021\Aoc2021Day18
     * @covers \TBali\Aoc2021\Snailfish
     */
    public function testDay18InvalidInput3(): void
    {
        $solver = new Aoc2021Day18();
        $input = ['0', '[1,]'];
        $this->expectException(\Exception::class);
        [$ans1, $ans2] = $solver->solve($input);
    }

    // --------------------------------------------------------------------

    /**
     * @covers \TBali\Aoc2021\Aoc2021Day19
     * @covers \TBali\Aoc2021\Matrix
     * @covers \TBali\Aoc2021\Rotations
     * @covers \TBali\Aoc2021\Vector3D
     */
    public function testDay19Example1(): void
    {
        $solver = new Aoc2021Day19();
        $input = $solver->readInput($solver->inputBaseFileName() . 'ex1.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::EXAMPLE_SOLUTIONS[0];
        self::assertSame(strval($expected1), $ans1);
        self::assertSame(strval($expected2), $ans2);
    }

    /**
     * @covers \TBali\Aoc2021\Aoc2021Day19
     * @covers \TBali\Aoc2021\Matrix
     * @covers \TBali\Aoc2021\Rotations
     * @covers \TBali\Aoc2021\Vector3D
     *
     * @group medium
     */
    public function testDay19(): void
    {
        $solver = new Aoc2021Day19();
        $input = $solver->readInput($solver->inputBaseFileName() . '.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::SOLUTIONS;
        self::assertSame(strval($expected1), $ans1);
        self::assertSame(strval($expected2), $ans2);
    }

    /**
     * @covers \TBali\Aoc2021\Aoc2021Day19
     * @covers \TBali\Aoc2021\Matrix
     * @covers \TBali\Aoc2021\Rotations
     * @covers \TBali\Aoc2021\Vector3D
     */
    public function testDay19InvalidInput1(): void
    {
        $solver = new Aoc2021Day19();
        $input = ['a'];
        $this->expectException(\Exception::class);
        [$ans1, $ans2] = $solver->solve($input);
    }

    /**
     * @covers \TBali\Aoc2021\Aoc2021Day19
     * @covers \TBali\Aoc2021\Matrix
     * @covers \TBali\Aoc2021\Rotations
     * @covers \TBali\Aoc2021\Vector3D
     */
    public function testDay19InvalidInput2(): void
    {
        $solver = new Aoc2021Day19();
        $input = ['--- scanner 0', '0,0'];
        $this->expectException(\Exception::class);
        [$ans1, $ans2] = $solver->solve($input);
    }

    // --------------------------------------------------------------------

    /**
     * @covers \TBali\Aoc2021\Aoc2021Day20
     *
     * @group medium
     */
    public function testDay20Example1(): void
    {
        $solver = new Aoc2021Day20();
        $input = $solver->readInput($solver->inputBaseFileName() . 'ex1.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::EXAMPLE_SOLUTIONS[0];
        self::assertSame(strval($expected1), $ans1);
        self::assertSame(strval($expected2), $ans2);
    }

    /**
     * @covers \TBali\Aoc2021\Aoc2021Day20
     *
     * @group large
     */
    public function testDay20(): void
    {
        $solver = new Aoc2021Day20();
        $input = $solver->readInput($solver->inputBaseFileName() . '.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::SOLUTIONS;
        self::assertSame(strval($expected1), $ans1);
        self::assertSame(strval($expected2), $ans2);
    }

    /**
     * @covers \TBali\Aoc2021\Aoc2021Day20
     */
    public function testDay20InvalidInput1(): void
    {
        $solver = new Aoc2021Day20();
        $input = ['#'];
        $this->expectException(\Exception::class);
        [$ans1, $ans2] = $solver->solve($input);
    }

    // --------------------------------------------------------------------

    /**
     * @covers \TBali\Aoc2021\Aoc2021Day21
     *
     * @group medium
     */
    public function testDay21Example1(): void
    {
        $solver = new Aoc2021Day21();
        $input = $solver->readInput($solver->inputBaseFileName() . 'ex1.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::EXAMPLE_SOLUTIONS[0];
        self::assertSame(strval($expected1), $ans1);
        self::assertSame(strval($expected2), $ans2);
    }

    /**
     * @covers \TBali\Aoc2021\Aoc2021Day21
     *
     * @group medium
     */
    public function testDay21(): void
    {
        $solver = new Aoc2021Day21();
        $input = $solver->readInput($solver->inputBaseFileName() . '.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::SOLUTIONS;
        self::assertSame(strval($expected1), $ans1);
        self::assertSame(strval($expected2), $ans2);
    }

    /**
     * @covers \TBali\Aoc2021\Aoc2021Day21
     */
    public function testDay21InvalidInput1(): void
    {
        $solver = new Aoc2021Day21();
        $input = ['a'];
        $this->expectException(\Exception::class);
        [$ans1, $ans2] = $solver->solve($input);
    }

    /**
     * @covers \TBali\Aoc2021\Aoc2021Day21
     */
    public function testDay21InvalidInput2(): void
    {
        $solver = new Aoc2021Day21();
        $input = ['Player 1 starting position: 1', 'Player 2 starting position: -1'];
        $this->expectException(\Exception::class);
        [$ans1, $ans2] = $solver->solve($input);
    }

    // --------------------------------------------------------------------

    /**
     * @covers \TBali\Aoc2021\Aoc2021Day22
     * @covers \TBali\Aoc2021\Cuboid
     */
    public function testDay22Example1(): void
    {
        $solver = new Aoc2021Day22();
        $input = $solver->readInput($solver->inputBaseFileName() . 'ex1.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::EXAMPLE_SOLUTIONS[0];
        self::assertSame(strval($expected1), $ans1);
        self::assertSame(strval($expected2), $ans2);
    }

    /**
     * @covers \TBali\Aoc2021\Aoc2021Day22
     * @covers \TBali\Aoc2021\Cuboid
     */
    public function testDay22Example2(): void
    {
        $solver = new Aoc2021Day22();
        $input = $solver->readInput($solver->inputBaseFileName() . 'ex2.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::EXAMPLE_SOLUTIONS[1];
        self::assertSame(strval($expected1), $ans1);
        // $this->assertEquals(strval($expected2), $ans2);
    }

    /**
     * @covers \TBali\Aoc2021\Aoc2021Day22
     * @covers \TBali\Aoc2021\Cuboid
     *
     * @group large
     */
    public function testDay22Example3(): void
    {
        $solver = new Aoc2021Day22();
        $input = $solver->readInput($solver->inputBaseFileName() . 'ex3.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::EXAMPLE_SOLUTIONS[2];
        self::assertSame(strval($expected1), $ans1);
        self::assertSame(strval($expected2), $ans2);
    }

    /**
     * @covers \TBali\Aoc2021\Aoc2021Day22
     * @covers \TBali\Aoc2021\Cuboid
     *
     * @group large
     */
    public function testDay22(): void
    {
        $solver = new Aoc2021Day22();
        $input = $solver->readInput($solver->inputBaseFileName() . '.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::SOLUTIONS;
        self::assertSame(strval($expected1), $ans1);
        self::assertSame(strval($expected2), $ans2);
    }

    /**
     * @covers \TBali\Aoc2021\Aoc2021Day22
     * @covers \TBali\Aoc2021\Cuboid
     */
    public function testDay22InvalidInput1(): void
    {
        $solver = new Aoc2021Day22();
        $input = ['on x=-1..1,y=-2..2,z='];
        $this->expectException(\Exception::class);
        [$ans1, $ans2] = $solver->solve($input);
    }

    // --------------------------------------------------------------------

    /**
     * @covers \TBali\Aoc2021\Aoc2021Day23
     * @covers \TBali\Aoc2021\Burrow
     * @covers \TBali\Aoc2021\MinPriorityQueue
     *
     * @group large
     */
    public function testDay23Example1(): void
    {
        $solver = new Aoc2021Day23();
        $input = $solver->readInput($solver->inputBaseFileName() . 'ex1.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::EXAMPLE_SOLUTIONS[0];
        self::assertSame(strval($expected1), $ans1);
        self::assertSame(strval($expected2), $ans2);
    }

    /**
     * @covers \TBali\Aoc2021\Aoc2021Day23
     * @covers \TBali\Aoc2021\Burrow
     * @covers \TBali\Aoc2021\MinPriorityQueue
     *
     * @group large
     */
    public function testDay23(): void
    {
        $solver = new Aoc2021Day23();
        $input = $solver->readInput($solver->inputBaseFileName() . '.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::SOLUTIONS;
        self::assertSame(strval($expected1), $ans1);
        self::assertSame(strval($expected2), $ans2);
    }

    // --------------------------------------------------------------------

    /**
     * @covers \TBali\Aoc2021\Aoc2021Day24
     *
     * @group large
     */
    public function testDay24(): void
    {
        $solver = new Aoc2021Day24();
        $input = $solver->readInput($solver->inputBaseFileName() . '.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::SOLUTIONS;
        self::assertSame(strval($expected1), $ans1);
        self::assertSame(strval($expected2), $ans2);
    }

    // --------------------------------------------------------------------

    /**
     * @covers \TBali\Aoc2021\Aoc2021Day25
     */
    public function testDay25Example1(): void
    {
        $solver = new Aoc2021Day25();
        $input = $solver->readInput($solver->inputBaseFileName() . 'ex1.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::EXAMPLE_SOLUTIONS[0];
        self::assertSame(strval($expected1), $ans1);
        // $this->assertEquals(strval($expected2), $ans2);
    }

    /**
     * @covers \TBali\Aoc2021\Aoc2021Day25
     *
     * @group large
     */
    public function testDay25(): void
    {
        $solver = new Aoc2021Day25();
        $input = $solver->readInput($solver->inputBaseFileName() . '.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::SOLUTIONS;
        self::assertSame(strval($expected1), $ans1);
        // $this->assertEquals(strval($expected2), $ans2);
    }

    // --------------------------------------------------------------------
}
