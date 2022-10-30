<?php

/**
 * Advent of Code - common interface for every solution class, implemented through the abstract class SolutionBase.
 */

declare(strict_types=1);

namespace TBali\Aoc;

interface Solution
{
    // note: interface constants can be overriden in classes only from PHP v8.1
    public const YEAR = 2014;
    public const DAY = 0;
    public const TITLE = '';
    public const SOLUTIONS = [0, 0]; // note: runner assumes there is no puzzle with 0 as solution
    public const STRING_INPUT = ''; // optional, for single line input puzzles not having an input file
    public const EXAMPLE_SOLUTIONS = [[0, 0], [0, 0]]; // optional, 0 meaning no example is given
    public const EXAMPLE_STRING_INPUTS = ['', ''];

    public function run(): bool;

    /**
     * @param string[] $input
     *
     * @return array{string, string}
     */
    public function solve(array $input): array;

    /** @return string[] */
    public static function readInput(string $fileName): array;
}
