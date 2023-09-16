<?php

declare(strict_types=1);

namespace TBali\Tests;

use PHPUnit\Framework\Attributes\IgnoreClassForCodeCoverage;
use PHPUnit\Framework\Attributes\RequiresPhp;
use PHPUnit\Framework\Attributes\RequiresPhpunit;
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
 * Instead of using this file with phpunit, it is a better way to run the solutions by using AoCRunner.
 *
 * @internal
 *
 * @coversNothing
 */
#[RequiresPhp('^8.2')]
#[RequiresPhpunit('^10.3')]
#[IgnoreClassForCodeCoverage(\TBali\Aoc\SolutionBase::class)]
#[IgnoreClassForCodeCoverage(Aoc2015Day04::class)]
#[IgnoreClassForCodeCoverage(Aoc2015Day06::class)]
#[IgnoreClassForCodeCoverage(\TBali\Aoc2015\Instruction::class)]
#[IgnoreClassForCodeCoverage(Aoc2015Day10::class)]
#[IgnoreClassForCodeCoverage(Aoc2015Day20::class)]
#[IgnoreClassForCodeCoverage(\TBali\Aoc2015\PrimeFactors::class)]
#[IgnoreClassForCodeCoverage(Aoc2015Day22::class)]
#[IgnoreClassForCodeCoverage(\TBali\Aoc2015\WizardGameState::class)]
#[IgnoreClassForCodeCoverage(\TBali\Aoc2015\WizardSimulator::class)]
#[IgnoreClassForCodeCoverage(\TBali\Aoc2015\WizardSimulatorHardMode::class)]
final class Aoc2015Test extends TestCase
{
    /**
     * @covers \TBali\Aoc2015\Aoc2015Day01
     */
    public function testDay01Example1(): void
    {
        $solver = new Aoc2015Day01();
        $input = [$solver::EXAMPLE_STRING_INPUTS[0]];
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::EXAMPLE_SOLUTIONS[0];
        self::assertSame(strval($expected1), $ans1);
        self::assertSame(strval($expected2), $ans2);
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
        // self::assertSame(strval($expected1), $ans1);
        self::assertSame(strval($expected2), $ans2);
    }

    /**
     * @covers \TBali\Aoc2015\Aoc2015Day01
     * @covers \TBali\Aoc\SolutionBase
     */
    public function testDay01(): void
    {
        $solver = new Aoc2015Day01();
        $input = $solver->readInput($solver->inputBaseFileName() . '.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::SOLUTIONS;
        self::assertSame(strval($expected1), $ans1);
        self::assertSame(strval($expected2), $ans2);
    }

    /**
     * @covers \TBali\Aoc2015\Aoc2015Day01
     * @covers \TBali\Aoc\SolutionBase
     */
    public function testDay01InvalidInputFile1(): void
    {
        $solver = new Aoc2015Day01();
        $this->expectException(\Exception::class);
        $input = $solver->readInput('input/2014/Aoc2014Day01.txt');
    }

    /**
     * @covers \TBali\Aoc2015\Aoc2015Day01
     * @covers \TBali\Aoc\SolutionBase
     */
    public function testDay01InvalidInputFile2(): void
    {
        $solver = new Aoc2015Day01();
        $this->expectException(\Exception::class);
        $input = $solver->readInput('tests/empty-input.txt');
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
        self::assertSame(strval($expected1), $ans1);
        self::assertSame(strval($expected2), $ans2);
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
        self::assertSame(strval($expected1), $ans1);
        self::assertSame(strval($expected2), $ans2);
    }

    /**
     * @covers \TBali\Aoc2015\Aoc2015Day02
     */
    public function testDay02(): void
    {
        $solver = new Aoc2015Day02();
        $input = $solver->readInput($solver->inputBaseFileName() . '.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::SOLUTIONS;
        self::assertSame(strval($expected1), $ans1);
        self::assertSame(strval($expected2), $ans2);
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
        self::assertSame(strval($expected1), $ans1);
        self::assertSame(strval($expected2), $ans2);
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
        self::assertSame(strval($expected1), $ans1);
        self::assertSame(strval($expected2), $ans2);
    }

    /**
     * @covers \TBali\Aoc2015\Aoc2015Day03
     */
    public function testDay03(): void
    {
        $solver = new Aoc2015Day03();
        $input = $solver->readInput($solver->inputBaseFileName() . '.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::SOLUTIONS;
        self::assertSame(strval($expected1), $ans1);
        self::assertSame(strval($expected2), $ans2);
    }

    // --------------------------------------------------------------------

    /**
     * @covers \TBali\Aoc2015\Aoc2015Day04
     *
     * @group large
     */
    public function testDay04Example1(): void
    {
        $solver = new Aoc2015Day04();
        $input = [$solver::EXAMPLE_STRING_INPUTS[0]];
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::EXAMPLE_SOLUTIONS[0];
        self::assertSame(strval($expected1), $ans1);
        // self::assertSame(strval($expected2), $ans2);
    }

    /**
     * @covers \TBali\Aoc2015\Aoc2015Day04
     *
     * @group large
     */
    public function testDay04Example2(): void
    {
        $solver = new Aoc2015Day04();
        $input = [$solver::EXAMPLE_STRING_INPUTS[1]];
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::EXAMPLE_SOLUTIONS[1];
        self::assertSame(strval($expected1), $ans1);
        // self::assertSame(strval($expected2), $ans2);
    }

    /**
     * @covers \TBali\Aoc2015\Aoc2015Day04
     *
     * @group medium
     */
    public function testDay04(): void
    {
        $solver = new Aoc2015Day04();
        $input = [$solver::STRING_INPUT];
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::SOLUTIONS;
        self::assertSame(strval($expected1), $ans1);
        self::assertSame(strval($expected2), $ans2);
    }

    // --------------------------------------------------------------------

    /**
     * @covers \TBali\Aoc2015\Aoc2015Day05
     */
    public function testDay05Example1(): void
    {
        $solver = new Aoc2015Day05();
        $input = $solver->readInput($solver->inputBaseFileName() . 'ex1.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::EXAMPLE_SOLUTIONS[0];
        self::assertSame(strval($expected1), $ans1);
        // self::assertSame(strval($expected2), $ans2);
    }

    /**
     * @covers \TBali\Aoc2015\Aoc2015Day05
     */
    public function testDay05Example2(): void
    {
        $solver = new Aoc2015Day05();
        $input = $solver->readInput($solver->inputBaseFileName() . 'ex2.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::EXAMPLE_SOLUTIONS[1];
        // self::assertSame(strval($expected1), $ans1);
        self::assertSame(strval($expected2), $ans2);
    }

    /**
     * @covers \TBali\Aoc2015\Aoc2015Day05
     */
    public function testDay05(): void
    {
        $solver = new Aoc2015Day05();
        $input = $solver->readInput($solver->inputBaseFileName() . '.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::SOLUTIONS;
        self::assertSame(strval($expected1), $ans1);
        self::assertSame(strval($expected2), $ans2);
    }

    // --------------------------------------------------------------------

    /**
     * @covers \TBali\Aoc2015\Aoc2015Day06
     * @covers \TBali\Aoc2015\Instruction
     *
     * @group large
     */
    public function testDay06Example1(): void
    {
        $solver = new Aoc2015Day06();
        $input = [$solver::EXAMPLE_STRING_INPUTS[0]];
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::EXAMPLE_SOLUTIONS[0];
        self::assertSame(strval($expected1), $ans1);
        self::assertSame(strval($expected2), $ans2);
    }

    /**
     * @covers \TBali\Aoc2015\Aoc2015Day06
     * @covers \TBali\Aoc2015\Instruction
     *
     * @group medium
     */
    public function testDay06Example2(): void
    {
        $solver = new Aoc2015Day06();
        $input = [$solver::EXAMPLE_STRING_INPUTS[1]];
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::EXAMPLE_SOLUTIONS[1];
        self::assertSame(strval($expected1), $ans1);
        self::assertSame(strval($expected2), $ans2);
    }

    /**
     * @covers \TBali\Aoc2015\Aoc2015Day06
     * @covers \TBali\Aoc2015\Instruction
     *
     * @group large
     */
    public function testDay06(): void
    {
        $solver = new Aoc2015Day06();
        $input = $solver->readInput($solver->inputBaseFileName() . '.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::SOLUTIONS;
        self::assertSame(strval($expected1), $ans1);
        self::assertSame(strval($expected2), $ans2);
    }

    /**
     * @covers \TBali\Aoc2015\Aoc2015Day06
     */
    public function testDay06InvalidInput1(): void
    {
        $solver = new Aoc2015Day06();
        $input = ['a'];
        $this->expectException(\Exception::class);
        [$ans1, $ans2] = $solver->solve($input);
    }

    /**
     * @covers \TBali\Aoc2015\Aoc2015Day06
     */
    public function testDay06InvalidInput2(): void
    {
        $solver = new Aoc2015Day06();
        $input = ['toggle 0,0'];
        $this->expectException(\Exception::class);
        [$ans1, $ans2] = $solver->solve($input);
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
        $input = $solver->readInput($solver->inputBaseFileName() . 'ex1.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::EXAMPLE_SOLUTIONS[0];
        self::assertSame(strval($expected1), $ans1);
        // self::assertSame(strval($expected2), $ans2);
    }

    /**
     * @covers \TBali\Aoc2015\Aoc2015Day07
     * @covers \TBali\Aoc2015\Circuit
     * @covers \TBali\Aoc2015\Gate
     */
    public function testDay07(): void
    {
        $solver = new Aoc2015Day07();
        $input = $solver->readInput($solver->inputBaseFileName() . '.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::SOLUTIONS;
        self::assertSame(strval($expected1), $ans1);
        self::assertSame(strval($expected2), $ans2);
    }

    /**
     * @covers \TBali\Aoc2015\Aoc2015Day07
     * @covers \TBali\Aoc2015\Circuit
     * @covers \TBali\Aoc2015\Gate
     */
    public function testDay07InvalidInput1(): void
    {
        $solver = new Aoc2015Day07();
        $input = ['a'];
        $this->expectException(\Exception::class);
        [$ans1, $ans2] = $solver->solve($input);
    }

    /**
     * @covers \TBali\Aoc2015\Aoc2015Day07
     * @covers \TBali\Aoc2015\Circuit
     * @covers \TBali\Aoc2015\Gate
     */
    public function testDay07InvalidInput2(): void
    {
        $solver = new Aoc2015Day07();
        $input = ['AND a -> b'];
        $this->expectException(\Exception::class);
        [$ans1, $ans2] = $solver->solve($input);
    }

    /**
     * @covers \TBali\Aoc2015\Aoc2015Day07
     * @covers \TBali\Aoc2015\Circuit
     * @covers \TBali\Aoc2015\Gate
     */
    public function testDay07InvalidInput3(): void
    {
        $solver = new Aoc2015Day07();
        $input = ['a AND b AND c -> d'];
        $this->expectException(\Exception::class);
        [$ans1, $ans2] = $solver->solve($input);
    }

    // --------------------------------------------------------------------

    /**
     * @covers \TBali\Aoc2015\Aoc2015Day08
     */
    public function testDay08Example1(): void
    {
        $solver = new Aoc2015Day08();
        $input = $solver->readInput($solver->inputBaseFileName() . 'ex1.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::EXAMPLE_SOLUTIONS[0];
        self::assertSame(strval($expected1), $ans1);
        self::assertSame(strval($expected2), $ans2);
    }

    /**
     * @covers \TBali\Aoc2015\Aoc2015Day08
     */
    public function testDay08(): void
    {
        $solver = new Aoc2015Day08();
        $input = $solver->readInput($solver->inputBaseFileName() . '.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::SOLUTIONS;
        self::assertSame(strval($expected1), $ans1);
        self::assertSame(strval($expected2), $ans2);
    }

    // --------------------------------------------------------------------

    /**
     * @covers \TBali\Aoc2015\Aoc2015Day09
     * @covers \TBali\Aoc2015\CityGraph
     */
    public function testDay09Example1(): void
    {
        $solver = new Aoc2015Day09();
        $input = $solver->readInput($solver->inputBaseFileName() . 'ex1.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::EXAMPLE_SOLUTIONS[0];
        self::assertSame(strval($expected1), $ans1);
        self::assertSame(strval($expected2), $ans2);
    }

    /**
     * @covers \TBali\Aoc2015\Aoc2015Day09
     * @covers \TBali\Aoc2015\CityGraph
     */
    public function testDay09(): void
    {
        $solver = new Aoc2015Day09();
        $input = $solver->readInput($solver->inputBaseFileName() . '.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::SOLUTIONS;
        self::assertSame(strval($expected1), $ans1);
        self::assertSame(strval($expected2), $ans2);
    }

    /**
     * @covers \TBali\Aoc2015\Aoc2015Day09
     * @covers \TBali\Aoc2015\CityGraph
     */
    public function testDay09InvalidInput1(): void
    {
        $solver = new Aoc2015Day09();
        $input = ['a'];
        $this->expectException(\Exception::class);
        [$ans1, $ans2] = $solver->solve($input);
    }

    /**
     * @covers \TBali\Aoc2015\Aoc2015Day09
     * @covers \TBali\Aoc2015\CityGraph
     */
    public function testDay09InvalidInput2(): void
    {
        $solver = new Aoc2015Day09();
        $input = ['a'];
        $this->expectException(\Exception::class);
        [$ans1, $ans2] = $solver->solve($input);
    }

    /**
     * @covers \TBali\Aoc2015\Aoc2015Day09
     * @covers \TBali\Aoc2015\CityGraph
     */
    public function testDay09InvalidInput3(): void
    {
        $solver = new Aoc2015Day09();
        $input = ['a = 1'];
        $this->expectException(\Exception::class);
        [$ans1, $ans2] = $solver->solve($input);
    }

    /**
     * @covers \TBali\Aoc2015\Aoc2015Day09
     * @covers \TBali\Aoc2015\CityGraph
     */
    public function testDay09InvalidInput4(): void
    {
        $solver = new Aoc2015Day09();
        $input = ['a to a = 1'];
        $this->expectException(\Exception::class);
        [$ans1, $ans2] = $solver->solve($input);
    }

    // --------------------------------------------------------------------

    /**
     * @covers \TBali\Aoc2015\Aoc2015Day10
     *
     * @group large
     */
    public function testDay10Example1(): void
    {
        $solver = new Aoc2015Day10();
        $input = [$solver::EXAMPLE_STRING_INPUTS[0]];
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::EXAMPLE_SOLUTIONS[0];
        self::assertSame(strval($expected1), $ans1);
        // self::assertSame(strval($expected2), $ans2);
    }

    /**
     * @covers \TBali\Aoc2015\Aoc2015Day10
     *
     * @group large
     */
    public function testDay10(): void
    {
        $solver = new Aoc2015Day10();
        $input = [$solver::STRING_INPUT];
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::SOLUTIONS;
        self::assertSame(strval($expected1), $ans1);
        self::assertSame(strval($expected2), $ans2);
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
        self::assertSame(strval($expected1), $ans1);
        // self::assertSame(strval($expected2), $ans2);
    }

    /**
     * @covers \TBali\Aoc2015\Aoc2015Day11
     *
     * @group large
     */
    public function testDay11(): void
    {
        $solver = new Aoc2015Day11();
        $input = [$solver::STRING_INPUT];
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::SOLUTIONS;
        self::assertSame(strval($expected1), $ans1);
        self::assertSame(strval($expected2), $ans2);
    }

    // --------------------------------------------------------------------

    /**
     * @covers \TBali\Aoc2015\Aoc2015Day12
     */
    public function testDay12Example1(): void
    {
        $solver = new Aoc2015Day12();
        $input = $solver->readInput($solver->inputBaseFileName() . 'ex1.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::EXAMPLE_SOLUTIONS[0];
        self::assertSame(strval($expected1), $ans1);
        // self::assertSame(strval($expected2), $ans2);
    }

    /**
     * @covers \TBali\Aoc2015\Aoc2015Day12
     */
    public function testDay12Example2(): void
    {
        $solver = new Aoc2015Day12();
        $input = $solver->readInput($solver->inputBaseFileName() . 'ex2.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::EXAMPLE_SOLUTIONS[1];
        // self::assertSame(strval($expected1), $ans1);
        self::assertSame(strval($expected2), $ans2);
    }

    /**
     * @covers \TBali\Aoc2015\Aoc2015Day12
     */
    public function testDay12(): void
    {
        $solver = new Aoc2015Day12();
        $input = $solver->readInput($solver->inputBaseFileName() . '.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::SOLUTIONS;
        self::assertSame(strval($expected1), $ans1);
        self::assertSame(strval($expected2), $ans2);
    }

    // --------------------------------------------------------------------

    /**
     * @covers \TBali\Aoc2015\Aoc2015Day13
     * @covers \TBali\Aoc2015\KnightsTable
     */
    public function testDay13Example1(): void
    {
        $solver = new Aoc2015Day13();
        $input = $solver->readInput($solver->inputBaseFileName() . 'ex1.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::EXAMPLE_SOLUTIONS[0];
        self::assertSame(strval($expected1), $ans1);
        // self::assertSame(strval($expected2), $ans2);
    }

    /**
     * @covers \TBali\Aoc2015\Aoc2015Day13
     * @covers \TBali\Aoc2015\KnightsTable
     *
     * @group large
     */
    public function testDay13(): void
    {
        $solver = new Aoc2015Day13();
        $input = $solver->readInput($solver->inputBaseFileName() . '.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::SOLUTIONS;
        self::assertSame(strval($expected1), $ans1);
        self::assertSame(strval($expected2), $ans2);
    }

    /**
     * @covers \TBali\Aoc2015\Aoc2015Day13
     * @covers \TBali\Aoc2015\KnightsTable
     */
    public function testDay13InvalidInput1(): void
    {
        $solver = new Aoc2015Day13();
        $input = ['A would gain 1 happiness units by sitting next to B a.'];
        $this->expectException(\Exception::class);
        [$ans1, $ans2] = $solver->solve($input);
    }

    /**
     * @covers \TBali\Aoc2015\Aoc2015Day13
     * @covers \TBali\Aoc2015\KnightsTable
     */
    public function testDay13InvalidInput2(): void
    {
        $solver = new Aoc2015Day13();
        $input = ['A would gain 1 happiness units by sitting next to A.'];
        $this->expectException(\Exception::class);
        [$ans1, $ans2] = $solver->solve($input);
    }

    /**
     * @covers \TBali\Aoc2015\Aoc2015Day13
     * @covers \TBali\Aoc2015\KnightsTable
     */
    public function testDay13InvalidInput3(): void
    {
        $solver = new Aoc2015Day13();
        $input = ['A would get 1 happiness units by sitting next to B.'];
        $this->expectException(\Exception::class);
        [$ans1, $ans2] = $solver->solve($input);
    }

    // --------------------------------------------------------------------

    /**
     * @covers \TBali\Aoc2015\Aoc2015Day14
     * @covers \TBali\Aoc2015\Reindeer
     */
    public function testDay14Example1(): void
    {
        $solver = new Aoc2015Day14();
        $input = $solver->readInput($solver->inputBaseFileName() . 'ex1.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::EXAMPLE_SOLUTIONS[0];
        self::assertSame(strval($expected1), $ans1);
        self::assertSame(strval($expected2), $ans2);
    }

    /**
     * @covers \TBali\Aoc2015\Aoc2015Day14
     * @covers \TBali\Aoc2015\Reindeer
     */
    public function testDay14(): void
    {
        $solver = new Aoc2015Day14();
        $input = $solver->readInput($solver->inputBaseFileName() . '.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::SOLUTIONS;
        self::assertSame(strval($expected1), $ans1);
        self::assertSame(strval($expected2), $ans2);
    }

    /**
     * @covers \TBali\Aoc2015\Aoc2015Day14
     * @covers \TBali\Aoc2015\Reindeer
     */
    public function testDay14InvalidInput1(): void
    {
        $solver = new Aoc2015Day14();
        $input = ['A can fly 1 km/s for 1 seconds, but then must rest for 1 seconds a.'];
        $this->expectException(\Exception::class);
        [$ans1, $ans2] = $solver->solve($input);
    }

    // --------------------------------------------------------------------

    /**
     * @covers \TBali\Aoc2015\Aoc2015Day15
     */
    public function testDay15Example1(): void
    {
        $solver = new Aoc2015Day15();
        $input = $solver->readInput($solver->inputBaseFileName() . 'ex1.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::EXAMPLE_SOLUTIONS[0];
        self::assertSame(strval($expected1), $ans1);
        self::assertSame(strval($expected2), $ans2);
    }

    /**
     * @covers \TBali\Aoc2015\Aoc2015Day15
     *
     * @group large
     */
    public function testDay15(): void
    {
        $solver = new Aoc2015Day15();
        $input = $solver->readInput($solver->inputBaseFileName() . '.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::SOLUTIONS;
        self::assertSame(strval($expected1), $ans1);
        self::assertSame(strval($expected2), $ans2);
    }

    /**
     * @covers \TBali\Aoc2015\Aoc2015Day15
     */
    public function testDay15InvalidInput1(): void
    {
        $solver = new Aoc2015Day15();
        $input = ['A: capacity 2, durability 0, flavor -2, texture 0, calories 3 a'];
        $this->expectException(\Exception::class);
        [$ans1, $ans2] = $solver->solve($input);
    }

    // --------------------------------------------------------------------

    /**
     * @covers \TBali\Aoc2015\Aoc2015Day16
     */
    public function testDay16(): void
    {
        $solver = new Aoc2015Day16();
        $input = $solver->readInput($solver->inputBaseFileName() . '.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::SOLUTIONS;
        self::assertSame(strval($expected1), $ans1);
        self::assertSame(strval($expected2), $ans2);
    }

    /**
     * @covers \TBali\Aoc2015\Aoc2015Day16
     */
    public function testDay16InvalidInput1(): void
    {
        $solver = new Aoc2015Day16();
        $input = ['A 1: a: 2, b: 3, c: 0 a'];
        $this->expectException(\Exception::class);
        [$ans1, $ans2] = $solver->solve($input);
    }

    // --------------------------------------------------------------------

    /**
     * @covers \TBali\Aoc2015\Aoc2015Day17
     */
    public function testDay17Example1(): void
    {
        $solver = new Aoc2015Day17();
        $input = $solver->readInput($solver->inputBaseFileName() . 'ex1.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::EXAMPLE_SOLUTIONS[0];
        self::assertSame(strval($expected1), $ans1);
        self::assertSame(strval($expected2), $ans2);
    }

    /**
     * @covers \TBali\Aoc2015\Aoc2015Day17
     *
     * @group large
     */
    public function testDay17(): void
    {
        $solver = new Aoc2015Day17();
        $input = $solver->readInput($solver->inputBaseFileName() . '.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::SOLUTIONS;
        self::assertSame(strval($expected1), $ans1);
        self::assertSame(strval($expected2), $ans2);
    }

    // --------------------------------------------------------------------

    /**
     * @covers \TBali\Aoc2015\Aoc2015Day18
     */
    public function testDay18Example1(): void
    {
        $solver = new Aoc2015Day18();
        $input = $solver->readInput($solver->inputBaseFileName() . 'ex1.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::EXAMPLE_SOLUTIONS[0];
        self::assertSame(strval($expected1), $ans1);
        self::assertSame(strval($expected2), $ans2);
    }

    /**
     * @covers \TBali\Aoc2015\Aoc2015Day18
     *
     * @group large
     */
    public function testDay18(): void
    {
        $solver = new Aoc2015Day18();
        $input = $solver->readInput($solver->inputBaseFileName() . '.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::SOLUTIONS;
        self::assertSame(strval($expected1), $ans1);
        self::assertSame(strval($expected2), $ans2);
    }

    // --------------------------------------------------------------------

    /**
     * @covers \TBali\Aoc2015\Aoc2015Day19
     */
    public function testDay19(): void
    {
        $solver = new Aoc2015Day19();
        $input = $solver->readInput($solver->inputBaseFileName() . '.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::SOLUTIONS;
        self::assertSame(strval($expected1), $ans1);
        self::assertSame(strval($expected2), $ans2);
    }

    /**
     * @covers \TBali\Aoc2015\Aoc2015Day19
     */
    public function testDay19InvalidInput1(): void
    {
        $solver = new Aoc2015Day19();
        $input = ['a'];
        $this->expectException(\Exception::class);
        [$ans1, $ans2] = $solver->solve($input);
    }

    /**
     * @covers \TBali\Aoc2015\Aoc2015Day19
     */
    public function testDay19InvalidInput2(): void
    {
        $solver = new Aoc2015Day19();
        $input = ['a', '', 'a'];
        $this->expectException(\Exception::class);
        [$ans1, $ans2] = $solver->solve($input);
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
        self::assertSame(strval($expected1), $ans1);
        // self::assertSame(strval($expected2), $ans2);
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
        self::assertSame(strval($expected1), $ans1);
        // self::assertSame(strval($expected2), $ans2);
    }

    /**
     * @covers \TBali\Aoc2015\Aoc2015Day20
     *
     * @group large
     */
    public function testDay20(): void
    {
        $solver = new Aoc2015Day20();
        $input = [$solver::STRING_INPUT];
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::SOLUTIONS;
        self::assertSame(strval($expected1), $ans1);
        self::assertSame(strval($expected2), $ans2);
    }

    // --------------------------------------------------------------------

    /**
     * @covers \TBali\Aoc2015\Aoc2015Day21
     * @covers \TBali\Aoc2015\Character
     */
    public function testDay21(): void
    {
        $solver = new Aoc2015Day21();
        $input = $solver->readInput($solver->inputBaseFileName() . '.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::SOLUTIONS;
        self::assertSame(strval($expected1), $ans1);
        self::assertSame(strval($expected2), $ans2);
    }

    /**
     * @covers \TBali\Aoc2015\Aoc2015Day21
     * @covers \TBali\Aoc2015\Character
     */
    public function testDay21InvalidInput1(): void
    {
        $solver = new Aoc2015Day21();
        $input = ['Hit Points 1'];
        $this->expectException(\Exception::class);
        [$ans1, $ans2] = $solver->solve($input);
    }

    // --------------------------------------------------------------------

    /**
     * @covers \TBali\Aoc2015\Aoc2015Day22
     * @covers \TBali\Aoc2015\WizardGameState
     * @covers \TBali\Aoc2015\WizardSimulator
     * @covers \TBali\Aoc2015\WizardSimulatorHardMode
     *
     * @group large
     */
    public function testDay22(): void
    {
        $solver = new Aoc2015Day22();
        $input = $solver->readInput($solver->inputBaseFileName() . '.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::SOLUTIONS;
        self::assertSame(strval($expected1), $ans1);
        self::assertSame(strval($expected2), $ans2);
    }

    /**
     * @covers \TBali\Aoc2015\Aoc2015Day22
     * @covers \TBali\Aoc2015\WizardGameState
     * @covers \TBali\Aoc2015\WizardSimulator
     * @covers \TBali\Aoc2015\WizardSimulatorHardMode
     */
    public function testDay22InvalidInput1(): void
    {
        $solver = new Aoc2015Day22();
        $input = ['Hit Points 1'];
        $this->expectException(\Exception::class);
        [$ans1, $ans2] = $solver->solve($input);
    }

    // --------------------------------------------------------------------

    /**
     * @covers \TBali\Aoc2015\Aoc2015Day23
     */
    public function testDay23Example1(): void
    {
        $solver = new Aoc2015Day23();
        $input = $solver->readInput($solver->inputBaseFileName() . 'ex1.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::EXAMPLE_SOLUTIONS[0];
        self::assertSame(strval($expected1), $ans1);
        self::assertSame(strval($expected2), $ans2);
    }

    /**
     * @covers \TBali\Aoc2015\Aoc2015Day23
     */
    public function testDay23(): void
    {
        $solver = new Aoc2015Day23();
        $input = $solver->readInput($solver->inputBaseFileName() . '.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::SOLUTIONS;
        self::assertSame(strval($expected1), $ans1);
        self::assertSame(strval($expected2), $ans2);
    }

    /**
     * @covers \TBali\Aoc2015\Aoc2015Day23
     */
    public function testDay23InvalidInput1(): void
    {
        $solver = new Aoc2015Day23();
        $input = ['div a'];
        $this->expectException(\Exception::class);
        [$ans1, $ans2] = $solver->solve($input);
    }

    // --------------------------------------------------------------------

    /**
     * @covers \TBali\Aoc2015\Aoc2015Day24
     */
    public function testDay24Example1(): void
    {
        $solver = new Aoc2015Day24();
        $input = $solver->readInput($solver->inputBaseFileName() . 'ex1.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::EXAMPLE_SOLUTIONS[0];
        self::assertSame(strval($expected1), $ans1);
        self::assertSame(strval($expected2), $ans2);
    }

    /**
     * @covers \TBali\Aoc2015\Aoc2015Day24
     *
     * @group large
     */
    public function testDay24(): void
    {
        $solver = new Aoc2015Day24();
        $input = $solver->readInput($solver->inputBaseFileName() . '.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::SOLUTIONS;
        self::assertSame(strval($expected1), $ans1);
        self::assertSame(strval($expected2), $ans2);
    }

    // --------------------------------------------------------------------

    /**
     * @covers \TBali\Aoc2015\Aoc2015Day25
     */
    public function testDay25Example1(): void
    {
        $solver = new Aoc2015Day25();
        $input = $solver->readInput($solver->inputBaseFileName() . 'ex1.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::EXAMPLE_SOLUTIONS[0];
        self::assertSame(strval($expected1), $ans1);
        // self::assertSame(strval($expected2), $ans2);
    }

    /**
     * @covers \TBali\Aoc2015\Aoc2015Day25
     */
    public function testDay25Example2(): void
    {
        $solver = new Aoc2015Day25();
        $input = $solver->readInput($solver->inputBaseFileName() . 'ex2.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::EXAMPLE_SOLUTIONS[1];
        self::assertSame(strval($expected1), $ans1);
        // self::assertSame(strval($expected2), $ans2);
    }

    /**
     * @covers \TBali\Aoc2015\Aoc2015Day25
     *
     * @group large
     */
    public function testDay25(): void
    {
        $solver = new Aoc2015Day25();
        $input = $solver->readInput($solver->inputBaseFileName() . '.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::SOLUTIONS;
        self::assertSame(strval($expected1), $ans1);
        // self::assertSame(strval($expected2), $ans2);
    }

    /**
     * @covers \TBali\Aoc2015\Aoc2015Day25
     */
    public function testDay25InvalidInput1(): void
    {
        $solver = new Aoc2015Day25();
        $input = ['To continue, please consult the code grid in the manual.  Enter the code at row 1, column 1 a.'];
        $this->expectException(\Exception::class);
        [$ans1, $ans2] = $solver->solve($input);
    }
}
