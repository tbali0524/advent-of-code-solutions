<?php

declare(strict_types=1);

namespace TBali\Tests;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\Attributes\RequiresPhp;
use PHPUnit\Framework\Attributes\RequiresPhpunit;
use PHPUnit\Framework\TestCase;
use TBali\Aoc2023\Aoc2023Day01;
use TBali\Aoc2023\Aoc2023Day02;
use TBali\Aoc2023\Aoc2023Day03;
use TBali\Aoc2023\Aoc2023Day04;
use TBali\Aoc2023\Aoc2023Day05;
use TBali\Aoc2023\Aoc2023Day06;
use TBali\Aoc2023\Aoc2023Day07;
use TBali\Aoc2023\Aoc2023Day08;
use TBali\Aoc2023\Aoc2023Day09;
use TBali\Aoc2023\Aoc2023Day10;
use TBali\Aoc2023\Aoc2023Day11;
use TBali\Aoc2023\Aoc2023Day12;
use TBali\Aoc2023\Aoc2023Day13;
use TBali\Aoc2023\Aoc2023Day14;
use TBali\Aoc2023\Aoc2023Day15;
use TBali\Aoc2023\Aoc2023Day16;
use TBali\Aoc2023\Aoc2023Day17;
use TBali\Aoc2023\Aoc2023Day18;
use TBali\Aoc2023\Aoc2023Day19;
use TBali\Aoc2023\Aoc2023Day20;
use TBali\Aoc2023\Aoc2023Day21;
use TBali\Aoc2023\Aoc2023Day22;
use TBali\Aoc2023\Aoc2023Day23;
use TBali\Aoc2023\Aoc2023Day24;
use TBali\Aoc2023\Aoc2023Day25;
use TBali\Aoc2023\Area;
use TBali\Aoc2023\Brick;
use TBali\Aoc2023\Broadcast;
use TBali\Aoc2023\CamelHand;
use TBali\Aoc2023\Circuit;
use TBali\Aoc2023\Conjunction;
use TBali\Aoc2023\FlipFlop;
use TBali\Aoc2023\Hailstone;
use TBali\Aoc2023\Hand;
use TBali\Aoc2023\JokerHand;
use TBali\Aoc2023\MinPriorityQueue;
use TBali\Aoc2023\MinPriorityQueueDay20;
use TBali\Aoc2023\Module;
use TBali\Aoc2023\Part;
use TBali\Aoc2023\PartRange;
use TBali\Aoc2023\Pattern;
use TBali\Aoc2023\Workflow;

/**
 * Unit tests for Advent of Code season 2023.
 *
 * Instead of using this file with phpunit, it is a better way to run the solutions by using AoCRunner.
 *
 * @internal
 *
 * @coversNothing
 */
#[RequiresPhp('^8.4')]
#[RequiresPhpunit('^12.1')]
#[CoversClass(Aoc2023Day01::class)]
#[CoversClass(Aoc2023Day02::class)]
#[CoversClass(Aoc2023Day03::class)]
#[CoversClass(Aoc2023Day04::class)]
#[CoversClass(Aoc2023Day05::class)]
#[CoversClass(Aoc2023Day06::class)]
#[CoversClass(Aoc2023Day07::class)]
#[CoversClass(Aoc2023Day08::class)]
#[CoversClass(Aoc2023Day09::class)]
#[CoversClass(Aoc2023Day10::class)]
#[CoversClass(Aoc2023Day11::class)]
#[CoversClass(Aoc2023Day12::class)]
#[CoversClass(Aoc2023Day13::class)]
#[CoversClass(Aoc2023Day14::class)]
#[CoversClass(Aoc2023Day15::class)]
#[CoversClass(Aoc2023Day16::class)]
#[CoversClass(Aoc2023Day17::class)]
#[CoversClass(Aoc2023Day18::class)]
#[CoversClass(Aoc2023Day19::class)]
#[CoversClass(Aoc2023Day20::class)]
#[CoversClass(Aoc2023Day21::class)]
#[CoversClass(Aoc2023Day22::class)]
#[CoversClass(Aoc2023Day23::class)]
#[CoversClass(Aoc2023Day24::class)]
#[CoversClass(Aoc2023Day25::class)]
#[CoversClass(Area::class)]
#[CoversClass(Brick::class)]
#[CoversClass(Broadcast::class)]
#[CoversClass(CamelHand::class)]
#[CoversClass(Circuit::class)]
#[CoversClass(Conjunction::class)]
#[CoversClass(FlipFlop::class)]
#[CoversClass(Hailstone::class)]
#[CoversClass(Hand::class)]
#[CoversClass(JokerHand::class)]
#[CoversClass(MinPriorityQueue::class)]
#[CoversClass(MinPriorityQueueDay20::class)]
#[CoversClass(Module::class)]
#[CoversClass(Part::class)]
#[CoversClass(PartRange::class)]
#[CoversClass(Pattern::class)]
#[CoversClass(Workflow::class)]
final class Aoc2023Test extends TestCase
{
    // --------------------------------------------------------------------

    public function testDay01Example1(): void
    {
        $solver = new Aoc2023Day01();
        $input = $solver->readInput($solver->inputBaseFileName() . 'ex1.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::EXAMPLE_SOLUTIONS[0];
        self::assertSame(strval($expected1), $ans1);
        // self::assertSame(strval($expected2), $ans2);
    }

    public function testDay01Example2(): void
    {
        $solver = new Aoc2023Day01();
        $input = $solver->readInput($solver->inputBaseFileName() . 'ex2.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::EXAMPLE_SOLUTIONS[1];
        // self::assertSame(strval($expected1), $ans1);
        self::assertSame(strval($expected2), $ans2);
    }

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

    public function testDay02Example1(): void
    {
        $solver = new Aoc2023Day02();
        $input = $solver->readInput($solver->inputBaseFileName() . 'ex1.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::EXAMPLE_SOLUTIONS[0];
        self::assertSame(strval($expected1), $ans1);
        self::assertSame(strval($expected2), $ans2);
    }

    public function testDay02(): void
    {
        $solver = new Aoc2023Day02();
        $input = $solver->readInput($solver->inputBaseFileName() . '.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::SOLUTIONS;
        self::assertSame(strval($expected1), $ans1);
        self::assertSame(strval($expected2), $ans2);
    }

    public function testDay02InvalidInput1(): void
    {
        $solver = new Aoc2023Day02();
        $input = ['Game 1'];
        $this->expectException(\Exception::class);
        [$ans1, $ans2] = $solver->solve($input);
    }

    public function testDay02InvalidInput2(): void
    {
        $solver = new Aoc2023Day02();
        $input = ['Game 1: 1 Blue, 2 Yellow'];
        $this->expectException(\Exception::class);
        [$ans1, $ans2] = $solver->solve($input);
    }

    // --------------------------------------------------------------------

    public function testDay03Example1(): void
    {
        $solver = new Aoc2023Day03();
        $input = $solver->readInput($solver->inputBaseFileName() . 'ex1.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::EXAMPLE_SOLUTIONS[0];
        self::assertSame(strval($expected1), $ans1);
        self::assertSame(strval($expected2), $ans2);
    }

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

    public function testDay04Example1(): void
    {
        $solver = new Aoc2023Day04();
        $input = $solver->readInput($solver->inputBaseFileName() . 'ex1.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::EXAMPLE_SOLUTIONS[0];
        self::assertSame(strval($expected1), $ans1);
        self::assertSame(strval($expected2), $ans2);
    }

    public function testDay04(): void
    {
        $solver = new Aoc2023Day04();
        $input = $solver->readInput($solver->inputBaseFileName() . '.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::SOLUTIONS;
        self::assertSame(strval($expected1), $ans1);
        self::assertSame(strval($expected2), $ans2);
    }

    public function testDay04InvalidInput1(): void
    {
        $solver = new Aoc2023Day04();
        $input = ['a'];
        $this->expectException(\Exception::class);
        [$ans1, $ans2] = $solver->solve($input);
    }

    public function testDay04InvalidInput2(): void
    {
        $solver = new Aoc2023Day04();
        $input = ['Card 1: 2'];
        $this->expectException(\Exception::class);
        [$ans1, $ans2] = $solver->solve($input);
    }

    // --------------------------------------------------------------------

    public function testDay05Example1(): void
    {
        $solver = new Aoc2023Day05();
        $input = $solver->readInput($solver->inputBaseFileName() . 'ex1.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::EXAMPLE_SOLUTIONS[0];
        self::assertSame(strval($expected1), $ans1);
        self::assertSame(strval($expected2), $ans2);
    }

    public function testDay05(): void
    {
        $solver = new Aoc2023Day05();
        $input = $solver->readInput($solver->inputBaseFileName() . '.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::SOLUTIONS;
        self::assertSame(strval($expected1), $ans1);
        self::assertSame(strval($expected2), $ans2);
    }

    public function testDay05InvalidInput1(): void
    {
        $solver = new Aoc2023Day05();
        $input = ['a'];
        $this->expectException(\Exception::class);
        [$ans1, $ans2] = $solver->solve($input);
    }

    public function testDay05InvalidInput2(): void
    {
        $solver = new Aoc2023Day05();
        $input = ['seeds: 1', '', 'a', '0 1 2'];
        $this->expectException(\Exception::class);
        [$ans1, $ans2] = $solver->solve($input);
    }

    public function testDay05InvalidInput3(): void
    {
        $solver = new Aoc2023Day05();
        $input = ['seeds: 1', '', 'seed-to-soil map:', '0 1'];
        $this->expectException(\Exception::class);
        [$ans1, $ans2] = $solver->solve($input);
    }

    // --------------------------------------------------------------------

    public function testDay06Example1(): void
    {
        $solver = new Aoc2023Day06();
        $input = $solver->readInput($solver->inputBaseFileName() . 'ex1.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::EXAMPLE_SOLUTIONS[0];
        self::assertSame(strval($expected1), $ans1);
        self::assertSame(strval($expected2), $ans2);
    }

    public function testDay06(): void
    {
        $solver = new Aoc2023Day06();
        $input = $solver->readInput($solver->inputBaseFileName() . '.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::SOLUTIONS;
        self::assertSame(strval($expected1), $ans1);
        self::assertSame(strval($expected2), $ans2);
    }

    public function testDay06InvalidInput1(): void
    {
        $solver = new Aoc2023Day06();
        $input = ['a'];
        $this->expectException(\Exception::class);
        [$ans1, $ans2] = $solver->solve($input);
    }

    public function testDay06InvalidInput2(): void
    {
        $solver = new Aoc2023Day06();
        $input = ['Time:      1', 'Distance:  1 1'];
        $this->expectException(\Exception::class);
        [$ans1, $ans2] = $solver->solve($input);
    }

    // --------------------------------------------------------------------

    public function testDay07Example1(): void
    {
        $solver = new Aoc2023Day07();
        $input = $solver->readInput($solver->inputBaseFileName() . 'ex1.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::EXAMPLE_SOLUTIONS[0];
        self::assertSame(strval($expected1), $ans1);
        self::assertSame(strval($expected2), $ans2);
    }

    public function testDay07(): void
    {
        $solver = new Aoc2023Day07();
        $input = $solver->readInput($solver->inputBaseFileName() . '.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::SOLUTIONS;
        self::assertSame(strval($expected1), $ans1);
        self::assertSame(strval($expected2), $ans2);
    }

    public function testDay07InvalidInput1(): void
    {
        $solver = new Aoc2023Day07();
        $input = ['a'];
        $this->expectException(\Exception::class);
        [$ans1, $ans2] = $solver->solve($input);
    }

    public function testDay07InvalidInput2(): void
    {
        $solver = new Aoc2023Day07();
        $input = ['234567 1'];
        $this->expectException(\Exception::class);
        [$ans1, $ans2] = $solver->solve($input);
    }

    public function testDay07InvalidInput3(): void
    {
        $solver = new Aoc2023Day07();
        $input = ['12345 1'];
        $this->expectException(\Exception::class);
        [$ans1, $ans2] = $solver->solve($input);
    }

    // --------------------------------------------------------------------

    public function testDay08Example1(): void
    {
        $solver = new Aoc2023Day08();
        $input = $solver->readInput($solver->inputBaseFileName() . 'ex1.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::EXAMPLE_SOLUTIONS[0];
        self::assertSame(strval($expected1), $ans1);
        self::assertSame(strval($expected2), $ans2);
    }

    public function testDay08(): void
    {
        $solver = new Aoc2023Day08();
        $input = $solver->readInput($solver->inputBaseFileName() . '.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::SOLUTIONS;
        self::assertSame(strval($expected1), $ans1);
        self::assertSame(strval($expected2), $ans2);
    }

    public function testDay08InvalidInput1(): void
    {
        $solver = new Aoc2023Day08();
        $input = ['a'];
        $this->expectException(\Exception::class);
        [$ans1, $ans2] = $solver->solve($input);
    }

    public function testDay08InvalidInput2(): void
    {
        $solver = new Aoc2023Day08();
        $input = ['RL', '', 'AAA = (BBB, CCC'];
        $this->expectException(\Exception::class);
        [$ans1, $ans2] = $solver->solve($input);
    }

    public function testDay08InvalidInput3(): void
    {
        $solver = new Aoc2023Day08();
        $input = ['RL', '', 'AAA = (BBB, CCC, DDD)'];
        $this->expectException(\Exception::class);
        [$ans1, $ans2] = $solver->solve($input);
    }

    public function testDay08InvalidInput4(): void
    {
        $solver = new Aoc2023Day08();
        $input = ['RLC', '', 'AAA = (BBB, CCC)'];
        $this->expectException(\Exception::class);
        [$ans1, $ans2] = $solver->solve($input);
    }

    public function testDay08InvalidInput5(): void
    {
        $solver = new Aoc2023Day08();
        $input = ['RL', '', 'AAA = (BBB, CCC)'];
        $this->expectException(\Exception::class);
        [$ans1, $ans2] = $solver->solve($input);
    }

    // --------------------------------------------------------------------

    public function testDay09Example1(): void
    {
        $solver = new Aoc2023Day09();
        $input = $solver->readInput($solver->inputBaseFileName() . 'ex1.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::EXAMPLE_SOLUTIONS[0];
        self::assertSame(strval($expected1), $ans1);
        self::assertSame(strval($expected2), $ans2);
    }

    public function testDay09(): void
    {
        $solver = new Aoc2023Day09();
        $input = $solver->readInput($solver->inputBaseFileName() . '.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::SOLUTIONS;
        self::assertSame(strval($expected1), $ans1);
        self::assertSame(strval($expected2), $ans2);
    }

    // --------------------------------------------------------------------

    public function testDay10Example1(): void
    {
        $solver = new Aoc2023Day10();
        $input = $solver->readInput($solver->inputBaseFileName() . 'ex1.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::EXAMPLE_SOLUTIONS[0];
        self::assertSame(strval($expected1), $ans1);
        self::assertSame(strval($expected2), $ans2);
    }

    public function testDay10(): void
    {
        $solver = new Aoc2023Day10();
        $input = $solver->readInput($solver->inputBaseFileName() . '.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::SOLUTIONS;
        self::assertSame(strval($expected1), $ans1);
        self::assertSame(strval($expected2), $ans2);
    }

    public function testDay10InvalidInput1(): void
    {
        $solver = new Aoc2023Day10();
        $input = ['A'];
        $this->expectException(\Exception::class);
        [$ans1, $ans2] = $solver->solve($input);
    }

    public function testDay10InvalidInput2(): void
    {
        $solver = new Aoc2023Day10();
        $input = ['F-7', '|.|', 'L-J'];
        $this->expectException(\Exception::class);
        [$ans1, $ans2] = $solver->solve($input);
    }

    public function testDay10InvalidInput3(): void
    {
        $solver = new Aoc2023Day10();
        $input = ['.SL'];
        $this->expectException(\Exception::class);
        [$ans1, $ans2] = $solver->solve($input);
    }

    public function testDay10InvalidInput4(): void
    {
        $solver = new Aoc2023Day10();
        $input = ['FS7'];
        $this->expectException(\Exception::class);
        [$ans1, $ans2] = $solver->solve($input);
    }

    public function testDay10InvalidInput5(): void
    {
        $solver = new Aoc2023Day10();
        $input = ['FS7', '|F|', 'LLJ'];
        $this->expectException(\Exception::class);
        [$ans1, $ans2] = $solver->solve($input);
    }

    // --------------------------------------------------------------------

    public function testDay11Example1(): void
    {
        $solver = new Aoc2023Day11();
        $input = $solver->readInput($solver->inputBaseFileName() . 'ex1.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::EXAMPLE_SOLUTIONS[0];
        self::assertSame(strval($expected1), $ans1);
        self::assertSame(strval($expected2), $ans2);
    }

    #[Group('medium-slow')]
    public function testDay11(): void
    {
        $solver = new Aoc2023Day11();
        $input = $solver->readInput($solver->inputBaseFileName() . '.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::SOLUTIONS;
        self::assertSame(strval($expected1), $ans1);
        self::assertSame(strval($expected2), $ans2);
    }

    // --------------------------------------------------------------------

    public function testDay12Example1(): void
    {
        $solver = new Aoc2023Day12();
        $input = $solver->readInput($solver->inputBaseFileName() . 'ex1.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::EXAMPLE_SOLUTIONS[0];
        self::assertSame(strval($expected1), $ans1);
        self::assertSame(strval($expected2), $ans2);
    }

    #[Group('medium-slow')]
    public function testDay12(): void
    {
        $solver = new Aoc2023Day12();
        $input = $solver->readInput($solver->inputBaseFileName() . '.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::SOLUTIONS;
        self::assertSame(strval($expected1), $ans1);
        self::assertSame(strval($expected2), $ans2);
    }

    public function testDay12InvalidInput1(): void
    {
        $solver = new Aoc2023Day12();
        $input = ['a'];
        $this->expectException(\Exception::class);
        [$ans1, $ans2] = $solver->solve($input);
    }

    // --------------------------------------------------------------------

    public function testDay13Example1(): void
    {
        $solver = new Aoc2023Day13();
        $input = $solver->readInput($solver->inputBaseFileName() . 'ex1.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::EXAMPLE_SOLUTIONS[0];
        self::assertSame(strval($expected1), $ans1);
        self::assertSame(strval($expected2), $ans2);
    }

    public function testDay13(): void
    {
        $solver = new Aoc2023Day13();
        $input = $solver->readInput($solver->inputBaseFileName() . '.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::SOLUTIONS;
        self::assertSame(strval($expected1), $ans1);
        self::assertSame(strval($expected2), $ans2);
    }

    public function testDay13InvalidInput1(): void
    {
        $solver = new Aoc2023Day13();
        $input = ['a'];
        $this->expectException(\Exception::class);
        [$ans1, $ans2] = $solver->solve($input);
    }

    // --------------------------------------------------------------------

    public function testDay14Example1(): void
    {
        $solver = new Aoc2023Day14();
        $input = $solver->readInput($solver->inputBaseFileName() . 'ex1.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::EXAMPLE_SOLUTIONS[0];
        self::assertSame(strval($expected1), $ans1);
        self::assertSame(strval($expected2), $ans2);
    }

    #[Group('slow')]
    public function testDay14(): void
    {
        $solver = new Aoc2023Day14();
        $input = $solver->readInput($solver->inputBaseFileName() . '.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::SOLUTIONS;
        self::assertSame(strval($expected1), $ans1);
        self::assertSame(strval($expected2), $ans2);
    }

    public function testDay14InvalidInput1(): void
    {
        $solver = new Aoc2023Day14();
        $input = ['a'];
        $this->expectException(\Exception::class);
        [$ans1, $ans2] = $solver->solve($input);
    }

    // --------------------------------------------------------------------

    public function testDay15Example1(): void
    {
        $solver = new Aoc2023Day15();
        $input = $solver->readInput($solver->inputBaseFileName() . 'ex1.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::EXAMPLE_SOLUTIONS[0];
        self::assertSame(strval($expected1), $ans1);
        self::assertSame(strval($expected2), $ans2);
    }

    public function testDay15(): void
    {
        $solver = new Aoc2023Day15();
        $input = $solver->readInput($solver->inputBaseFileName() . '.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::SOLUTIONS;
        self::assertSame(strval($expected1), $ans1);
        self::assertSame(strval($expected2), $ans2);
    }

    public function testDay15InvalidInput1(): void
    {
        $solver = new Aoc2023Day15();
        $input = ['a'];
        $this->expectException(\Exception::class);
        [$ans1, $ans2] = $solver->solve($input);
    }

    // --------------------------------------------------------------------

    public function testDay16Example1(): void
    {
        $solver = new Aoc2023Day16();
        $input = $solver->readInput($solver->inputBaseFileName() . 'ex1.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::EXAMPLE_SOLUTIONS[0];
        self::assertSame(strval($expected1), $ans1);
        self::assertSame(strval($expected2), $ans2);
    }

    #[Group('slow')]
    public function testDay16(): void
    {
        $solver = new Aoc2023Day16();
        $input = $solver->readInput($solver->inputBaseFileName() . '.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::SOLUTIONS;
        self::assertSame(strval($expected1), $ans1);
        self::assertSame(strval($expected2), $ans2);
    }

    public function testDay16InvalidInput1(): void
    {
        $solver = new Aoc2023Day16();
        $input = ['a'];
        $this->expectException(\Exception::class);
        [$ans1, $ans2] = $solver->solve($input);
    }

    // --------------------------------------------------------------------

    public function testDay17Example1(): void
    {
        $solver = new Aoc2023Day17();
        $input = $solver->readInput($solver->inputBaseFileName() . 'ex1.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::EXAMPLE_SOLUTIONS[0];
        self::assertSame(strval($expected1), $ans1);
        self::assertSame(strval($expected2), $ans2);
    }

    public function testDay17Example2(): void
    {
        $solver = new Aoc2023Day17();
        $input = $solver->readInput($solver->inputBaseFileName() . 'ex2.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::EXAMPLE_SOLUTIONS[1];
        // self::assertSame(strval($expected1), $ans1);
        self::assertSame(strval($expected2), $ans2);
    }

    #[Group('slow')]
    public function testDay17(): void
    {
        $solver = new Aoc2023Day17();
        $input = $solver->readInput($solver->inputBaseFileName() . '.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::SOLUTIONS;
        self::assertSame(strval($expected1), $ans1);
        self::assertSame(strval($expected2), $ans2);
    }

    // --------------------------------------------------------------------

    public function testDay18Example1(): void
    {
        $solver = new Aoc2023Day18();
        $input = $solver->readInput($solver->inputBaseFileName() . 'ex1.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::EXAMPLE_SOLUTIONS[0];
        self::assertSame(strval($expected1), $ans1);
        self::assertSame(strval($expected2), $ans2);
    }

    #[Group('medium-slow')]
    public function testDay18(): void
    {
        $solver = new Aoc2023Day18();
        $input = $solver->readInput($solver->inputBaseFileName() . '.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::SOLUTIONS;
        self::assertSame(strval($expected1), $ans1);
        self::assertSame(strval($expected2), $ans2);
    }

    public function testDay18InvalidInput1(): void
    {
        $solver = new Aoc2023Day18();
        $input = ['a'];
        $this->expectException(\Exception::class);
        [$ans1, $ans2] = $solver->solve($input);
    }

    // --------------------------------------------------------------------

    public function testDay19Example1(): void
    {
        $solver = new Aoc2023Day19();
        $input = $solver->readInput($solver->inputBaseFileName() . 'ex1.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::EXAMPLE_SOLUTIONS[0];
        self::assertSame(strval($expected1), $ans1);
        self::assertSame(strval($expected2), $ans2);
    }

    public function testDay19(): void
    {
        $solver = new Aoc2023Day19();
        $input = $solver->readInput($solver->inputBaseFileName() . '.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::SOLUTIONS;
        self::assertSame(strval($expected1), $ans1);
        self::assertSame(strval($expected2), $ans2);
    }

    public function testDay19InvalidInput1(): void
    {
        $solver = new Aoc2023Day19();
        $input = ['a'];
        $this->expectException(\Exception::class);
        [$ans1, $ans2] = $solver->solve($input);
    }

    public function testDay19InvalidInput2(): void
    {
        $solver = new Aoc2023Day19();
        $input = ['px{z>1:A,A}'];
        $this->expectException(\Exception::class);
        [$ans1, $ans2] = $solver->solve($input);
    }

    public function testDay19InvalidInput3(): void
    {
        $solver = new Aoc2023Day19();
        $input = ['in{a<20:out,m>291:A}'];
        $this->expectException(\Exception::class);
        [$ans1, $ans2] = $solver->solve($input);
    }

    public function testDay19InvalidInput4(): void
    {
        $solver = new Aoc2023Day19();
        $input = ['in{a<20:out,m>291:A}', '', '{x=1,m=2,a=3,z=4}'];
        $this->expectException(\Exception::class);
        [$ans1, $ans2] = $solver->solve($input);
    }

    public function testDay19InvalidInput5(): void
    {
        $solver = new Aoc2023Day19();
        $input = ['out{a<20:out,m>291:A}', '', '{x=1,m=2,a=3,s=4}'];
        $this->expectException(\Exception::class);
        [$ans1, $ans2] = $solver->solve($input);
    }

    // --------------------------------------------------------------------

    public function testDay20Example1(): void
    {
        $solver = new Aoc2023Day20();
        $input = $solver->readInput($solver->inputBaseFileName() . 'ex1.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::EXAMPLE_SOLUTIONS[0];
        self::assertSame(strval($expected1), $ans1);
        // self::assertSame(strval($expected2), $ans2);
    }

    public function testDay20Example2(): void
    {
        $solver = new Aoc2023Day20();
        $input = $solver->readInput($solver->inputBaseFileName() . 'ex2.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::EXAMPLE_SOLUTIONS[1];
        self::assertSame(strval($expected1), $ans1);
        // self::assertSame(strval($expected2), $ans2);
    }

    #[Group('medium-slow')]
    public function testDay20(): void
    {
        $solver = new Aoc2023Day20();
        $input = $solver->readInput($solver->inputBaseFileName() . '.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::SOLUTIONS;
        self::assertSame(strval($expected1), $ans1);
        self::assertSame(strval($expected2), $ans2);
    }

    public function testDay20InvalidInput1(): void
    {
        $solver = new Aoc2023Day20();
        $input = ['a'];
        $this->expectException(\Exception::class);
        [$ans1, $ans2] = $solver->solve($input);
    }

    public function testDay20InvalidInput2(): void
    {
        $solver = new Aoc2023Day20();
        $input = ['%a'];
        $this->expectException(\Exception::class);
        [$ans1, $ans2] = $solver->solve($input);
    }

    // --------------------------------------------------------------------

    public function testDay21Example1(): void
    {
        $solver = new Aoc2023Day21();
        $input = $solver->readInput($solver->inputBaseFileName() . 'ex1.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::EXAMPLE_SOLUTIONS[0];
        self::assertSame(strval($expected1), $ans1);
        // self::assertSame(strval($expected2), $ans2);
    }

    #[Group('slow')]
    public function testDay21(): void
    {
        $solver = new Aoc2023Day21();
        $input = $solver->readInput($solver->inputBaseFileName() . '.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::SOLUTIONS;
        self::assertSame(strval($expected1), $ans1);
        self::assertSame(strval($expected2), $ans2);
    }

    public function testDay21InvalidInput1(): void
    {
        $solver = new Aoc2023Day21();
        $input = ['a'];
        $this->expectException(\Exception::class);
        [$ans1, $ans2] = $solver->solve($input);
    }

    public function testDay21InvalidInput2(): void
    {
        $solver = new Aoc2023Day21();
        $input = ['.#', '..'];
        $this->expectException(\Exception::class);
        [$ans1, $ans2] = $solver->solve($input);
    }

    // --------------------------------------------------------------------

    public function testDay22Example1(): void
    {
        $solver = new Aoc2023Day22();
        $input = $solver->readInput($solver->inputBaseFileName() . 'ex1.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::EXAMPLE_SOLUTIONS[0];
        self::assertSame(strval($expected1), $ans1);
        self::assertSame(strval($expected2), $ans2);
    }

    public function testDay22(): void
    {
        $solver = new Aoc2023Day22();
        $input = $solver->readInput($solver->inputBaseFileName() . '.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::SOLUTIONS;
        self::assertSame(strval($expected1), $ans1);
        self::assertSame(strval($expected2), $ans2);
    }

    public function testDay22InvalidInput1(): void
    {
        $solver = new Aoc2023Day22();
        $input = ['a'];
        $this->expectException(\Exception::class);
        [$ans1, $ans2] = $solver->solve($input);
    }

    public function testDay22InvalidInput2(): void
    {
        $solver = new Aoc2023Day22();
        $input = ['1,0,1~1,2'];
        $this->expectException(\Exception::class);
        [$ans1, $ans2] = $solver->solve($input);
    }

    public function testDay22InvalidInput3(): void
    {
        $solver = new Aoc2023Day22();
        $input = ['1,3,1~1,2,1'];
        $this->expectException(\Exception::class);
        [$ans1, $ans2] = $solver->solve($input);
    }

    public function testDay22InvalidInput4(): void
    {
        $solver = new Aoc2023Day22();
        $input = ['0,0,1~2,0,1', '2,0,1~3,0,1'];
        $this->expectException(\Exception::class);
        [$ans1, $ans2] = $solver->solve($input);
    }

    // --------------------------------------------------------------------

    public function testDay23Example1(): void
    {
        $solver = new Aoc2023Day23();
        $input = $solver->readInput($solver->inputBaseFileName() . 'ex1.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::EXAMPLE_SOLUTIONS[0];
        self::assertSame(strval($expected1), $ans1);
        self::assertSame(strval($expected2), $ans2);
    }

    #[Group('slow')]
    public function testDay23(): void
    {
        $solver = new Aoc2023Day23();
        $input = $solver->readInput($solver->inputBaseFileName() . '.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::SOLUTIONS;
        self::assertSame(strval($expected1), $ans1);
        self::assertSame(strval($expected2), $ans2);
    }

    public function testDay23InvalidInput1(): void
    {
        $solver = new Aoc2023Day23();
        $input = ['#.#', '###'];
        $this->expectException(\Exception::class);
        [$ans1, $ans2] = $solver->solve($input);
    }

    public function testDay23InvalidInput2(): void
    {
        $solver = new Aoc2023Day23();
        $input = ['#.#', '#.a'];
        $this->expectException(\Exception::class);
        [$ans1, $ans2] = $solver->solve($input);
    }

    // --------------------------------------------------------------------

    public function testDay24Example1(): void
    {
        $solver = new Aoc2023Day24();
        $input = $solver->readInput($solver->inputBaseFileName() . 'ex1.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::EXAMPLE_SOLUTIONS[0];
        self::assertSame(strval($expected1), $ans1);
        self::assertSame(strval($expected2), $ans2);
    }

    #[Group('medium-slow')]
    public function testDay24(): void
    {
        $solver = new Aoc2023Day24();
        $input = $solver->readInput($solver->inputBaseFileName() . '.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::SOLUTIONS;
        self::assertSame(strval($expected1), $ans1);
        self::assertSame(strval($expected2), $ans2);
    }

    public function testDay24InvalidInput1(): void
    {
        $solver = new Aoc2023Day24();
        $input = ['a'];
        $this->expectException(\Exception::class);
        [$ans1, $ans2] = $solver->solve($input);
    }

    public function testDay24InvalidInput2(): void
    {
        $solver = new Aoc2023Day24();
        $input = ['19, 13, 30 @ -2, 1'];
        $this->expectException(\Exception::class);
        [$ans1, $ans2] = $solver->solve($input);
    }

    public function testDay24InvalidInput3(): void
    {
        $solver = new Aoc2023Day24();
        $input = ['19, 13 @ -2,  1, -2'];
        $this->expectException(\Exception::class);
        [$ans1, $ans2] = $solver->solve($input);
    }

    // --------------------------------------------------------------------

    public function testDay25Example1(): void
    {
        $solver = new Aoc2023Day25();
        $input = $solver->readInput($solver->inputBaseFileName() . 'ex1.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::EXAMPLE_SOLUTIONS[0];
        self::assertSame(strval($expected1), $ans1);
        // self::assertSame(strval($expected2), $ans2);
    }

    public function testDay25(): void
    {
        $solver = new Aoc2023Day25();
        $input = $solver->readInput($solver->inputBaseFileName() . '.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::SOLUTIONS;
        self::assertSame(strval($expected1), $ans1);
        // self::assertSame(strval($expected2), $ans2);
    }

    public function testDay25InvalidInput1(): void
    {
        $solver = new Aoc2023Day25();
        $input = ['a'];
        $this->expectException(\Exception::class);
        [$ans1, $ans2] = $solver->solve($input);
    }

    // --------------------------------------------------------------------
}
