<?php

declare(strict_types=1);

namespace TBali\Aoc2018;

use TBali\Aoc\SolutionBase;

/**
 * AoC 2018 Day 2: Inventory Management System.
 *
 * Part 1: What is the checksum for your list of box IDs?
 * Part 2: What letters are common between the two correct box IDs?
 *
 * @see https://adventofcode.com/2018/day/2
 */
final class Aoc2018Day02 extends SolutionBase
{
    public const YEAR = 2018;
    public const DAY = 2;
    public const TITLE = 'Inventory Management System';
    public const SOLUTIONS = [7470, 'kqzxdenujwcstybmgvyiofrrd'];
    public const EXAMPLE_SOLUTIONS = [[12, 0], [0, 'fgij']];

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
        $twos = 0;
        $threes = 0;
        foreach ($input as $line) {
            $counts = array_count_values(str_split($line));
            if (in_array(2, $counts, true)) {
                ++$twos;
            }
            if (in_array(3, $counts, true)) {
                ++$threes;
            }
        }
        $ans1 = $twos * $threes;
        // ---------- Part 2
        $ans2 = '';
        foreach ($input as $id1) {
            foreach ($input as $id2) {
                $common = array_intersect_assoc(str_split($id1), str_split($id2));
                if (count($common) == strlen($id1) - 1) {
                    $ans2 = implode('', $common);
                    break 2;
                }
            }
        }
        return [strval($ans1), $ans2];
    }
}
