<?php

declare(strict_types=1);

namespace TBali\Aoc2018;

use TBali\Aoc\SolutionBase;

/**
 * AoC 2018 Day 25: Four-Dimensional Adventure.
 *
 * Part 1: How many constellations are formed by the fixed points in spacetime?
 * Part 2: N/A
 *
 * Topics: BFS, graph components
 *
 * @see https://adventofcode.com/2018/day/25
 */
final class Aoc2018Day25 extends SolutionBase
{
    public const YEAR = 2018;
    public const DAY = 25;
    public const TITLE = 'Four-Dimensional Adventure';
    public const SOLUTIONS = [324, 0];
    public const EXAMPLE_SOLUTIONS = [[2, 0], [4, 0], [3, 0], [8, 0]];

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
        // ---------- Parse input
        $points = array_map(
            fn ($line) => array_map(intval(...), explode(',', $line)),
            $input,
        );
        // ---------- Part 1
        $constellations = array_fill(0, count($points), -1);
        $countConst = 0;
        for ($i = 0; $i < count($constellations); ++$i) {
            if ($constellations[$i] >= 0) {
                continue;
            }
            $constellations[$i] = $countConst;
            $q = [$i];
            $readIdx = 0;
            while ($readIdx < count($q)) {
                $current = $q[$readIdx];
                ++$readIdx;
                for ($j = 0; $j < count($constellations); ++$j) {
                    if ($constellations[$j] >= 0) {
                        continue;
                    }
                    [$a0, $b0, $c0, $d0] = $points[$current];
                    [$a1, $b1, $c1, $d1] = $points[$j];
                    $dist = abs($a0 - $a1) + abs($b0 - $b1) + abs($c0 - $c1) + abs($d0 - $d1);
                    if ($dist > 3) {
                        continue;
                    }
                    $constellations[$j] = $countConst;
                    $q[] = $j;
                }
            }
            ++$countConst;
        }
        $ans1 = $countConst;
        return [strval($ans1), '0'];
    }
}
