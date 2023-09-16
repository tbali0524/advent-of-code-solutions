<?php

declare(strict_types=1);

namespace TBali\Tests;

use PHPUnit\Framework\Attributes\IgnoreClassForCodeCoverage;
use PHPUnit\Framework\Attributes\RequiresPhp;
use PHPUnit\Framework\Attributes\RequiresPhpunit;
use PHPUnit\Framework\TestCase;
use TBali\Aoc2016\Aoc2016Day01;
use TBali\Aoc2016\Aoc2016Day02;
use TBali\Aoc2016\Aoc2016Day03;
use TBali\Aoc2016\Aoc2016Day04;
use TBali\Aoc2016\Aoc2016Day05;
use TBali\Aoc2016\Aoc2016Day06;
use TBali\Aoc2016\Aoc2016Day07;
use TBali\Aoc2016\Aoc2016Day08;
use TBali\Aoc2016\Aoc2016Day09;
use TBali\Aoc2016\Aoc2016Day10;
use TBali\Aoc2016\Aoc2016Day11;
use TBali\Aoc2016\Aoc2016Day12;
use TBali\Aoc2016\Aoc2016Day13;
use TBali\Aoc2016\Aoc2016Day14;
use TBali\Aoc2016\Aoc2016Day15;
use TBali\Aoc2016\Aoc2016Day16;
use TBali\Aoc2016\Aoc2016Day17;
use TBali\Aoc2016\Aoc2016Day18;
use TBali\Aoc2016\Aoc2016Day19;
use TBali\Aoc2016\Aoc2016Day20;
use TBali\Aoc2016\Aoc2016Day21;
use TBali\Aoc2016\Aoc2016Day22;
use TBali\Aoc2016\Aoc2016Day23;
use TBali\Aoc2016\Aoc2016Day24;
use TBali\Aoc2016\Aoc2016Day25;

/**
 * Unit tests for Advent of Code season 2016.
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
#[IgnoreClassForCodeCoverage(Aoc2016Day05::class)]
#[IgnoreClassForCodeCoverage(Aoc2016Day14::class)]
#[IgnoreClassForCodeCoverage(Aoc2016Day25::class)]
final class Aoc2016Test extends TestCase
{
    // --------------------------------------------------------------------

    /**
     * @covers \TBali\Aoc2016\Aoc2016Day01
     */
    public function testDay01Example1(): void
    {
        $solver = new Aoc2016Day01();
        $input = [$solver::EXAMPLE_STRING_INPUTS[0]];
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::EXAMPLE_SOLUTIONS[0];
        self::assertSame(strval($expected1), $ans1);
        self::assertSame(strval($expected2), $ans2);
    }

    /**
     * @covers \TBali\Aoc2016\Aoc2016Day01
     */
    public function testDay01(): void
    {
        $solver = new Aoc2016Day01();
        $input = $solver->readInput($solver->inputBaseFileName() . '.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::SOLUTIONS;
        self::assertSame(strval($expected1), $ans1);
        self::assertSame(strval($expected2), $ans2);
    }

    // --------------------------------------------------------------------

    /**
     * @covers \TBali\Aoc2016\Aoc2016Day02
     */
    public function testDay02Example1(): void
    {
        $solver = new Aoc2016Day02();
        $input = $solver->readInput($solver->inputBaseFileName() . 'ex1.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::EXAMPLE_SOLUTIONS[0];
        self::assertSame(strval($expected1), $ans1);
        self::assertSame(strval($expected2), $ans2);
    }

    /**
     * @covers \TBali\Aoc2016\Aoc2016Day02
     */
    public function testDay02(): void
    {
        $solver = new Aoc2016Day02();
        $input = $solver->readInput($solver->inputBaseFileName() . '.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::SOLUTIONS;
        self::assertSame(strval($expected1), $ans1);
        self::assertSame(strval($expected2), $ans2);
    }

    // --------------------------------------------------------------------

    /**
     * @covers \TBali\Aoc2016\Aoc2016Day03
     */
    public function testDay03(): void
    {
        $solver = new Aoc2016Day03();
        $input = $solver->readInput($solver->inputBaseFileName() . '.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::SOLUTIONS;
        self::assertSame(strval($expected1), $ans1);
        self::assertSame(strval($expected2), $ans2);
    }

    // --------------------------------------------------------------------

    /**
     * @covers \TBali\Aoc2016\Aoc2016Day04
     */
    public function testDay04Example1(): void
    {
        $solver = new Aoc2016Day04();
        $input = $solver->readInput($solver->inputBaseFileName() . 'ex1.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::EXAMPLE_SOLUTIONS[0];
        self::assertSame(strval($expected1), $ans1);
        // self::assertSame(strval($expected2), $ans2);
    }

    /**
     * @covers \TBali\Aoc2016\Aoc2016Day04
     */
    public function testDay04(): void
    {
        $solver = new Aoc2016Day04();
        $input = $solver->readInput($solver->inputBaseFileName() . '.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::SOLUTIONS;
        self::assertSame(strval($expected1), $ans1);
        self::assertSame(strval($expected2), $ans2);
    }

    // --------------------------------------------------------------------

    /**
     * @covers \TBali\Aoc2016\Aoc2016Day05
     *
     * @group large
     */
    public function testDay05Example1(): void
    {
        $solver = new Aoc2016Day05();
        $input = [$solver::EXAMPLE_STRING_INPUTS[0]];
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::EXAMPLE_SOLUTIONS[0];
        self::assertSame(strval($expected1), $ans1);
        self::assertSame(strval($expected2), $ans2);
    }

    /**
     * @covers \TBali\Aoc2016\Aoc2016Day05
     *
     * @group large
     */
    public function testDay05(): void
    {
        $solver = new Aoc2016Day05();
        $input = [$solver::STRING_INPUT];
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::SOLUTIONS;
        self::assertSame(strval($expected1), $ans1);
        self::assertSame(strval($expected2), $ans2);
    }

    // --------------------------------------------------------------------

    /**
     * @covers \TBali\Aoc2016\Aoc2016Day06
     */
    public function testDay06Example1(): void
    {
        $solver = new Aoc2016Day06();
        $input = $solver->readInput($solver->inputBaseFileName() . 'ex1.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::EXAMPLE_SOLUTIONS[0];
        self::assertSame(strval($expected1), $ans1);
        self::assertSame(strval($expected2), $ans2);
    }

    /**
     * @covers \TBali\Aoc2016\Aoc2016Day06
     */
    public function testDay06(): void
    {
        $solver = new Aoc2016Day06();
        $input = $solver->readInput($solver->inputBaseFileName() . '.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::SOLUTIONS;
        self::assertSame(strval($expected1), $ans1);
        self::assertSame(strval($expected2), $ans2);
    }

    // --------------------------------------------------------------------

    /**
     * @covers \TBali\Aoc2016\Aoc2016Day07
     */
    public function testDay07Example1(): void
    {
        $solver = new Aoc2016Day07();
        $input = $solver->readInput($solver->inputBaseFileName() . 'ex1.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::EXAMPLE_SOLUTIONS[0];
        self::assertSame(strval($expected1), $ans1);
        // self::assertSame(strval($expected2), $ans2);
    }

    /**
     * @covers \TBali\Aoc2016\Aoc2016Day07
     */
    public function testDay07Example2(): void
    {
        $solver = new Aoc2016Day07();
        $input = $solver->readInput($solver->inputBaseFileName() . 'ex2.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::EXAMPLE_SOLUTIONS[1];
        // self::assertSame(strval($expected1), $ans1);
        self::assertSame(strval($expected2), $ans2);
    }

    /**
     * @covers \TBali\Aoc2016\Aoc2016Day07
     */
    public function testDay07(): void
    {
        $solver = new Aoc2016Day07();
        $input = $solver->readInput($solver->inputBaseFileName() . '.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::SOLUTIONS;
        self::assertSame(strval($expected1), $ans1);
        self::assertSame(strval($expected2), $ans2);
    }

    // --------------------------------------------------------------------

    /**
     * @covers \TBali\Aoc2016\Aoc2016Day08
     * @covers \TBali\Aoc2016\Display
     * @covers \TBali\Aoc2016\Instruction
     */
    public function testDay08Example1(): void
    {
        $solver = new Aoc2016Day08();
        $input = $solver->readInput($solver->inputBaseFileName() . 'ex1.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::EXAMPLE_SOLUTIONS[0];
        self::assertSame(strval($expected1), $ans1);
        // self::assertSame(strval($expected2), $ans2);
    }

    /**
     * @covers \TBali\Aoc2016\Aoc2016Day08
     * @covers \TBali\Aoc2016\Display
     * @covers \TBali\Aoc2016\Instruction
     */
    public function testDay08(): void
    {
        $solver = new Aoc2016Day08();
        $input = $solver->readInput($solver->inputBaseFileName() . '.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::SOLUTIONS;
        self::assertSame(strval($expected1), $ans1);
        self::assertSame(strval($expected2), $ans2);
    }

    /**
     * @covers \TBali\Aoc2016\Aoc2016Day08
     * @covers \TBali\Aoc2016\Display
     * @covers \TBali\Aoc2016\Instruction
     */
    public function testDay08InvalidInput1(): void
    {
        $solver = new Aoc2016Day08();
        $input = ['rext 1x1 1'];
        $this->expectException(\Exception::class);
        [$ans1, $ans2] = $solver->solve($input);
    }

    /**
     * @covers \TBali\Aoc2016\Aoc2016Day08
     * @covers \TBali\Aoc2016\Display
     * @covers \TBali\Aoc2016\Instruction
     */
    public function testDay08InvalidInput2(): void
    {
        $solver = new Aoc2016Day08();
        $input = ['rect 1x1 1'];
        $this->expectException(\Exception::class);
        [$ans1, $ans2] = $solver->solve($input);
    }

    /**
     * @covers \TBali\Aoc2016\Aoc2016Day08
     * @covers \TBali\Aoc2016\Display
     * @covers \TBali\Aoc2016\Instruction
     */
    public function testDay08InvalidInput3(): void
    {
        $solver = new Aoc2016Day08();
        $input = ['rect 1x1x1'];
        $this->expectException(\Exception::class);
        [$ans1, $ans2] = $solver->solve($input);
    }

    /**
     * @covers \TBali\Aoc2016\Aoc2016Day08
     * @covers \TBali\Aoc2016\Display
     * @covers \TBali\Aoc2016\Instruction
     */
    public function testDay08InvalidInput4(): void
    {
        $solver = new Aoc2016Day08();
        $input = ['rotate row y=0 by 1 1'];
        $this->expectException(\Exception::class);
        [$ans1, $ans2] = $solver->solve($input);
    }

    /**
     * @covers \TBali\Aoc2016\Aoc2016Day08
     * @covers \TBali\Aoc2016\Display
     * @covers \TBali\Aoc2016\Instruction
     */
    public function testDay08InvalidInput5(): void
    {
        $solver = new Aoc2016Day08();
        $input = ['rotate row y=0=1 by 1'];
        $this->expectException(\Exception::class);
        [$ans1, $ans2] = $solver->solve($input);
    }

    /**
     * @covers \TBali\Aoc2016\Aoc2016Day08
     * @covers \TBali\Aoc2016\Display
     * @covers \TBali\Aoc2016\Instruction
     */
    public function testDay08InvalidInput6(): void
    {
        $solver = new Aoc2016Day08();
        $input = ['rotate row z=0 by 1'];
        $this->expectException(\Exception::class);
        [$ans1, $ans2] = $solver->solve($input);
    }

    // --------------------------------------------------------------------

    /**
     * @covers \TBali\Aoc2016\Aoc2016Day09
     */
    public function testDay09Example1(): void
    {
        $solver = new Aoc2016Day09();
        $input = $solver->readInput($solver->inputBaseFileName() . 'ex1.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::EXAMPLE_SOLUTIONS[0];
        self::assertSame(strval($expected1), $ans1);
        // self::assertSame(strval($expected2), $ans2);
    }

    /**
     * @covers \TBali\Aoc2016\Aoc2016Day09
     */
    public function testDay09Example2(): void
    {
        $solver = new Aoc2016Day09();
        $input = $solver->readInput($solver->inputBaseFileName() . 'ex2.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::EXAMPLE_SOLUTIONS[1];
        // self::assertSame(strval($expected1), $ans1);
        self::assertSame(strval($expected2), $ans2);
    }

    /**
     * @covers \TBali\Aoc2016\Aoc2016Day09
     */
    public function testDay09(): void
    {
        $solver = new Aoc2016Day09();
        $input = $solver->readInput($solver->inputBaseFileName() . '.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::SOLUTIONS;
        self::assertSame(strval($expected1), $ans1);
        self::assertSame(strval($expected2), $ans2);
    }

    /**
     * @covers \TBali\Aoc2016\Aoc2016Day09
     */
    public function testDay09InvalidInput1(): void
    {
        $solver = new Aoc2016Day09();
        $input = ['A(1)B'];
        $this->expectException(\Exception::class);
        [$ans1, $ans2] = $solver->solve($input);
    }

    /**
     * @covers \TBali\Aoc2016\Aoc2016Day09
     */
    public function testDay09InvalidInput2(): void
    {
        $solver = new Aoc2016Day09();
        $input = ['A(1x2x3)B'];
        $this->expectException(\Exception::class);
        [$ans1, $ans2] = $solver->solve($input);
    }

    // --------------------------------------------------------------------

    /**
     * @covers \TBali\Aoc2016\Aoc2016Day10
     * @covers \TBali\Aoc2016\Bot
     */
    public function testDay10Example1(): void
    {
        $solver = new Aoc2016Day10();
        $input = $solver->readInput($solver->inputBaseFileName() . 'ex1.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::EXAMPLE_SOLUTIONS[0];
        self::assertSame(strval($expected1), $ans1);
        self::assertSame(strval($expected2), $ans2);
    }

    /**
     * @covers \TBali\Aoc2016\Aoc2016Day10
     * @covers \TBali\Aoc2016\Bot
     */
    public function testDay10(): void
    {
        $solver = new Aoc2016Day10();
        $input = $solver->readInput($solver->inputBaseFileName() . '.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::SOLUTIONS;
        self::assertSame(strval($expected1), $ans1);
        self::assertSame(strval($expected2), $ans2);
    }

    /**
     * @covers \TBali\Aoc2016\Aoc2016Day10
     * @covers \TBali\Aoc2016\Bot
     */
    public function testDay10InvalidInput1(): void
    {
        $solver = new Aoc2016Day10();
        $input = ['value 2 goes to bot 1 a'];
        $this->expectException(\Exception::class);
        [$ans1, $ans2] = $solver->solve($input);
    }

    /**
     * @covers \TBali\Aoc2016\Aoc2016Day10
     * @covers \TBali\Aoc2016\Bot
     */
    public function testDay10InvalidInput2(): void
    {
        $solver = new Aoc2016Day10();
        $input = ['bot 1 gives low to bot 2 and high to bot 3 a'];
        $this->expectException(\Exception::class);
        [$ans1, $ans2] = $solver->solve($input);
    }

    /**
     * @covers \TBali\Aoc2016\Aoc2016Day10
     * @covers \TBali\Aoc2016\Bot
     */
    public function testDay10InvalidInput3(): void
    {
        $solver = new Aoc2016Day10();
        $input = ['a'];
        $this->expectException(\Exception::class);
        [$ans1, $ans2] = $solver->solve($input);
    }

    // --------------------------------------------------------------------

    /**
     * @covers \TBali\Aoc2016\Aoc2016Day11
     * @covers \TBali\Aoc2016\House
     */
    public function testDay11Example1(): void
    {
        $solver = new Aoc2016Day11();
        $input = $solver->readInput($solver->inputBaseFileName() . 'ex1.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::EXAMPLE_SOLUTIONS[0];
        self::assertSame(strval($expected1), $ans1);
        // self::assertSame(strval($expected2), $ans2);
    }

    /**
     * @covers \TBali\Aoc2016\Aoc2016Day11
     * @covers \TBali\Aoc2016\House
     *
     * @group large
     */
    public function testDay11(): void
    {
        self::markTestSkipped(); // very slow with xdebug coverage
        $solver = new Aoc2016Day11();
        $input = $solver->readInput($solver->inputBaseFileName() . '.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::SOLUTIONS;
        self::assertSame(strval($expected1), $ans1);
        self::assertSame(strval($expected2), $ans2);
    }

    /**
     * @covers \TBali\Aoc2016\Aoc2016Day11
     */
    public function testDay11InvalidInput1(): void
    {
        $solver = new Aoc2016Day11();
        $input = ['The first floorA contains a A generator, a A-compatible microchip and a B generator.'];
        $this->expectException(\Exception::class);
        [$ans1, $ans2] = $solver->solve($input);
    }

    /**
     * @covers \TBali\Aoc2016\Aoc2016Day11
     */
    public function testDay11InvalidInput2(): void
    {
        $solver = new Aoc2016Day11();
        $input = ['The first floor contains the A generator and a A-compatible microchip.'];
        $this->expectException(\Exception::class);
        [$ans1, $ans2] = $solver->solve($input);
    }

    /**
     * @covers \TBali\Aoc2016\Aoc2016Day11
     */
    public function testDay11InvalidInput3(): void
    {
        $solver = new Aoc2016Day11();
        $input = ['The first floor contains the A item and a A-compatible microchip.'];
        $this->expectException(\Exception::class);
        [$ans1, $ans2] = $solver->solve($input);
    }

    // --------------------------------------------------------------------

    /**
     * @covers \TBali\Aoc2016\Aoc2016Day12
     */
    public function testDay12Example1(): void
    {
        $solver = new Aoc2016Day12();
        $input = $solver->readInput($solver->inputBaseFileName() . 'ex1.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::EXAMPLE_SOLUTIONS[0];
        self::assertSame(strval($expected1), $ans1);
        self::assertSame(strval($expected2), $ans2);
    }

    /**
     * @covers \TBali\Aoc2016\Aoc2016Day12
     *
     * @group large
     */
    public function testDay12(): void
    {
        $solver = new Aoc2016Day12();
        $input = $solver->readInput($solver->inputBaseFileName() . '.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::SOLUTIONS;
        self::assertSame(strval($expected1), $ans1);
        self::assertSame(strval($expected2), $ans2);
    }

    /**
     * @covers \TBali\Aoc2016\Aoc2016Day12
     */
    public function testDay12InvalidInput1(): void
    {
        $solver = new Aoc2016Day12();
        $input = ['div'];
        $this->expectException(\Exception::class);
        [$ans1, $ans2] = $solver->solve($input);
    }

    /**
     * @covers \TBali\Aoc2016\Aoc2016Day12
     */
    public function testDay12InvalidInput2(): void
    {
        $solver = new Aoc2016Day12();
        $input = ['cpy a'];
        $this->expectException(\Exception::class);
        [$ans1, $ans2] = $solver->solve($input);
    }

    /**
     * @covers \TBali\Aoc2016\Aoc2016Day12
     */
    public function testDay12InvalidInput3(): void
    {
        $solver = new Aoc2016Day12();
        $input = ['inc a 1'];
        $this->expectException(\Exception::class);
        [$ans1, $ans2] = $solver->solve($input);
    }

    /**
     * @covers \TBali\Aoc2016\Aoc2016Day12
     */
    public function testDay12InvalidInput4(): void
    {
        $solver = new Aoc2016Day12();
        $input = ['dec'];
        $this->expectException(\Exception::class);
        [$ans1, $ans2] = $solver->solve($input);
    }

    /**
     * @covers \TBali\Aoc2016\Aoc2016Day12
     */
    public function testDay12InvalidInput5(): void
    {
        $solver = new Aoc2016Day12();
        $input = ['jnz'];
        $this->expectException(\Exception::class);
        [$ans1, $ans2] = $solver->solve($input);
    }

    // --------------------------------------------------------------------

    /**
     * @covers \TBali\Aoc2016\Aoc2016Day13
     */
    public function testDay13Example1(): void
    {
        $solver = new Aoc2016Day13();
        $input = [$solver::EXAMPLE_STRING_INPUTS[0]];
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::EXAMPLE_SOLUTIONS[0];
        self::assertSame(strval($expected1), $ans1);
        // self::assertSame(strval($expected2), $ans2);
    }

    /**
     * @covers \TBali\Aoc2016\Aoc2016Day13
     */
    public function testDay13(): void
    {
        $solver = new Aoc2016Day13();
        $input = [$solver::STRING_INPUT];
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::SOLUTIONS;
        self::assertSame(strval($expected1), $ans1);
        self::assertSame(strval($expected2), $ans2);
    }

    // --------------------------------------------------------------------

    /**
     * @covers \TBali\Aoc2016\Aoc2016Day14
     *
     * @group large
     */
    public function testDay14Example1(): void
    {
        $solver = new Aoc2016Day14();
        $input = [$solver::EXAMPLE_STRING_INPUTS[0]];
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::EXAMPLE_SOLUTIONS[0];
        self::assertSame(strval($expected1), $ans1);
        self::assertSame(strval($expected2), $ans2);
    }

    /**
     * @covers \TBali\Aoc2016\Aoc2016Day14
     *
     * @group large
     */
    public function testDay14(): void
    {
        $solver = new Aoc2016Day14();
        $input = [$solver::STRING_INPUT];
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::SOLUTIONS;
        self::assertSame(strval($expected1), $ans1);
        self::assertSame(strval($expected2), $ans2);
    }

    // --------------------------------------------------------------------

    /**
     * @covers \TBali\Aoc2016\Aoc2016Day15
     */
    public function testDay15Example1(): void
    {
        $solver = new Aoc2016Day15();
        $input = $solver->readInput($solver->inputBaseFileName() . 'ex1.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::EXAMPLE_SOLUTIONS[0];
        self::assertSame(strval($expected1), $ans1);
        // self::assertSame(strval($expected2), $ans2);
    }

    /**
     * @covers \TBali\Aoc2016\Aoc2016Day15
     */
    public function testDay15(): void
    {
        $solver = new Aoc2016Day15();
        $input = $solver->readInput($solver->inputBaseFileName() . '.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::SOLUTIONS;
        self::assertSame(strval($expected1), $ans1);
        self::assertSame(strval($expected2), $ans2);
    }

    /**
     * @covers \TBali\Aoc2016\Aoc2016Day15
     */
    public function testDay15InvalidInput1(): void
    {
        $solver = new Aoc2016Day15();
        $input = ['Disc #1 has 2 positions; at time=0, it is at position'];
        $this->expectException(\Exception::class);
        [$ans1, $ans2] = $solver->solve($input);
    }

    // --------------------------------------------------------------------

    /**
     * @covers \TBali\Aoc2016\Aoc2016Day16
     */
    public function testDay16Example1(): void
    {
        $solver = new Aoc2016Day16();
        $input = [$solver::EXAMPLE_STRING_INPUTS[0]];
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::EXAMPLE_SOLUTIONS[0];
        self::assertSame(strval($expected1), $ans1);
        self::assertSame(strval($expected2), $ans2);
    }

    /**
     * @covers \TBali\Aoc2016\Aoc2016Day16
     *
     * @group large
     */
    public function testDay16(): void
    {
        $solver = new Aoc2016Day16();
        $input = [$solver::STRING_INPUT];
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::SOLUTIONS;
        self::assertSame(strval($expected1), $ans1);
        self::assertSame(strval($expected2), $ans2);
    }

    // --------------------------------------------------------------------

    /**
     * @covers \TBali\Aoc2016\Aoc2016Day17
     */
    public function testDay17Example1(): void
    {
        $solver = new Aoc2016Day17();
        $input = [$solver::EXAMPLE_STRING_INPUTS[0]];
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::EXAMPLE_SOLUTIONS[0];
        self::assertSame(strval($expected1), $ans1);
        self::assertSame(strval($expected2), $ans2);
    }

    /**
     * @covers \TBali\Aoc2016\Aoc2016Day17
     */
    public function testDay17(): void
    {
        $solver = new Aoc2016Day17();
        $input = [$solver::STRING_INPUT];
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::SOLUTIONS;
        self::assertSame(strval($expected1), $ans1);
        self::assertSame(strval($expected2), $ans2);
    }

    // --------------------------------------------------------------------

    /**
     * @covers \TBali\Aoc2016\Aoc2016Day18
     */
    public function testDay18Example1(): void
    {
        $solver = new Aoc2016Day18();
        $input = $solver->readInput($solver->inputBaseFileName() . 'ex1.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::EXAMPLE_SOLUTIONS[0];
        self::assertSame(strval($expected1), $ans1);
        // self::assertSame(strval($expected2), $ans2);
    }

    /**
     * @covers \TBali\Aoc2016\Aoc2016Day18
     */
    public function testDay18Example2(): void
    {
        $solver = new Aoc2016Day18();
        $input = $solver->readInput($solver->inputBaseFileName() . 'ex2.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::EXAMPLE_SOLUTIONS[1];
        self::assertSame(strval($expected1), $ans1);
        // self::assertSame(strval($expected2), $ans2);
    }

    /**
     * @covers \TBali\Aoc2016\Aoc2016Day18
     *
     * @group large
     */
    public function testDay18(): void
    {
        $solver = new Aoc2016Day18();
        $input = $solver->readInput($solver->inputBaseFileName() . '.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::SOLUTIONS;
        self::assertSame(strval($expected1), $ans1);
        self::assertSame(strval($expected2), $ans2);
    }

    // --------------------------------------------------------------------

    /**
     * @covers \TBali\Aoc2016\Aoc2016Day19
     */
    public function testDay19Example1(): void
    {
        $solver = new Aoc2016Day19();
        $input = [$solver::EXAMPLE_STRING_INPUTS[0]];
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::EXAMPLE_SOLUTIONS[0];
        self::assertSame(strval($expected1), $ans1);
        self::assertSame(strval($expected2), $ans2);
    }

    /**
     * @covers \TBali\Aoc2016\Aoc2016Day19
     *
     * @group medium
     */
    public function testDay19(): void
    {
        $solver = new Aoc2016Day19();
        $input = [$solver::STRING_INPUT];
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::SOLUTIONS;
        self::assertSame(strval($expected1), $ans1);
        self::assertSame(strval($expected2), $ans2);
    }

    // --------------------------------------------------------------------

    /**
     * @covers \TBali\Aoc2016\Aoc2016Day20
     */
    public function testDay20Example1(): void
    {
        $solver = new Aoc2016Day20();
        $input = $solver->readInput($solver->inputBaseFileName() . 'ex1.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::EXAMPLE_SOLUTIONS[0];
        self::assertSame(strval($expected1), $ans1);
        self::assertSame(strval($expected2), $ans2);
    }

    /**
     * @covers \TBali\Aoc2016\Aoc2016Day20
     *
     * @group medium
     */
    public function testDay20(): void
    {
        $solver = new Aoc2016Day20();
        $input = $solver->readInput($solver->inputBaseFileName() . '.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::SOLUTIONS;
        self::assertSame(strval($expected1), $ans1);
        self::assertSame(strval($expected2), $ans2);
    }

    // --------------------------------------------------------------------

    /**
     * @covers \TBali\Aoc2016\Aoc2016Day21
     */
    public function testDay21Example1(): void
    {
        $solver = new Aoc2016Day21();
        $input = $solver->readInput($solver->inputBaseFileName() . 'ex1.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::EXAMPLE_SOLUTIONS[0];
        self::assertSame(strval($expected1), $ans1);
        // self::assertSame(strval($expected2), $ans2);
    }

    /**
     * @covers \TBali\Aoc2016\Aoc2016Day21
     */
    public function testDay21(): void
    {
        $solver = new Aoc2016Day21();
        $input = $solver->readInput($solver->inputBaseFileName() . '.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::SOLUTIONS;
        self::assertSame(strval($expected1), $ans1);
        self::assertSame(strval($expected2), $ans2);
    }

    /**
     * @covers \TBali\Aoc2016\Aoc2016Day21
     */
    public function testDay21InvalidInput1(): void
    {
        $solver = new Aoc2016Day21();
        $input = ['swap position 1'];
        $this->expectException(\Exception::class);
        [$ans1, $ans2] = $solver->solve($input);
    }

    /**
     * @covers \TBali\Aoc2016\Aoc2016Day21
     */
    public function testDay21InvalidInput2(): void
    {
        $solver = new Aoc2016Day21();
        $input = ['swap position 0 with position 1000'];
        $this->expectException(\Exception::class);
        [$ans1, $ans2] = $solver->solve($input);
    }

    /**
     * @covers \TBali\Aoc2016\Aoc2016Day21
     */
    public function testDay21InvalidInput3(): void
    {
        $solver = new Aoc2016Day21();
        $input = ['swap letter 1'];
        $this->expectException(\Exception::class);
        [$ans1, $ans2] = $solver->solve($input);
    }

    /**
     * @covers \TBali\Aoc2016\Aoc2016Day21
     */
    public function testDay21InvalidInput4(): void
    {
        $solver = new Aoc2016Day21();
        $input = ['swap letter z with letter a'];
        $this->expectException(\Exception::class);
        [$ans1, $ans2] = $solver->solve($input);
    }

    /**
     * @covers \TBali\Aoc2016\Aoc2016Day21
     */
    public function testDay21InvalidInput5(): void
    {
        $solver = new Aoc2016Day21();
        $input = ['rotate left 1'];
        $this->expectException(\Exception::class);
        [$ans1, $ans2] = $solver->solve($input);
    }

    /**
     * @covers \TBali\Aoc2016\Aoc2016Day21
     */
    public function testDay21InvalidInput6(): void
    {
        $solver = new Aoc2016Day21();
        $input = ['rotate right 2 steps a'];
        $this->expectException(\Exception::class);
        [$ans1, $ans2] = $solver->solve($input);
    }

    /**
     * @covers \TBali\Aoc2016\Aoc2016Day21
     */
    public function testDay21InvalidInput7(): void
    {
        $solver = new Aoc2016Day21();
        $input = ['rotate based on position of letter'];
        $this->expectException(\Exception::class);
        [$ans1, $ans2] = $solver->solve($input);
    }

    /**
     * @covers \TBali\Aoc2016\Aoc2016Day21
     */
    public function testDay21InvalidInput8(): void
    {
        $solver = new Aoc2016Day21();
        $input = ['rotate based on position of letter z'];
        $this->expectException(\Exception::class);
        [$ans1, $ans2] = $solver->solve($input);
    }

    /**
     * @covers \TBali\Aoc2016\Aoc2016Day21
     */
    public function testDay21InvalidInput9(): void
    {
        $solver = new Aoc2016Day21();
        $input = ['reverse positions 1 through 2 a'];
        $this->expectException(\Exception::class);
        [$ans1, $ans2] = $solver->solve($input);
    }

    // --------------------------------------------------------------------

    /**
     * @covers \TBali\Aoc2016\Aoc2016Day22
     * @covers \TBali\Aoc2016\Node
     */
    public function testDay22Example1(): void
    {
        $solver = new Aoc2016Day22();
        $input = $solver->readInput($solver->inputBaseFileName() . 'ex1.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::EXAMPLE_SOLUTIONS[0];
        self::assertSame(strval($expected1), $ans1);
        // self::assertSame(strval($expected2), $ans2);
    }

    /**
     * @covers \TBali\Aoc2016\Aoc2016Day22
     * @covers \TBali\Aoc2016\Node
     *
     * @group medium
     */
    public function testDay22(): void
    {
        $solver = new Aoc2016Day22();
        $input = $solver->readInput($solver->inputBaseFileName() . '.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::SOLUTIONS;
        self::assertSame(strval($expected1), $ans1);
        self::assertSame(strval($expected2), $ans2);
    }

    /**
     * @covers \TBali\Aoc2016\Aoc2016Day22
     * @covers \TBali\Aoc2016\Node
     */
    public function testDay22InvalidInput1(): void
    {
        $solver = new Aoc2016Day22();
        $input = ['', '', 'a'];
        $this->expectException(\Exception::class);
        [$ans1, $ans2] = $solver->solve($input);
    }

    // --------------------------------------------------------------------

    /**
     * @covers \TBali\Aoc2016\Aoc2016Day23
     */
    public function testDay23Example1(): void
    {
        $solver = new Aoc2016Day23();
        $input = $solver->readInput($solver->inputBaseFileName() . 'ex1.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::EXAMPLE_SOLUTIONS[0];
        self::assertSame(strval($expected1), $ans1);
        // self::assertSame(strval($expected2), $ans2);
    }

    /**
     * @covers \TBali\Aoc2016\Aoc2016Day23
     */
    public function testDay23(): void
    {
        $solver = new Aoc2016Day23();
        $input = $solver->readInput($solver->inputBaseFileName() . '.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::SOLUTIONS;
        self::assertSame(strval($expected1), $ans1);
        self::assertSame(strval($expected2), $ans2);
    }

    /**
     * @covers \TBali\Aoc2016\Aoc2016Day23
     */
    public function testDay23InvalidInput1(): void
    {
        $solver = new Aoc2016Day23();
        $input = ['div'];
        $this->expectException(\Exception::class);
        [$ans1, $ans2] = $solver->solve($input);
    }

    /**
     * @covers \TBali\Aoc2016\Aoc2016Day23
     */
    public function testDay23InvalidInput2(): void
    {
        $solver = new Aoc2016Day23();
        $input = ['tgl a 1'];
        $this->expectException(\Exception::class);
        [$ans1, $ans2] = $solver->solve($input);
    }

    // --------------------------------------------------------------------

    /**
     * @covers \TBali\Aoc2016\Aoc2016Day24
     */
    public function testDay24Example1(): void
    {
        $solver = new Aoc2016Day24();
        $input = $solver->readInput($solver->inputBaseFileName() . 'ex1.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::EXAMPLE_SOLUTIONS[0];
        self::assertSame(strval($expected1), $ans1);
        self::assertSame(strval($expected2), $ans2);
    }

    /**
     * @covers \TBali\Aoc2016\Aoc2016Day24
     *
     * @group large
     */
    public function testDay24(): void
    {
        $solver = new Aoc2016Day24();
        $input = $solver->readInput($solver->inputBaseFileName() . '.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::SOLUTIONS;
        self::assertSame(strval($expected1), $ans1);
        self::assertSame(strval($expected2), $ans2);
    }

    /**
     * @covers \TBali\Aoc2016\Aoc2016Day24
     */
    public function testDay24InvalidInput1(): void
    {
        $solver = new Aoc2016Day24();
        $input = ['#'];
        $this->expectException(\Exception::class);
        [$ans1, $ans2] = $solver->solve($input);
    }

    // --------------------------------------------------------------------

    /**
     * @covers \TBali\Aoc2016\Aoc2016Day25
     *
     * @group large
     */
    public function testDay25(): void
    {
        $solver = new Aoc2016Day25();
        $input = $solver->readInput($solver->inputBaseFileName() . '.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::SOLUTIONS;
        self::assertSame(strval($expected1), $ans1);
        // self::assertSame(strval($expected2), $ans2);
    }

    // --------------------------------------------------------------------
}
