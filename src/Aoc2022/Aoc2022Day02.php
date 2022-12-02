<?php

declare(strict_types=1);

namespace TBali\Aoc2022;

use TBali\Aoc\SolutionBase;

/**
 * AoC 2022 Day 2: Rock Paper Scissors.
 *
 * Part 1: What would your total score be if everything goes exactly according to your strategy guide?
 * Part 2: Following the Elf's instructions for the second column, what would your total score be
 *         if everything goes exactly according to your strategy guide?
 *
 * @see https://adventofcode.com/2022/day/2
 */
final class Aoc2022Day02 extends SolutionBase
{
    public const YEAR = 2022;
    public const DAY = 2;
    public const TITLE = 'Rock Paper Scissors';
    public const SOLUTIONS = [12156, 10835];
    public const EXAMPLE_SOLUTIONS = [[15, 12], [0, 0]];

    private const SHAPE_POINT = ['X' => 1, 'Y' => 2, 'Z' => 3];
    private const OUTCOME = [
        'A' => ['X' => 3, 'Y' => 6, 'Z' => 0],
        'B' => ['X' => 0, 'Y' => 3, 'Z' => 6],
        'C' => ['X' => 6, 'Y' => 0, 'Z' => 3],
    ];
    private const MOVE_NEEDED = [
        'A' => ['X' => 'Z', 'Y' => 'X', 'Z' => 'Y'],
        'B' => ['X' => 'X', 'Y' => 'Y', 'Z' => 'Z'],
        'C' => ['X' => 'Y', 'Y' => 'Z', 'Z' => 'X'],
    ];

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
        $ans1 = 0;
        foreach ($input as $line) {
            $opponentMove = $line[0];
            $myMove = $line[2];
            $ans1 += (self::OUTCOME[$opponentMove][$myMove] ?? 0) + (self::SHAPE_POINT[$myMove] ?? 0);
        }
        // ---------- Part 2
        $ans2 = 0;
        foreach ($input as $line) {
            $opponentMove = $line[0];
            $outcome = $line[2];
            $myMove = self::MOVE_NEEDED[$opponentMove][$outcome] ?? '-';
            $ans2 += (self::OUTCOME[$opponentMove][$myMove] ?? 0) + (self::SHAPE_POINT[$myMove] ?? 0);
        }
        return [strval($ans1), strval($ans2)];
    }
}
