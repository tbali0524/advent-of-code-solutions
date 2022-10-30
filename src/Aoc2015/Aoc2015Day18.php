<?php

/*
https://adventofcode.com/2015/day/18
Part 1: How many lights are on after 100 steps?
Part 2: With the four corners always in the on state, how many lights are on after 100 steps?
topics: Conway's Game of Life
*/

declare(strict_types=1);

namespace TBali\Aoc2015;

use TBali\Aoc\SolutionBase;

class Aoc2015Day18 extends SolutionBase
{
    public const YEAR = 2015;
    public const DAY = 18;
    public const TITLE = 'Like a GIF For Your Yard';
    public const SOLUTIONS = [814, 924];
    public const EXAMPLE_SOLUTIONS = [[0, 0], [0, 0]];

    private const MAX = 100;
    private const STEPS = 100;
    private const CORNERS = [
        [0, 0],
        [0, self::MAX - 1],
        [self::MAX - 1, 0],
        [self::MAX - 1, self::MAX - 1],
    ];

    /**
     * @param string[] $input
     *
     * @return array{string, string}
     */
    public function solve(array $input): array
    {
        // ---------- Part 1 + 2
        $ans1 = $this->simulate($input, false);
        $ans2 = $this->simulate($input, true);
        return [strval($ans1), strval($ans2)];
    }

    // --------------------------------------------------------------------
    /** @param string[] $input */
    private function simulate(array $input, bool $stuckCorners = false): int
    {
        $prev = $input;
        if ($stuckCorners) {
            foreach (self::CORNERS as $xy) {
                [$x, $y] = $xy;
                $prev[$y][$x] = '#';
            }
        }
        for ($step = 0; $step < self::STEPS; ++$step) {
            $next = $prev;
            for ($y = 0; $y < self::MAX; ++$y) {
                for ($x = 0; $x < self::MAX; ++$x) {
                    if ($stuckCorners and in_array([$x, $y], self::CORNERS, true)) {
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
                            if (($x1 < 0) or ($x1 >= self::MAX) or ($y1 < 0) or ($y1 >= self::MAX)) {
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
        return array_sum(array_map(fn ($row) => substr_count($row, '#'), $next));
    }
}
