<?php

declare(strict_types=1);

namespace TBali\Aoc2017;

use TBali\Aoc\SolutionBase;

/**
 * AoC 2017 Day 4: High-Entropy Passphrases.
 *
 * Part 1: How many passphrases are valid?
 * Part 2: Under this new system policy, how many passphrases are valid?
 *
 * @see https://adventofcode.com/2017/day/4
 */
final class Aoc2017Day04 extends SolutionBase
{
    public const YEAR = 2017;
    public const DAY = 4;
    public const TITLE = 'High-Entropy Passphrases';
    public const SOLUTIONS = [386, 208];
    public const EXAMPLE_SOLUTIONS = [[2, 0], [0, 3]];

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
        $data = array_map(
            fn (string $s): array => explode(' ', $s),
            $input
        );
        $ans1 = count(array_filter(
            $data,
            fn (array $a): bool => $a === array_unique($a),
        ));
        // ---------- Part 2
        $sortedLetters = array_map(
            fn (array $row): array => array_map(
                function (string $s): string {
                    $a = str_split($s);
                    sort($a);
                    return implode('', $a);
                },
                $row
            ),
            $data
        );
        $ans2 = count(array_filter(
            $sortedLetters,
            fn (array $a): bool => $a === array_unique($a),
        ));
        return [strval($ans1), strval($ans2)];
    }
}
