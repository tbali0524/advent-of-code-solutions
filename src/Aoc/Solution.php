<?php

/**
 * Advent of Code - common interface for every solution class.
 *
 * To be implemented through extending the abstract class 'SolutionBase'.
 */

declare(strict_types=1);

namespace TBali\Aoc;

/**
 * Interface for the SolutionBase abstract class (and thus all the solution classes extending it).
 *
 * - interface constants can be overriden in classes only from PHP v8.1
 * - assumption: there is no puzzle with 0 as solution (0 means the expected result is not yet known)
 * - overriding STRING_INPUT is optional: for single line input puzzles not having an input file
 * - overriding EXAMPLE_SOLUTIONS and EXAMPLE_STRING_INPUTS is optional: if there are example input(s)
 * - partial example can be also used: leave 1st or 2nd number 0 in the EXAMPLE_SOLUTION
 */
interface Solution
{
    public const YEAR = 2014;
    public const DAY = 0;
    public const TITLE = '';
    public const SOLUTIONS = [0, 0];
    public const STRING_INPUT = '';
    public const EXAMPLE_SOLUTIONS = [[0, 0], [0, 0]];
    public const EXAMPLE_STRING_INPUTS = ['', ''];

    /**
     * This method must be implemented in the specific solution classes.
     *
     * @param string[] $input
     *
     * @return array{string, string} The answers for part 1 and Part 2 (as strings)
     */
    public function solve(array $input): array;

    /**
     * The main runner engine.
     *
     * Implemented in abstract class SolutionBase.
     * Calls readInput (if needed) and solve() for all examples and for the puzzle itself, outputs results.
     * Returns true if all tests passed.
     */
    public function run(): bool;

    /**
     * Implemented in abstract class SolutionBase.
     *
     * @return string[]
     */
    public static function readInput(string $fileName): array;
}
