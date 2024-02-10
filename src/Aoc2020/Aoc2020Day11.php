<?php

declare(strict_types=1);

namespace TBali\Aoc2020;

use TBali\Aoc\SolutionBase;

/**
 * AoC 2020 Day 11: Seating System.
 *
 * Part 1: How many seats end up occupied?
 * Part 2: Given the new visibility method and the rule change for occupied seats becoming empty,
 *         once equilibrium is reached, how many seats end up occupied?
 *
 * Topics: Conway's Game of Life, simulation
 *
 * @see https://adventofcode.com/2020/day/11
 */
final class Aoc2020Day11 extends SolutionBase
{
    public const YEAR = 2020;
    public const DAY = 11;
    public const TITLE = 'Seating System';
    public const SOLUTIONS = [2263, 2002];
    public const EXAMPLE_SOLUTIONS = [[37, 26]];

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
        // ---------- Part 1 + 2
        $ans1 = $this->simulate($input);
        $ans2 = $this->simulate($input, 5, false);
        return [strval($ans1), strval($ans2)];
    }

    /**
     * @param array<int, string> $input The lines of the input, without LF
     */
    private function simulate(array $input, int $leaveThreshold = 4, bool $neighborOnly = true): int
    {
        if ($input == []) {
            // @codeCoverageIgnoreStart
            return 0;
            // @codeCoverageIgnoreEnd
        }
        $maxY = count($input);
        $maxX = strlen($input[0]);
        $prev = $input;
        while (true) {
            $next = $prev;
            for ($y = 0; $y < $maxY; ++$y) {
                for ($x = 0; $x < $maxX; ++$x) {
                    if ($prev[$y][$x] == '.') {
                        continue;
                    }
                    $count = 0;
                    for ($dy = -1; $dy <= 1; ++$dy) {
                        for ($dx = -1; $dx <= 1; ++$dx) {
                            if (($dx == 0) and ($dy == 0)) {
                                continue;
                            }
                            $x1 = $x;
                            $y1 = $y;
                            while (true) {
                                $x1 += $dx;
                                $y1 += $dy;
                                if (($x1 < 0) or ($x1 >= $maxX) or ($y1 < 0) or ($y1 >= $maxY)) {
                                    break;
                                }
                                if ($prev[$y1][$x1] == 'L') {
                                    break;
                                }
                                if ($prev[$y1][$x1] == '#') {
                                    ++$count;
                                    break;
                                }
                                if ($neighborOnly) {
                                    break;
                                }
                            }
                        }
                    }
                    if (($prev[$y][$x] == 'L') and ($count == 0)) {
                        $next[$y][$x] = '#';
                    } elseif (($prev[$y][$x] == '#') and ($count >= $leaveThreshold)) {
                        $next[$y][$x] = 'L';
                    }
                }
            }
            if ($next == $prev) {
                break;
            }
            $prev = $next;
        }
        return array_sum(array_map(static fn (string $row): int => substr_count($row, '#'), $next));
    }
}
