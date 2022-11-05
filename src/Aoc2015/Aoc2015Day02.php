<?php

declare(strict_types=1);

namespace TBali\Aoc2015;

use TBali\Aoc\SolutionBase;

/**
 * AoC 2015 Day 2: I Was Told There Would Be No Math.
 *
 * Part 1: How many total square feet of wrapping paper should they order?
 * Part 2: How many total feet of ribbon should they order?
 *
 * @see https://adventofcode.com/2015/day/2
 */
final class Aoc2015Day02 extends SolutionBase
{
    public const YEAR = 2015;
    public const DAY = 2;
    public const TITLE = 'I Was Told There Would Be No Math';
    public const SOLUTIONS = [1606483, 3842356];
    public const EXAMPLE_SOLUTIONS = [[58, 34], [43, 14]];
    public const EXAMPLE_STRING_INPUTS = ['2x3x4', '1x1x10'];

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
        /** @var array<array<int, int>> */
        $input = array_map(
            fn ($line) => array_map('intval', explode('x', $line)),
            $input
        );
        // ---------- Part 1
        $ans1 = 0;
        foreach ($input as $box) {
            if (count($box) != 3) {
                throw new \Exception('Invalid input');
            }
            $sides = [];
            $sides[] = $box[0] * $box[1];
            $sides[] = $box[0] * $box[2];
            $sides[] = $box[1] * $box[2];
            $ans1 += 2 * array_sum($sides) + min($sides);
        }
        // ---------- Part 2
        $ans2 = 0;
        foreach ($input as $box) {
            if (count($box) != 3) {
                throw new \Exception('Invalid input');
            }
            sort($box);
            $ans2 += 2 * ($box[0] + $box[1]) + array_product($box);
        }
        return [strval($ans1), strval($ans2)];
    }
}
