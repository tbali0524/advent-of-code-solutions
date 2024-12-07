<?php

declare(strict_types=1);

namespace TBali\Aoc2024;

use TBali\Aoc\SolutionBase;

/**
 * AoC 2024 Day 2: Red-Nosed Reports.
 *
 * @see https://adventofcode.com/2024/day/2
 */
final class Aoc2024Day02 extends SolutionBase
{
    public const YEAR = 2024;
    public const DAY = 2;
    public const TITLE = 'Red-Nosed Reports';
    public const SOLUTIONS = [572, 612];
    public const EXAMPLE_SOLUTIONS = [[2, 4]];

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
        /** @var array<int, array<int, int>> */
        $data = array_map(
            static fn (string $line): array => array_map(intval(...), explode(' ', $line)),
            $input
        );
        // ---------- Part 1
        $ans1 = count(array_filter($data, static fn (array $row): bool => self::isSafe($row)));
        // ---------- Part 2
        $ans2 = 0;
        foreach ($data as $row) {
            if (self::isSafe($row)) {
                ++$ans2;
                continue;
            }
            for ($i = 0; $i < count($row); ++$i) {
                $removed = array_merge(array_slice($row, 0, $i), array_slice($row, $i + 1));
                if (self::isSafe($removed)) {
                    ++$ans2;
                    break;
                }
            }
        }
        return [strval($ans1), strval($ans2)];
    }

    /**
     * @param array<int, int> $row
     */
    private static function isSafe(array $row): bool
    {
        $is_inc = true;
        for ($i = 1; $i < count($row); ++$i) {
            if (($row[$i] - $row[$i - 1] < 1) or ($row[$i] - $row[$i - 1] > 3)) {
                $is_inc = false;
                break;
            }
        }
        if ($is_inc) {
            return true;
        }
        $is_dec = true;
        for ($i = 1; $i < count($row); ++$i) {
            if (($row[$i - 1] - $row[$i] < 1) or ($row[$i - 1] - $row[$i] > 3)) {
                $is_dec = false;
                break;
            }
        }
        return $is_dec;
    }
}
