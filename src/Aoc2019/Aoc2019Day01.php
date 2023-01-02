<?php

declare(strict_types=1);

namespace TBali\Aoc2019;

use TBali\Aoc\SolutionBase;

/**
 * AoC 2019 Day 1: The Tyranny of the Rocket Equation.
 *
 * Part 1: What is the sum of the fuel requirements for all of the modules on your spacecraft?
 * Part 2: What is the sum of the fuel requirements for all of the modules on your spacecraft when also
 *         taking into account the mass of the added fuel?
 *
 * @see https://adventofcode.com/2019/day/1
 */
final class Aoc2019Day01 extends SolutionBase
{
    public const YEAR = 2019;
    public const DAY = 1;
    public const TITLE = 'The Tyranny of the Rocket Equation';
    public const SOLUTIONS = [3287620, 4928567];
    public const EXAMPLE_SOLUTIONS = [[34241, 51316]];

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
        $input = array_map(intval(...), $input);
        // ---------- Part 1
        $ans1 = array_sum(array_map(
            fn (int $x): int => intdiv($x, 3) - 2,
            $input
        ));
        // ---------- Part 2
        $ans2 = 0;
        foreach ($input as $mass) {
            $total = 0;
            $fuel = $mass;
            while (true) {
                $fuel = max(0, intdiv($fuel, 3) - 2);
                $total += $fuel;
                if ($fuel == 0) {
                    break;
                }
            }
            $ans2 += $total;
        }
        return [strval($ans1), strval($ans2)];
    }
}
