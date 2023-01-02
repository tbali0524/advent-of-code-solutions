<?php

declare(strict_types=1);

namespace TBali\Aoc2020;

use TBali\Aoc\SolutionBase;

/**
 * AoC 2020 Day 15: Rambunctious Recitation.
 *
 * Part 1: Given your starting numbers, what will be the 2020th number spoken?
 * Part 2: Given your starting numbers, what will be the 30000000th number spoken?
 *
 * @see https://adventofcode.com/2020/day/15
 *
 * @codeCoverageIgnore
 */
final class Aoc2020Day15 extends SolutionBase
{
    public const YEAR = 2020;
    public const DAY = 15;
    public const TITLE = 'Rambunctious Recitation';
    public const SOLUTIONS = [662, 37312];
    public const STRING_INPUT = '16,11,15,0,1,7';
    public const EXAMPLE_SOLUTIONS = [[436, 175594], [1, 2578]];
    public const EXAMPLE_STRING_INPUTS = ['0,3,6', '1,3,2'];

    private const MAX1 = 2020;
    private const MAX2 = 30_000_000;

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
        $input = array_map(intval(...), explode(',', $input[0]));
        // ---------- Part 1 + 2
        $memo = array_flip($input);
        $prev = $input[count($input) - 1];
        $next = $prev;
        $ans1 = 0;
        for ($i = count($input); $i < self::MAX2; ++$i) {
            if ($i == self::MAX1) {
                $ans1 = $next;
            }
            $next = $i - 1 - ($memo[$prev] ?? $i - 1);
            $memo[$prev] = $i - 1;
            $prev = $next;
        }
        $ans2 = $prev;
        return [strval($ans1), strval($ans2)];
    }
}
