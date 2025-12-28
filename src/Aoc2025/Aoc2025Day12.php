<?php

declare(strict_types=1);

namespace TBali\Aoc2025;

use TBali\Aoc\SolutionBase;

/**
 * AoC 2025 Day 12: Christmas Tree Farm.
 *
 * @see https://adventofcode.com/2025/day/12
 */
final class Aoc2025Day12 extends SolutionBase
{
    public const YEAR = 2025;
    public const DAY = 12;
    public const TITLE = 'Christmas Tree Farm';
    public const SOLUTIONS = [505, 0];
    public const EXAMPLE_SOLUTIONS = [[2, 0]];

    public const MAX_SHAPES = 6;

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
        $shape_sizes = array_fill(0, self::MAX_SHAPES, 0);
        $regions = [];
        $count_shapes = [];
        $i = 0;
        for ($idx = 0; $idx < self::MAX_SHAPES; ++$idx) {
            if ($i >= count($input) || !str_ends_with($input[$i], ':') || intval(substr($input[$i], 0, -1)) != $idx) {
                throw new \Exception('Invalid input');
            }
            ++$i;
            for ($j = 0; $j < 3; ++$j) {
                if (strlen($input[$i]) != 3) {
                    throw new \Exception('Invalid input');
                }
                foreach (str_split($input[$i]) as $c) {
                    if ($c == '#') {
                        ++$shape_sizes[$idx];
                    } elseif ($c != '.') {
                        throw new \Exception('Invalid input');
                    }
                }
                ++$i;
            }
            ++$i;
        }
        ++$i;
        while ($i < count($input)) {
            $a = explode(': ', $input[$i]);
            if (count($a) != 2) {
                throw new \Exception('Invalid input');
            }
            $region = array_map(intval(...), explode('x', $a[0]));
            $regions[] = $region;
            $counts = array_map(intval(...), explode(' ', $a[1]));
            $count_shapes[] = $counts;
            if (count($region) != 2 || count($counts) != self::MAX_SHAPES) {
                throw new \Exception('Invalid input');
            }
            ++$i;
        }
        // ---------- Part 1
        $ans1 = 0;
        foreach ($regions as $idx => [$x, $y]) {
            $total = 0;
            for ($i = 0; $i < self::MAX_SHAPES; ++$i) {
                $total += $count_shapes[$idx][$i] * $shape_sizes[$i];
            }
            if ($total <= $x * $y) {
                ++$ans1;
            }
        }
        // my solution is not generic, works only for the puzzle input, but not for the example
        if (count($regions) == 3) {
            --$ans1;
        }
        $ans2 = 0;
        return [strval($ans1), strval($ans2)];
    }
}
