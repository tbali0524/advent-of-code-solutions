<?php

declare(strict_types=1);

namespace TBali\Aoc2017;

use TBali\Aoc\SolutionBase;

/**
 * AoC 2017 Day 2: Corruption Checksum.
 *
 * Part 1: What is the checksum for the spreadsheet in your puzzle input?
 * Part 2: What is the sum of each row's result in your puzzle input?
 *
 * @see https://adventofcode.com/2017/day/2
 */
final class Aoc2017Day02 extends SolutionBase
{
    public const YEAR = 2017;
    public const DAY = 2;
    public const TITLE = 'Corruption Checksum';
    public const SOLUTIONS = [48357, 351];
    public const EXAMPLE_SOLUTIONS = [[18, 0], [0, 9]];

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
        /** @var array<int, array<int, int>> */
        $data = array_map(
            fn (string $s): array => array_map('intval', explode("\t", $s)),
            $input
        );
        // ---------- Part 1
        $ans1 = array_sum(array_map(fn (array $a): int => max($a) - min($a), $data));
        // ---------- Part 2
        $ans2 = 0;
        foreach ($data as $row) {
            rsort($row);
            for ($i = 0; $i < count($row) - 1; ++$i) {
                for ($j = $i + 1; $j < count($row); ++$j) {
                    if (($row[$j] != 0) and ($row[$i] % $row[$j] == 0)) {
                        $ans2 += intdiv($row[$i], $row[$j]);
                        break 2;
                    }
                }
            }
        }
        return [strval($ans1), strval($ans2)];
    }
}
