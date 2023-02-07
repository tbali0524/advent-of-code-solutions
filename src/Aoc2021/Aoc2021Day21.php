<?php

declare(strict_types=1);

namespace TBali\Aoc2021;

use TBali\Aoc\SolutionBase;

/**
 * AoC 2021 Day 21: Dirac Dice.
 *
 * Part 1: What do you get if you multiply the score of the losing player
 *         by the number of times the die was rolled during the game?
 * Part 2:
 *
 * @see https://adventofcode.com/2021/day/21
 *
 * @todo complete
 *
 * @codeCoverageIgnore
 */
final class Aoc2021Day21 extends SolutionBase
{
    public const YEAR = 2021;
    public const DAY = 21;
    public const TITLE = 'Dirac Dice';
    public const SOLUTIONS = [739785, 0];

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
        // ---------- Part 2
        $ans2 = 0;
        return [strval($ans1), strval($ans2)];
    }
}
