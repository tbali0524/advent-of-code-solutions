<?php

declare(strict_types=1);

namespace TBali\Aoc2021;

use TBali\Aoc\SolutionBase;

/**
 * AoC 2021 Day 7: The Treachery of Whales.
 *
 * Part 1: How much fuel must they spend to align to that position?
 * Part 2: Determine the horizontal position that the crabs can align to using the least fuel possible
 *         so they can make you an escape route!How much fuel must they spend to align to that position?
 *
 * @see https://adventofcode.com/2021/day/7
 */
final class Aoc2021Day07 extends SolutionBase
{
    public const YEAR = 2021;
    public const DAY = 7;
    public const TITLE = 'The Treachery of Whales';
    public const SOLUTIONS = [335330, 92439766];
    public const EXAMPLE_SOLUTIONS = [[37, 168]];

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
        /** @var array<int, int> */
        $data = array_map(intval(...), explode(',', $input[0]));
        // ---------- Part 1
        sort($data);
        $key = intdiv(count($data) - 1, 2);
        $median = $data[$key];
        $ans1 = array_sum(array_map(fn (int $x): int => abs($x - $median), $data));
        // ---------- Part 2
        $ans2 = PHP_INT_MAX;
        $min = intval(min($data));
        $max = intval(max($data));
        for ($i = $min; $i <= $max; ++$i) {
            $fuel = array_sum(array_map(fn (int $x): int => intdiv(abs($x - $i) * (abs($x - $i) + 1), 2), $data));
            if ($fuel < $ans2) {
                $ans2 = $fuel;
            }
        }
        return [strval($ans1), strval($ans2)];
    }
}
