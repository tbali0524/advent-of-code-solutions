<?php

declare(strict_types=1);

namespace TBali\Aoc2024;

use TBali\Aoc\SolutionBase;

/**
 * AoC 2024 Day 22: Monkey Market.
 *
 * @see https://adventofcode.com/2024/day/22
 */
final class Aoc2024Day22 extends SolutionBase
{
    public const YEAR = 2024;
    public const DAY = 22;
    public const TITLE = 'Monkey Market';
    public const SOLUTIONS = [18261820068, 2044];
    public const EXAMPLE_SOLUTIONS = [[37327623, 0], [0, 23]];

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
        $data = array_map(intval(...), $input);
        // ---------- Part 1 + 2
        $ans1 = 0;
        $total_sales = [];
        foreach ($data as $start) {
            $secret = $start;
            $price = $start % 10;
            $hash = 0;
            $best_prices = [];
            for ($i = 1; $i <= 2000; ++$i) {
                $next_secret = ($secret ^ ($secret << 6)) & 0x00FF_FFFF; // 24 bits
                $next_secret = ($next_secret ^ ($next_secret >> 5)) & 0x00FF_FFFF;
                $next_secret = ($next_secret ^ ($next_secret << 11)) & 0x00FF_FFFF;
                $next_price = $next_secret % 10;
                $hash = (($hash << 5) | (10 + $next_price - $price)) & 0x000F_FFFF; // 4*5 = 20 bits
                if (($i >= 4) and !isset($best_prices[$hash])) {
                    $best_prices[$hash] = $next_price;
                }
                $secret = $next_secret;
                $price = $next_price;
            }
            $ans1 += $secret;
            foreach ($best_prices as $hash => $price) {
                $total_sales[$hash] = ($total_sales[$hash] ?? 0) + $price;
            }
        }
        $ans2 = intval(max($total_sales ?: [0]));
        return [strval($ans1), strval($ans2)];
    }
}
