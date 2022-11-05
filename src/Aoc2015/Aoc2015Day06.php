<?php

// phpcs:disable PSR1.Classes.ClassDeclaration

declare(strict_types=1);

namespace TBali\Aoc2015;

use TBali\Aoc\SolutionBase;

/**
 * AoC 2015 Day 6: Probably a Fire Hazard.
 *
 * Part 1: How many total square feet of wrapping paper should they order?
 * Part 2: What is the total brightness of all lights combined after following Santa's instructions?
 *
 * @see https://adventofcode.com/2015/day/6
 */
final class Aoc2015Day06 extends SolutionBase
{
    public const YEAR = 2015;
    public const DAY = 6;
    public const TITLE = 'Probably a Fire Hazard';
    public const SOLUTIONS = [377891, 14110788];
    public const EXAMPLE_SOLUTIONS = [[1000000, 2000000], [1, 1]];
    public const EXAMPLE_STRING_INPUTS = ['toggle 0,0 through 999,999', 'turn on 0,0 through 0,0'];

    private const MAX = 1000;

    /**
     * Solve both parts of the puzzle for a given input, without IO.
     *
     * @param array<int, string> $input The lines of the input, without LF
     *
     * @return array<int, string> The answers for Part 1 and Part 2 (as strings)
     *
     * @phpstan-return array{string, string}
     */
    public function solve(array $input): array
    {
        $instructions = $this->parseInput($input);
        // ---------- Part 1
        $ans1 = 0;
        $grid = array_fill(0, self::MAX, array_fill(0, self::MAX, false));
        foreach ($instructions as $instr) {
            for ($y = $instr->y0; $y <= $instr->y1; ++$y) {
                for ($x = $instr->x0; $x <= $instr->x1; ++$x) {
                    if ($instr->verb == 'toggle') {
                        $grid[$y][$x] = !$grid[$y][$x];
                    } elseif ($instr->verb == 'turn on') {
                        $grid[$y][$x] = true;
                    } elseif ($instr->verb == 'turn off') {
                        $grid[$y][$x] = false;
                    }
                }
            }
        }
        $ans1 = array_sum(array_map(
            fn (array $row): int => count(array_filter($row, fn (bool $x): bool => $x)),
            $grid
        ));
        // ---------- Part 2
        $ans2 = 0;
        $grid = array_fill(0, self::MAX, array_fill(0, self::MAX, 0));
        foreach ($instructions as $instr) {
            for ($y = $instr->y0; $y <= $instr->y1; ++$y) {
                for ($x = $instr->x0; $x <= $instr->x1; ++$x) {
                    if ($instr->verb == 'toggle') {
                        $grid[$y][$x] += 2;
                    } elseif ($instr->verb == 'turn on') {
                        ++$grid[$y][$x];
                    } elseif ($instr->verb == 'turn off') {
                        $grid[$y][$x] = max(0, $grid[$y][$x] - 1);
                    }
                }
            }
        }
        $ans2 = array_sum(array_map(fn (array $row): int => array_sum($row), $grid));
        return [strval($ans1), strval($ans2)];
    }

    /**
     * @param array<int, string> $input
     *
     * @return array<int, Instruction>
     */
    private function parseInput(array $input): array
    {
        $instructions = [];
        foreach ($input as $line) {
            $instructionWords = str_starts_with($line, 'turn') ? 2 : 1;
            $a = explode(' ', trim($line));
            if (count($a) != 3 + $instructionWords) {
                throw new \Exception('Invalid input');
            }
            $b = explode(',', $a[$instructionWords]);
            $c = explode(',', $a[2 + $instructionWords]);
            if ((count($b) != 2) or (count($c) != 2) or ($a[1 + $instructionWords] != 'through')) {
                throw new \Exception('Invalid input');
            }
            $instructions[] = new Instruction(
                $instructionWords == 1 ? $a[0] : $a[0] . ' ' . $a[1],
                intval($b[0]),
                intval($b[1]),
                intval($c[0]),
                intval($c[1]),
            );
        }
        return $instructions;
    }
}

// --------------------------------------------------------------------
final class Instruction
{
    public function __construct(
        public readonly string $verb,
        public readonly int $x0,
        public readonly int $y0,
        public readonly int $x1,
        public readonly int $y1,
    ) {
    }
}
