<?php

declare(strict_types=1);

namespace TBali\Aoc2020;

use TBali\Aoc\SolutionBase;

/**
 * AoC 2020 Day 6: Custom Customs.
 *
 * Part 1: For each group, count the number of questions to which anyone answered "yes".
 *         What is the sum of those counts?
 * Part 2: Count the number of questions to which everyone answered "yes". What is the sum of those counts?
 *
 * @see https://adventofcode.com/2020/day/6
 */
final class Aoc2020Day06 extends SolutionBase
{
    public const YEAR = 2020;
    public const DAY = 6;
    public const TITLE = 'Custom Customs';
    public const SOLUTIONS = [6291, 3052];
    public const EXAMPLE_SOLUTIONS = [[11, 6]];

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
        // ---------- Process input
        /** @var array<int, array<int, int>> */
        $processedInput = [[]];
        foreach ($input as $line) {
            if (trim($line) == '') {
                $processedInput[] = [];
                continue;
            }
            $processedInput[count($processedInput) - 1][] = trim($line);
        }
        // ---------- Part 1
        $ans1 = array_sum(array_map(
            // count_chars mode = 3: a string containing all unique characters is returned.
            // @phpstan-ignore-next-line
            fn (array $group): int => strlen(count_chars(implode('', $group), 3)),
            $processedInput
        ));
        // ---------- Part 2
        $ans2 = array_sum(array_map(
            // count_chars mode = 1: an array with the byte-value as key and the frequency of every byte as value,
            //      only byte-values with a frequency greater than zero are listed.
            fn (array $group): int => count(array_filter(
                // @phpstan-ignore-next-line
                count_chars(implode('', $group), 1),
                fn (int $value): bool => $value == count($group),
            )),
            $processedInput
        ));
        return [strval($ans1), strval($ans2)];
    }
}
