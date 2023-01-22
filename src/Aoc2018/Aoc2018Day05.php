<?php

declare(strict_types=1);

namespace TBali\Aoc2018;

use TBali\Aoc\SolutionBase;

/**
 * AoC 2018 Day 5: Alchemical Reduction.
 *
 * Part 1: How many units remain after fully reacting the polymer you scanned?
 * Part 2: What is the length of the shortest polymer you can produce by removing all units of exactly one type
 *         and fully reacting the result?
 *
 * @see https://adventofcode.com/2018/day/5
 */
final class Aoc2018Day05 extends SolutionBase
{
    public const YEAR = 2018;
    public const DAY = 5;
    public const TITLE = 'Alchemical Reduction';
    public const SOLUTIONS = [10638, 4944];
    public const EXAMPLE_SOLUTIONS = [[10, 4]];

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
        $poly = $input[0];
        // ---------- Part 1
        $ans1 = strlen($this->reducePolymer($poly));
        // ---------- Part 2
        $ans2 = PHP_INT_MAX;
        for ($i = 0; $i < 26; ++$i) {
            $modPoly = strtr($poly, [chr(ord('a') + $i) => '', chr(ord('A') + $i) => '']);
            $ans2 = intval(min($ans2, strlen($this->reducePolymer($modPoly))));
        }
        return [strval($ans1), strval($ans2)];
    }

    private function reducePolymer(string $poly): string
    {
        $difGoal = abs(ord('a') - ord('A'));
        $newPoly = '';
        for ($i = 0; $i < strlen($poly); ++$i) {
            $newPoly .= $poly[$i];
            $last = strlen($newPoly) - 1;
            while ($last > 0) {
                if (abs(ord($newPoly[$last]) - ord($newPoly[$last - 1])) != $difGoal) {
                    break;
                }
                $last -= 2;
            }
            $newPoly = substr($newPoly, 0, $last + 1);
        }
        return $newPoly;
    }
}
