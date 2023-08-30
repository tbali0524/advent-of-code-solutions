<?php

declare(strict_types=1);

namespace TBali\Aoc2015;

use TBali\Aoc\SolutionBase;

/**
 * AoC 2015 Day 18: Like a GIF For Your Yard.
 *
 * Part 1: How many lights are on after 100 steps?
 * Part 2: With the four corners always in the on state, how many lights are on after 100 steps?
 *
 * Topics: Conway's Game of Life, simulation
 *
 * @see https://adventofcode.com/2015/day/18
 */
final class Aoc2015Day18 extends SolutionBase
{
    public const YEAR = 2015;
    public const DAY = 18;
    public const TITLE = 'Like a GIF For Your Yard';
    public const SOLUTIONS = [814, 924];
    public const EXAMPLE_SOLUTIONS = [[4, 17]];

    private const STEPS = 100;
    private const EXAMPLE_STEPS = 5;

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
        $ans1 = $this->simulate($input, false);
        $ans2 = $this->simulate($input, true);
        return [strval($ans1), strval($ans2)];
    }

    /**
     * @param array<int, string> $input The lines of the input, without LF
     */
    private function simulate(array $input, bool $stuckCorners = false): int
    {
        $size = count($input);
        // detect puzzle example as input
        $maxSteps = ($size == 6 ? self::EXAMPLE_STEPS : self::STEPS);
        $corners = [
            [0, 0],
            [0, $size - 1],
            [$size - 1, 0],
            [$size - 1, $size - 1],
        ];
        $prev = $input;
        if ($stuckCorners) {
            foreach ($corners as $xy) {
                [$x, $y] = $xy;
                $prev[$y][$x] = '#';
            }
        }
        for ($step = 0; $step < $maxSteps; ++$step) {
            $next = $prev;
            for ($y = 0; $y < $size; ++$y) {
                for ($x = 0; $x < $size; ++$x) {
                    if ($stuckCorners and in_array([$x, $y], $corners, true)) {
                        continue;
                    }
                    $count = 0;
                    for ($dy = -1; $dy <= 1; ++$dy) {
                        for ($dx = -1; $dx <= 1; ++$dx) {
                            if (($dx == 0) and ($dy == 0)) {
                                continue;
                            }
                            $x1 = $x + $dx;
                            $y1 = $y + $dy;
                            if (($x1 < 0) or ($x1 >= $size) or ($y1 < 0) or ($y1 >= $size)) {
                                continue;
                            }
                            if ($prev[$y1][$x1] == '#') {
                                ++$count;
                            }
                        }
                    }
                    if ($prev[$y][$x] == '#') {
                        $next[$y][$x] = (($count == 2 || $count == 3) ? '#' : '.');
                    } elseif ($prev[$y][$x] == '.') {
                        $next[$y][$x] = ($count == 3 ? '#' : '.');
                    }
                }
            }
            $prev = $next;
        }
        return array_sum(array_map(static fn (string $row): int => substr_count($row, '#'), $next));
    }
}
