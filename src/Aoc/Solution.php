<?php

/**
 * Advent of Code - common interface for every solution class.
 */

declare(strict_types=1);

namespace TBali\Aoc;

/**
 * Interface for the SolutionBase abstract class (and thus all the solution classes extending it).
 *
 * - to be implemented through extending the abstract class 'SolutionBase'
 * - interface constants can be overriden in classes only from PHP v8.1
 * - assumption: there is no puzzle with 0 as solution (0 means the expected result is not yet known)
 * - overriding STRING_INPUT is optional: use for single line input puzzles not having an input file
 * - overriding EXAMPLE_SOLUTIONS and EXAMPLE_STRING_INPUTS is optional: use if there are example input(s)
 * - partial example can be also used: leave 1st or 2nd number as 0 in the EXAMPLE_SOLUTIONS
 */
interface Solution
{
    /** @var int */
    public const YEAR = 2014;
    /** @var int */
    public const DAY = 0;
    /** @var string */
    public const TITLE = '';
    /** @var array<int, int|string> */
    public const SOLUTIONS = [0, 0];
    /** @var string */
    public const STRING_INPUT = '';
    /** @var array<int, array<int, int|string>> */
    public const EXAMPLE_SOLUTIONS = [];
    /** @var array<int, string> */
    public const EXAMPLE_STRING_INPUTS = [''];
    /** @var array<int, array<int, int|string>> */
    public const LARGE_SOLUTIONS = [];

    /**
     * This method must be implemented in the specific solution classes.
     *
     * @param array<int, string> $input The lines of the input, without LF
     *
     * @return array<int, string> The answers for Part 1 and Part 2 (as strings)
     *
     * @phpstan-param non-empty-array<int, string> $input
     *
     * @phpstan-return array{string, string}
     */
    public function solve(array $input): array;

    /**
     * The main runner engine.
     *
     * Implemented in abstract class SolutionBase.
     * Calls readInput() (only if needed) and solve() for all examples, then for the puzzle itself, outputs results.
     *
     * @return bool did all tests pass?
     */
    public function run(): bool;

    /**
     * Read a file into an array of lines (without LF).
     *
     * Implemented in the abstract class SolutionBase.
     *
     * @return array<int, string>
     *
     * @phpstan-return non-empty-array<int, string>
     *
     * @throws \Exception
     */
    public static function readInput(string $fileName): array;
}
