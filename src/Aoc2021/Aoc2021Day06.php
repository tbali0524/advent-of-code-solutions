<?php

declare(strict_types=1);

namespace TBali\Aoc2021;

use TBali\Aoc\SolutionBase;

/**
 * AoC 2021 Day 6: Lanternfish.
 *
 * Part 1: How many lanternfish would there be after 80 days?
 * Part 2: How many lanternfish would there be after 256 days?
 *
 * @see https://adventofcode.com/2021/day/6
 */
final class Aoc2021Day06 extends SolutionBase
{
    public const YEAR = 2021;
    public const DAY = 6;
    public const TITLE = 'Lanternfish';
    public const SOLUTIONS = [352195, 1600306001288];
    public const EXAMPLE_SOLUTIONS = [[5934, 26984457539]];

    private const MAX_STEPS_PART1 = 80;
    private const MAX_STEPS_PART2 = 256;

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
        /** @var array<int, int> */
        $startFishes = array_map(intval(...), explode(',', $input[0]));
        // ---------- Part 1 + 2
        $counts = array_count_values($startFishes);
        $fishCounter = array_fill(0, 9, 0);
        foreach ($counts as $timer => $count) {
            $fishCounter[$timer] = $count;
        }
        $ans1 = 0;
        for ($step = 1; $step <= self::MAX_STEPS_PART2; ++$step) {
            $nextFishCounter = array_slice($fishCounter, 1);
            $nextFishCounter[] = $fishCounter[0];
            $nextFishCounter[6] += $fishCounter[0];
            $fishCounter = $nextFishCounter;
            if ($step == self::MAX_STEPS_PART1) {
                $ans1 = array_sum($fishCounter);
            }
        }
        $ans2 = array_sum($fishCounter);
        return [strval($ans1), strval($ans2)];
    }
}
