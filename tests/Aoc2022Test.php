<?php

declare(strict_types=1);

namespace TBali\Tests;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\Attributes\RequiresPhp;
use PHPUnit\Framework\Attributes\RequiresPhpunit;
use PHPUnit\Framework\TestCase;
use TBali\Aoc2022\Aoc2022Day01;
use TBali\Aoc2022\Aoc2022Day02;
use TBali\Aoc2022\Aoc2022Day03;
use TBali\Aoc2022\Aoc2022Day04;
use TBali\Aoc2022\Aoc2022Day05;
use TBali\Aoc2022\Aoc2022Day06;
use TBali\Aoc2022\Aoc2022Day07;
use TBali\Aoc2022\Aoc2022Day08;
use TBali\Aoc2022\Aoc2022Day09;
use TBali\Aoc2022\Aoc2022Day10;
use TBali\Aoc2022\Aoc2022Day11;
use TBali\Aoc2022\Aoc2022Day12;
use TBali\Aoc2022\Aoc2022Day13;
use TBali\Aoc2022\Aoc2022Day14;
use TBali\Aoc2022\Aoc2022Day15;
use TBali\Aoc2022\Aoc2022Day16;
use TBali\Aoc2022\Aoc2022Day17;
use TBali\Aoc2022\Aoc2022Day18;
use TBali\Aoc2022\Aoc2022Day19;
use TBali\Aoc2022\Aoc2022Day20;
use TBali\Aoc2022\Aoc2022Day21;
use TBali\Aoc2022\Aoc2022Day22;
use TBali\Aoc2022\Aoc2022Day23;
use TBali\Aoc2022\Aoc2022Day24;
use TBali\Aoc2022\Aoc2022Day25;
use TBali\Aoc2022\Blizzard;
use TBali\Aoc2022\BluePrint;
use TBali\Aoc2022\CrossRock;
use TBali\Aoc2022\Directory;
use TBali\Aoc2022\File;
use TBali\Aoc2022\HorizontalRock;
use TBali\Aoc2022\Instruction;
use TBali\Aoc2022\Item;
use TBali\Aoc2022\ListItem;
use TBali\Aoc2022\LRock;
use TBali\Aoc2022\MathMonkey;
use TBali\Aoc2022\MemoPit;
use TBali\Aoc2022\MineState;
use TBali\Aoc2022\MonkeyBusiness;
use TBali\Aoc2022\Pit;
use TBali\Aoc2022\Rect;
use TBali\Aoc2022\Rock;
use TBali\Aoc2022\Sensor;
use TBali\Aoc2022\SquareRock;
use TBali\Aoc2022\ValveState;
use TBali\Aoc2022\VerticalRock;

/**
 * Unit tests for Advent of Code season 2022.
 *
 * Instead of using this file with phpunit, it is a better way to run the solutions by using AoCRunner.
 *
 * @internal
 *
 * @coversNothing
 */
#[RequiresPhp('^8.3')]
#[RequiresPhpunit('^11.0')]
#[CoversClass(Aoc2022Day01::class)]
#[CoversClass(Aoc2022Day02::class)]
#[CoversClass(Aoc2022Day03::class)]
#[CoversClass(Aoc2022Day04::class)]
#[CoversClass(Aoc2022Day05::class)]
#[CoversClass(Aoc2022Day06::class)]
#[CoversClass(Aoc2022Day07::class)]
#[CoversClass(Aoc2022Day08::class)]
#[CoversClass(Aoc2022Day09::class)]
#[CoversClass(Aoc2022Day10::class)]
#[CoversClass(Aoc2022Day11::class)]
#[CoversClass(Aoc2022Day12::class)]
#[CoversClass(Aoc2022Day13::class)]
#[CoversClass(Aoc2022Day14::class)]
#[CoversClass(Aoc2022Day15::class)]
#[CoversClass(Aoc2022Day16::class)]
#[CoversClass(Aoc2022Day17::class)]
#[CoversClass(Aoc2022Day18::class)]
#[CoversClass(Aoc2022Day19::class)]
#[CoversClass(Aoc2022Day20::class)]
#[CoversClass(Aoc2022Day21::class)]
#[CoversClass(Aoc2022Day22::class)]
#[CoversClass(Aoc2022Day23::class)]
#[CoversClass(Aoc2022Day24::class)]
#[CoversClass(Aoc2022Day25::class)]
#[CoversClass(Blizzard::class)]
#[CoversClass(BluePrint::class)]
#[CoversClass(CrossRock::class)]
#[CoversClass(Directory::class)]
#[CoversClass(File::class)]
#[CoversClass(HorizontalRock::class)]
#[CoversClass(Instruction::class)]
#[CoversClass(Item::class)]
#[CoversClass(ListItem::class)]
#[CoversClass(LRock::class)]
#[CoversClass(MathMonkey::class)]
#[CoversClass(MemoPit::class)]
#[CoversClass(MineState::class)]
#[CoversClass(MonkeyBusiness::class)]
#[CoversClass(Pit::class)]
#[CoversClass(Rect::class)]
#[CoversClass(Rock::class)]
#[CoversClass(Sensor::class)]
#[CoversClass(SquareRock::class)]
#[CoversClass(ValveState::class)]
#[CoversClass(VerticalRock::class)]
final class Aoc2022Test extends TestCase
{
    // --------------------------------------------------------------------

    public function testDay01Example1(): void
    {
        $solver = new Aoc2022Day01();
        $input = $solver->readInput($solver->inputBaseFileName() . 'ex1.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::EXAMPLE_SOLUTIONS[0];
        self::assertSame(strval($expected1), $ans1);
        self::assertSame(strval($expected2), $ans2);
    }

    public function testDay01(): void
    {
        $solver = new Aoc2022Day01();
        $input = $solver->readInput($solver->inputBaseFileName() . '.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::SOLUTIONS;
        self::assertSame(strval($expected1), $ans1);
        self::assertSame(strval($expected2), $ans2);
    }

    // --------------------------------------------------------------------

    public function testDay02Example1(): void
    {
        $solver = new Aoc2022Day02();
        $input = $solver->readInput($solver->inputBaseFileName() . 'ex1.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::EXAMPLE_SOLUTIONS[0];
        self::assertSame(strval($expected1), $ans1);
        self::assertSame(strval($expected2), $ans2);
    }

    public function testDay02(): void
    {
        $solver = new Aoc2022Day02();
        $input = $solver->readInput($solver->inputBaseFileName() . '.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::SOLUTIONS;
        self::assertSame(strval($expected1), $ans1);
        self::assertSame(strval($expected2), $ans2);
    }

    // --------------------------------------------------------------------

    public function testDay03Example1(): void
    {
        $solver = new Aoc2022Day03();
        $input = $solver->readInput($solver->inputBaseFileName() . 'ex1.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::EXAMPLE_SOLUTIONS[0];
        self::assertSame(strval($expected1), $ans1);
        self::assertSame(strval($expected2), $ans2);
    }

    public function testDay03(): void
    {
        $solver = new Aoc2022Day03();
        $input = $solver->readInput($solver->inputBaseFileName() . '.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::SOLUTIONS;
        self::assertSame(strval($expected1), $ans1);
        self::assertSame(strval($expected2), $ans2);
    }

    // --------------------------------------------------------------------

    public function testDay04Example1(): void
    {
        $solver = new Aoc2022Day04();
        $input = $solver->readInput($solver->inputBaseFileName() . 'ex1.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::EXAMPLE_SOLUTIONS[0];
        self::assertSame(strval($expected1), $ans1);
        self::assertSame(strval($expected2), $ans2);
    }

    public function testDay04(): void
    {
        $solver = new Aoc2022Day04();
        $input = $solver->readInput($solver->inputBaseFileName() . '.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::SOLUTIONS;
        self::assertSame(strval($expected1), $ans1);
        self::assertSame(strval($expected2), $ans2);
    }

    public function testDay04InvalidInput1(): void
    {
        $solver = new Aoc2022Day04();
        $input = ['1-1 2-2'];
        $this->expectException(\Exception::class);
        [$ans1, $ans2] = $solver->solve($input);
    }

    public function testDay04InvalidInput2(): void
    {
        $solver = new Aoc2022Day04();
        $input = ['1-1,2'];
        $this->expectException(\Exception::class);
        [$ans1, $ans2] = $solver->solve($input);
    }

    // --------------------------------------------------------------------

    public function testDay05Example1(): void
    {
        $solver = new Aoc2022Day05();
        $input = $solver->readInput($solver->inputBaseFileName() . 'ex1.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::EXAMPLE_SOLUTIONS[0];
        self::assertSame(strval($expected1), $ans1);
        self::assertSame(strval($expected2), $ans2);
    }

    public function testDay05(): void
    {
        $solver = new Aoc2022Day05();
        $input = $solver->readInput($solver->inputBaseFileName() . '.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::SOLUTIONS;
        self::assertSame(strval($expected1), $ans1);
        self::assertSame(strval($expected2), $ans2);
    }

    public function testDay05InvalidInput1(): void
    {
        $solver = new Aoc2022Day05();
        $input = ['', 'move 1 from 1 to 2'];
        $this->expectException(\Exception::class);
        [$ans1, $ans2] = $solver->solve($input);
    }

    // --------------------------------------------------------------------

    public function testDay06Example1(): void
    {
        $solver = new Aoc2022Day06();
        $input = $solver->readInput($solver->inputBaseFileName() . 'ex1.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::EXAMPLE_SOLUTIONS[0];
        self::assertSame(strval($expected1), $ans1);
        self::assertSame(strval($expected2), $ans2);
    }

    public function testDay06Example2(): void
    {
        $solver = new Aoc2022Day06();
        $input = $solver->readInput($solver->inputBaseFileName() . 'ex2.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::EXAMPLE_SOLUTIONS[1];
        self::assertSame(strval($expected1), $ans1);
        self::assertSame(strval($expected2), $ans2);
    }

    public function testDay06(): void
    {
        $solver = new Aoc2022Day06();
        $input = $solver->readInput($solver->inputBaseFileName() . '.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::SOLUTIONS;
        self::assertSame(strval($expected1), $ans1);
        self::assertSame(strval($expected2), $ans2);
    }

    // --------------------------------------------------------------------

    public function testDay07Example1(): void
    {
        $solver = new Aoc2022Day07();
        $input = $solver->readInput($solver->inputBaseFileName() . 'ex1.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::EXAMPLE_SOLUTIONS[0];
        self::assertSame(strval($expected1), $ans1);
        self::assertSame(strval($expected2), $ans2);
    }

    public function testDay07(): void
    {
        $solver = new Aoc2022Day07();
        $input = $solver->readInput($solver->inputBaseFileName() . '.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::SOLUTIONS;
        self::assertSame(strval($expected1), $ans1);
        self::assertSame(strval($expected2), $ans2);
    }

    public function testDay07InvalidInput1(): void
    {
        $solver = new Aoc2022Day07();
        $input = ['ls'];
        $this->expectException(\Exception::class);
        [$ans1, $ans2] = $solver->solve($input);
    }

    public function testDay07InvalidInput2(): void
    {
        $solver = new Aoc2022Day07();
        $input = ['$ cd a'];
        $this->expectException(\Exception::class);
        [$ans1, $ans2] = $solver->solve($input);
    }

    public function testDay07InvalidInput3(): void
    {
        $solver = new Aoc2022Day07();
        $input = ['$ ls', '1 a.txt b'];
        $this->expectException(\Exception::class);
        [$ans1, $ans2] = $solver->solve($input);
    }

    public function testDay07InvalidInput4(): void
    {
        $solver = new Aoc2022Day07();
        $input = ['$ pws'];
        $this->expectException(\Exception::class);
        [$ans1, $ans2] = $solver->solve($input);
    }

    // --------------------------------------------------------------------

    public function testDay08Example1(): void
    {
        $solver = new Aoc2022Day08();
        $input = $solver->readInput($solver->inputBaseFileName() . 'ex1.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::EXAMPLE_SOLUTIONS[0];
        self::assertSame(strval($expected1), $ans1);
        self::assertSame(strval($expected2), $ans2);
    }

    public function testDay08(): void
    {
        $solver = new Aoc2022Day08();
        $input = $solver->readInput($solver->inputBaseFileName() . '.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::SOLUTIONS;
        self::assertSame(strval($expected1), $ans1);
        self::assertSame(strval($expected2), $ans2);
    }

    // --------------------------------------------------------------------

    public function testDay09Example1(): void
    {
        $solver = new Aoc2022Day09();
        $input = $solver->readInput($solver->inputBaseFileName() . 'ex1.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::EXAMPLE_SOLUTIONS[0];
        self::assertSame(strval($expected1), $ans1);
        self::assertSame(strval($expected2), $ans2);
    }

    public function testDay09Example2(): void
    {
        $solver = new Aoc2022Day09();
        $input = $solver->readInput($solver->inputBaseFileName() . 'ex2.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::EXAMPLE_SOLUTIONS[1];
        // self::assertSame(strval($expected1), $ans1);
        self::assertSame(strval($expected2), $ans2);
    }

    public function testDay09(): void
    {
        $solver = new Aoc2022Day09();
        $input = $solver->readInput($solver->inputBaseFileName() . '.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::SOLUTIONS;
        self::assertSame(strval($expected1), $ans1);
        self::assertSame(strval($expected2), $ans2);
    }

    // --------------------------------------------------------------------

    public function testDay10Example1(): void
    {
        $solver = new Aoc2022Day10();
        $input = $solver->readInput($solver->inputBaseFileName() . 'ex1.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::EXAMPLE_SOLUTIONS[0];
        self::assertSame(strval($expected1), $ans1);
        self::assertSame(strval($expected2), $ans2);
    }

    public function testDay10(): void
    {
        $solver = new Aoc2022Day10();
        $input = $solver->readInput($solver->inputBaseFileName() . '.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::SOLUTIONS;
        self::assertSame(strval($expected1), $ans1);
        self::assertSame(strval($expected2), $ans2);
    }

    // --------------------------------------------------------------------

    public function testDay11Example1(): void
    {
        $solver = new Aoc2022Day11();
        $input = $solver->readInput($solver->inputBaseFileName() . 'ex1.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::EXAMPLE_SOLUTIONS[0];
        self::assertSame(strval($expected1), $ans1);
        self::assertSame(strval($expected2), $ans2);
    }

    #[Group('medium-slow')]
    public function testDay11(): void
    {
        $solver = new Aoc2022Day11();
        $input = $solver->readInput($solver->inputBaseFileName() . '.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::SOLUTIONS;
        self::assertSame(strval($expected1), $ans1);
        self::assertSame(strval($expected2), $ans2);
    }

    public function testDay11InvalidInput1(): void
    {
        $solver = new Aoc2022Day11();
        $input = ['Monkey 0:'];
        $this->expectException(\Exception::class);
        [$ans1, $ans2] = $solver->solve($input);
    }

    // --------------------------------------------------------------------

    public function testDay12Example1(): void
    {
        $solver = new Aoc2022Day12();
        $input = $solver->readInput($solver->inputBaseFileName() . 'ex1.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::EXAMPLE_SOLUTIONS[0];
        self::assertSame(strval($expected1), $ans1);
        self::assertSame(strval($expected2), $ans2);
    }

    public function testDay12(): void
    {
        $solver = new Aoc2022Day12();
        $input = $solver->readInput($solver->inputBaseFileName() . '.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::SOLUTIONS;
        self::assertSame(strval($expected1), $ans1);
        self::assertSame(strval($expected2), $ans2);
    }

    public function testDay12InvalidInput1(): void
    {
        $solver = new Aoc2022Day12();
        $input = ['a'];
        $this->expectException(\Exception::class);
        [$ans1, $ans2] = $solver->solve($input);
    }

    public function testDay12InvalidInput2(): void
    {
        $solver = new Aoc2022Day12();
        $input = ['SabyE'];
        $this->expectException(\Exception::class);
        [$ans1, $ans2] = $solver->solve($input);
    }

    // --------------------------------------------------------------------

    public function testDay13Example1(): void
    {
        $solver = new Aoc2022Day13();
        $input = $solver->readInput($solver->inputBaseFileName() . 'ex1.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::EXAMPLE_SOLUTIONS[0];
        self::assertSame(strval($expected1), $ans1);
        self::assertSame(strval($expected2), $ans2);
    }

    public function testDay13(): void
    {
        $solver = new Aoc2022Day13();
        $input = $solver->readInput($solver->inputBaseFileName() . '.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::SOLUTIONS;
        self::assertSame(strval($expected1), $ans1);
        self::assertSame(strval($expected2), $ans2);
    }

    public function testDay13InvalidInput1(): void
    {
        $solver = new Aoc2022Day13();
        $input = ['[1]'];
        $this->expectException(\Exception::class);
        [$ans1, $ans2] = $solver->solve($input);
    }

    public function testDay13InvalidInput2(): void
    {
        $solver = new Aoc2022Day13();
        $input = ['[1,2]', '[1'];
        $this->expectException(\Exception::class);
        [$ans1, $ans2] = $solver->solve($input);
    }

    // --------------------------------------------------------------------

    public function testDay14Example1(): void
    {
        $solver = new Aoc2022Day14();
        $input = $solver->readInput($solver->inputBaseFileName() . 'ex1.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::EXAMPLE_SOLUTIONS[0];
        self::assertSame(strval($expected1), $ans1);
        self::assertSame(strval($expected2), $ans2);
    }

    #[Group('slow')]
    public function testDay14(): void
    {
        $solver = new Aoc2022Day14();
        $input = $solver->readInput($solver->inputBaseFileName() . '.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::SOLUTIONS;
        self::assertSame(strval($expected1), $ans1);
        self::assertSame(strval($expected2), $ans2);
    }

    public function testDay14InvalidInput1(): void
    {
        $solver = new Aoc2022Day14();
        $input = ['0,1 -> 0,1'];
        $this->expectException(\Exception::class);
        [$ans1, $ans2] = $solver->solve($input);
    }

    // --------------------------------------------------------------------

    public function testDay15Example1(): void
    {
        $solver = new Aoc2022Day15();
        $input = $solver->readInput($solver->inputBaseFileName() . 'ex1.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::EXAMPLE_SOLUTIONS[0];
        self::assertSame(strval($expected1), $ans1);
        self::assertSame(strval($expected2), $ans2);
    }

    #[Group('slow')]
    public function testDay15(): void
    {
        $solver = new Aoc2022Day15();
        $input = $solver->readInput($solver->inputBaseFileName() . '.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::SOLUTIONS;
        self::assertSame(strval($expected1), $ans1);
        self::assertSame(strval($expected2), $ans2);
    }

    public function testDay15InvalidInput1(): void
    {
        $solver = new Aoc2022Day15();
        $input = ['a'];
        $this->expectException(\Exception::class);
        [$ans1, $ans2] = $solver->solve($input);
    }

    public function testDay15InvalidInput2(): void
    {
        $solver = new Aoc2022Day15();
        $input = ['Sensor at x=0, y=1: closest beacon is at x=0'];
        $this->expectException(\Exception::class);
        [$ans1, $ans2] = $solver->solve($input);
    }

    // --------------------------------------------------------------------

    #[Group('medium-slow')]
    public function testDay16Example1(): void
    {
        $solver = new Aoc2022Day16();
        $input = $solver->readInput($solver->inputBaseFileName() . 'ex1.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::EXAMPLE_SOLUTIONS[0];
        self::assertSame(strval($expected1), $ans1);
        self::assertSame(strval($expected2), $ans2);
    }

    #[Group('medium-slow')]
    public function testDay16(): void
    {
        $solver = new Aoc2022Day16();
        $input = $solver->readInput($solver->inputBaseFileName() . '.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::SOLUTIONS;
        self::assertSame(strval($expected1), $ans1);
        self::assertSame(strval($expected2), $ans2);
    }

    public function testDay16InvalidInput1(): void
    {
        $solver = new Aoc2022Day16();
        $input = ['Valve AA has flow rate=0; tunnels lead to'];
        $this->expectException(\Exception::class);
        [$ans1, $ans2] = $solver->solve($input);
    }

    public function testDay16InvalidInput2(): void
    {
        $solver = new Aoc2022Day16();
        $input = [
            'Valve BB has flow rate=1; tunnel leads to valve CC',
            'Valve CC has flow rate=2; tunnel leads to valve BB',
        ];
        $this->expectException(\Exception::class);
        [$ans1, $ans2] = $solver->solve($input);
    }

    // --------------------------------------------------------------------

    public function testDay17Example1(): void
    {
        $solver = new Aoc2022Day17();
        $input = [$solver::EXAMPLE_STRING_INPUTS[0]];
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::EXAMPLE_SOLUTIONS[0];
        self::assertSame(strval($expected1), $ans1);
        self::assertSame(strval($expected2), $ans2);
    }

    public function testDay17(): void
    {
        $solver = new Aoc2022Day17();
        $input = $solver->readInput($solver->inputBaseFileName() . '.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::SOLUTIONS;
        self::assertSame(strval($expected1), $ans1);
        self::assertSame(strval($expected2), $ans2);
    }

    public function testDay17InvalidInput1(): void
    {
        $solver = new Aoc2022Day17();
        $input = ['a'];
        $this->expectException(\Exception::class);
        [$ans1, $ans2] = $solver->solve($input);
    }

    // --------------------------------------------------------------------

    public function testDay18Example1(): void
    {
        $solver = new Aoc2022Day18();
        $input = $solver->readInput($solver->inputBaseFileName() . 'ex1.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::EXAMPLE_SOLUTIONS[0];
        self::assertSame(strval($expected1), $ans1);
        // self::assertSame(strval($expected2), $ans2);
    }

    public function testDay18Example2(): void
    {
        $solver = new Aoc2022Day18();
        $input = $solver->readInput($solver->inputBaseFileName() . 'ex2.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::EXAMPLE_SOLUTIONS[1];
        self::assertSame(strval($expected1), $ans1);
        self::assertSame(strval($expected2), $ans2);
    }

    public function testDay18(): void
    {
        $solver = new Aoc2022Day18();
        $input = $solver->readInput($solver->inputBaseFileName() . '.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::SOLUTIONS;
        self::assertSame(strval($expected1), $ans1);
        self::assertSame(strval($expected2), $ans2);
    }

    public function testDay18InvalidInput1(): void
    {
        $solver = new Aoc2022Day18();
        $input = ['1,1'];
        $this->expectException(\Exception::class);
        [$ans1, $ans2] = $solver->solve($input);
    }

    // --------------------------------------------------------------------

    #[Group('slow')]
    public function testDay19Example1(): void
    {
        $solver = new Aoc2022Day19();
        $input = $solver->readInput($solver->inputBaseFileName() . 'ex1.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::EXAMPLE_SOLUTIONS[0];
        self::assertSame(strval($expected1), $ans1);
        self::assertSame(strval($expected2), $ans2);
    }

    #[Group('slow')]
    public function testDay19(): void
    {
        $solver = new Aoc2022Day19();
        $input = $solver->readInput($solver->inputBaseFileName() . '.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::SOLUTIONS;
        self::assertSame(strval($expected1), $ans1);
        self::assertSame(strval($expected2), $ans2);
    }

    public function testDay19InvalidInput1(): void
    {
        $solver = new Aoc2022Day19();
        $input = ['Blueprint 1: Each ore robot costs 1 ore. Each clay robot costs 1 ore.'];
        $this->expectException(\Exception::class);
        [$ans1, $ans2] = $solver->solve($input);
    }

    // --------------------------------------------------------------------

    public function testDay20Example1(): void
    {
        $solver = new Aoc2022Day20();
        $input = $solver->readInput($solver->inputBaseFileName() . 'ex1.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::EXAMPLE_SOLUTIONS[0];
        self::assertSame(strval($expected1), $ans1);
        self::assertSame(strval($expected2), $ans2);
    }

    #[Group('slow')]
    public function testDay20(): void
    {
        $solver = new Aoc2022Day20();
        $input = $solver->readInput($solver->inputBaseFileName() . '.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::SOLUTIONS;
        self::assertSame(strval($expected1), $ans1);
        self::assertSame(strval($expected2), $ans2);
    }

    public function testDay20InvalidInput1(): void
    {
        $solver = new Aoc2022Day20();
        $input = ['1'];
        $this->expectException(\Exception::class);
        [$ans1, $ans2] = $solver->solve($input);
    }

    // --------------------------------------------------------------------

    public function testDay21Example1(): void
    {
        $solver = new Aoc2022Day21();
        $input = $solver->readInput($solver->inputBaseFileName() . 'ex1.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::EXAMPLE_SOLUTIONS[0];
        self::assertSame(strval($expected1), $ans1);
        self::assertSame(strval($expected2), $ans2);
    }

    public function testDay21(): void
    {
        $solver = new Aoc2022Day21();
        $input = $solver->readInput($solver->inputBaseFileName() . '.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::SOLUTIONS;
        self::assertSame(strval($expected1), $ans1);
        self::assertSame(strval($expected2), $ans2);
    }

    public function testDay21InvalidInput1(): void
    {
        $solver = new Aoc2022Day21();
        $input = ['a'];
        $this->expectException(\Exception::class);
        [$ans1, $ans2] = $solver->solve($input);
    }

    public function testDay21InvalidInput2(): void
    {
        $solver = new Aoc2022Day21();
        $input = ['cczh: sllz + lgvd'];
        $this->expectException(\Exception::class);
        [$ans1, $ans2] = $solver->solve($input);
    }

    // --------------------------------------------------------------------

    public function testDay22Example1(): void
    {
        $solver = new Aoc2022Day22();
        $input = $solver->readInput($solver->inputBaseFileName() . 'ex1.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::EXAMPLE_SOLUTIONS[0];
        self::assertSame(strval($expected1), $ans1);
        self::assertSame(strval($expected2), $ans2);
    }

    public function testDay22(): void
    {
        $solver = new Aoc2022Day22();
        $input = $solver->readInput($solver->inputBaseFileName() . '.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::SOLUTIONS;
        self::assertSame(strval($expected1), $ans1);
        self::assertSame(strval($expected2), $ans2);
    }

    public function testDay22InvalidInput1(): void
    {
        $solver = new Aoc2022Day22();
        $input = ['.'];
        $this->expectException(\Exception::class);
        [$ans1, $ans2] = $solver->solve($input);
    }

    public function testDay22InvalidInput2(): void
    {
        $solver = new Aoc2022Day22();
        $input = [' #', '', '1L'];
        $this->expectException(\Exception::class);
        [$ans1, $ans2] = $solver->solve($input);
    }

    // --------------------------------------------------------------------

    public function testDay23Example1(): void
    {
        $solver = new Aoc2022Day23();
        $input = $solver->readInput($solver->inputBaseFileName() . 'ex1.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::EXAMPLE_SOLUTIONS[0];
        self::assertSame(strval($expected1), $ans1);
        self::assertSame(strval($expected2), $ans2);
    }

    #[Group('slow')]
    public function testDay23(): void
    {
        $solver = new Aoc2022Day23();
        $input = $solver->readInput($solver->inputBaseFileName() . '.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::SOLUTIONS;
        self::assertSame(strval($expected1), $ans1);
        self::assertSame(strval($expected2), $ans2);
    }

    public function testDay23InvalidInput1(): void
    {
        $solver = new Aoc2022Day23();
        $input = ['.'];
        $this->expectException(\Exception::class);
        [$ans1, $ans2] = $solver->solve($input);
    }

    // --------------------------------------------------------------------

    public function testDay24Example1(): void
    {
        $solver = new Aoc2022Day24();
        $input = $solver->readInput($solver->inputBaseFileName() . 'ex1.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::EXAMPLE_SOLUTIONS[0];
        self::assertSame(strval($expected1), $ans1);
        self::assertSame(strval($expected2), $ans2);
    }

    public function testDay24Example2(): void
    {
        $solver = new Aoc2022Day24();
        $input = $solver->readInput($solver->inputBaseFileName() . 'ex2.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::EXAMPLE_SOLUTIONS[1];
        self::assertSame(strval($expected1), $ans1);
        self::assertSame(strval($expected2), $ans2);
    }

    #[Group('slow')]
    public function testDay24(): void
    {
        $solver = new Aoc2022Day24();
        $input = $solver->readInput($solver->inputBaseFileName() . '.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::SOLUTIONS;
        self::assertSame(strval($expected1), $ans1);
        self::assertSame(strval($expected2), $ans2);
    }

    public function testDay24InvalidInput1(): void
    {
        $solver = new Aoc2022Day24();
        $input = ['#'];
        $this->expectException(\Exception::class);
        [$ans1, $ans2] = $solver->solve($input);
    }

    // --------------------------------------------------------------------

    public function testDay25Example1(): void
    {
        $solver = new Aoc2022Day25();
        $input = $solver->readInput($solver->inputBaseFileName() . 'ex1.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::EXAMPLE_SOLUTIONS[0];
        self::assertSame(strval($expected1), $ans1);
        // self::assertSame(strval($expected2), $ans2);
    }

    public function testDay25(): void
    {
        $solver = new Aoc2022Day25();
        $input = $solver->readInput($solver->inputBaseFileName() . '.txt');
        [$ans1, $ans2] = $solver->solve($input);
        [$expected1, $expected2] = $solver::SOLUTIONS;
        self::assertSame(strval($expected1), $ans1);
        // self::assertSame(strval($expected2), $ans2);
    }

    public function testDay25InvalidInput1(): void
    {
        $solver = new Aoc2022Day25();
        $input = ['3'];
        $this->expectException(\Exception::class);
        [$ans1, $ans2] = $solver->solve($input);
    }

    // --------------------------------------------------------------------
}
