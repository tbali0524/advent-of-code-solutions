<?php

declare(strict_types=1);

namespace TBali\Aoc2016;

use TBali\Aoc\SolutionBase;

/**
 * AoC 2016 Day 18: Like a Rogue.
 *
 * Part 1: Starting with the map in your puzzle input, in a total of 40 rows (including the starting row),
 *         how many safe tiles are there?
 * Part 2: How many safe tiles are there in a total of 400000 rows?
 *
 * @see https://adventofcode.com/2016/day/18
 */
final class Aoc2016Day18 extends SolutionBase
{
    public const YEAR = 2016;
    public const DAY = 18;
    public const TITLE = 'Like a Rogue';
    public const SOLUTIONS = [1913, 19993564];
    public const EXAMPLE_SOLUTIONS = [[6, 0], [38, 0]];

    private const EXAMPLE1_MAX_ROW = 3;
    private const EXAMPLE2_MAX_ROW = 10;
    private const PART1_MAX_ROW = 40;
    private const PART2_MAX_ROW = 400_000;

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
        // ---------- Part 1
        $row = $input[0] ?? '';
        if (strlen($row) == 5) {
            $maxRow1 = self::EXAMPLE1_MAX_ROW;
        } elseif (strlen($row) == 10) {
            $maxRow1 = self::EXAMPLE2_MAX_ROW;
        } else {
            // @codeCoverageIgnoreStart
            $maxRow1 = self::PART1_MAX_ROW;
            // @codeCoverageIgnoreEnd
        }
        $ans1 = $this->solvePart($row, $maxRow1);
        if ($maxRow1 != self::PART1_MAX_ROW) {
            return [strval($ans1), '0'];
        }
        // @codeCoverageIgnoreStart
        $maxRow2 = self::PART2_MAX_ROW;
        $ans2 = $this->solvePart($row, $maxRow2);
        return [strval($ans1), strval($ans2)];
        // @codeCoverageIgnoreEnd
    }

    private function solvePart(string $row, int $maxRow): int
    {
        $ans = substr_count($row, '.');
        for ($i = 1; $i < $maxRow; ++$i) {
            $next = '';
            for ($j = 0; $j < strlen($row); ++$j) {
                $left = $j > 0 && $row[$j - 1] == '^';
                $center = $row[$j] == '^';
                $right = $j < strlen($row) - 1 && $row[$j + 1] == '^';
                $isTrap = (
                    ($left && $center && !$right)
                    || (!$left && $center && $right)
                    || ($left && !$center && !$right)
                    || (!$left && !$center && $right)
                );
                $next .= $isTrap ? '^' : '.';
            }
            $row = $next;
            $ans += substr_count($row, '.');
        }
        return $ans;
    }
}
