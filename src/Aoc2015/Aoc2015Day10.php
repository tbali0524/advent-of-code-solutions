<?php

/*
https://adventofcode.com/2015/day/10
Part 1: Apply this process 40 times. What is the length of the result?
Part 2: Apply this process 50 times. What is the length of the new result?
Topics: Conway's look-and-say sequence, simulation
*/

declare(strict_types=1);

namespace TBali\Aoc2015;

use TBali\Aoc\SolutionBase;

final class Aoc2015Day10 extends SolutionBase
{
    public const YEAR = 2015;
    public const DAY = 10;
    public const TITLE = 'Elves Look, Elves Say';
    public const SOLUTIONS = [360154, 5103798];
    public const STRING_INPUT = '1113122113';
    public const EXAMPLE_SOLUTIONS = [[6, 0], [0, 0]];
    public const EXAMPLE_STRING_INPUTS = ['1', ''];

    private const MAX1 = 40;
    private const MAX2 = 50;
    private const EXAMPLE_MAX = 5;

    /**
     * @param string[] $input
     *
     * @return array{string, string}
     */
    public function solve(array $input): array
    {
        $input = $input[0];
        // ---------- Part 1 + 2
        $ans_example = 0;
        $ans1 = 0;
        $prev = $input;
        for ($i = 0; $i < self::MAX2; ++$i) {
            if ($i == self::EXAMPLE_MAX) {
                $ans_example = strlen($prev);
            }
            if ($i == self::MAX1) {
                $ans1 = strlen($prev);
            }
            $next = '';
            $start = 0;
            while ($start < strlen($prev)) {
                $end = $start + 1;
                while (($end < strlen($prev)) and ($prev[$end] == $prev[$start])) {
                    ++$end;
                }
                $next .= strval($end - $start) . $prev[$start];
                $start = $end;
            }
            $prev = $next;
        }
        $ans2 = strlen($next);
        // detect puzzle example as input
        if ($input == '1') {
            return [strval($ans_example), '0'];
        }
        return [strval($ans1), strval($ans2)];
    }
}
