<?php

declare(strict_types=1);

namespace TBali\Aoc2017;

use TBali\Aoc\SolutionBase;

/**
 * AoC 2017 Day 5: A Maze of Twisty Trampolines, All Alike.
 *
 * Part 1: How many steps does it take to reach the exit?
 * Part 2: How many steps does it now take to reach the exit?
 *
 * @see https://adventofcode.com/2017/day/5
 */
final class Aoc2017Day05 extends SolutionBase
{
    public const YEAR = 2017;
    public const DAY = 5;
    public const TITLE = 'A Maze of Twisty Trampolines, All Alike';
    public const SOLUTIONS = [396086, 28675390];
    public const EXAMPLE_SOLUTIONS = [[5, 10]];

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
        /** @var array<int, int> */
        $data = array_map(intval(...), $input);
        $pc = 0;
        $ans1 = 0;
        while (true) {
            if (($pc < 0) or ($pc >= count($data))) {
                break;
            }
            ++$ans1;
            $delta = $data[$pc];
            ++$data[$pc];
            $pc += $delta;
        }
        // ---------- Part 2
        /** @var array<int, int> */
        $data = array_map(intval(...), $input);
        $pc = 0;
        $ans2 = 0;
        while (true) {
            if (($pc < 0) or ($pc >= count($data))) {
                break;
            }
            ++$ans2;
            $delta = $data[$pc];
            $data[$pc] += ($data[$pc] >= 3 ? -1 : 1);
            $pc += $delta;
        }
        return [strval($ans1), strval($ans2)];
    }
}
