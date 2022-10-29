<?php

/**
 * Advent of Code - common interface for every solution class, implemented through an abstract base class
 */

declare(strict_types=1);

namespace TBali\Aoc;

interface Solution
{
    // interface constants can be overriden in classes from PHP v8.1
    public const YEAR = 2014;
    public const DAY = 0;
    public const TITLE = '';
    public const SOLUTIONS = [0, 0];
    public const STRING_INPUT = '';
    public const EXAMPLE_SOLUTIONS = [[0, 0], [0, 0]];
    public const EXAMPLE_STRING_INPUTS = ['', ''];

    public function run(): bool;

    /** @return string[] */
    public function readInput(string $fileName): array;

    /**
     * @param string[] $input
     *
     * @return array{string, string}
     */
    public function solve(array $rawInput): array;

    /**
     * @param string[]
     *
     * @return int[]
     */
    public static function intArray(array $input): array;
}
