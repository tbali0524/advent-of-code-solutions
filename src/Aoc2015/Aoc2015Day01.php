<?php

/*
https://adventofcode.com/2015/day/1
Part 1: To what floor do the instructions take Santa?
Part 2: What is the position of the character that causes Santa to first enter the basement?
*/

declare(strict_types=1);

namespace TBali\Aoc2015;

use TBali\Aoc\SolutionBase;

class Aoc2015Day01 extends SolutionBase
{
    public const YEAR = 2015;
    public const DAY = 1;
    public const TITLE = 'Not Quite Lisp';
    public const SOLUTIONS = [74, 1795];
    public const EXAMPLE_SOLUTIONS = [[-3, 1], [0, 5]];
    public const EXAMPLE_STRING_INPUTS = [')())())', '()())'];

    /**
     * @param string[] $input
     *
     * @return array{string, string}
     */
    public function solve(array $input): array
    {
        $line = $input[0];
        // ---------- Part 1
        $ans1 = substr_count($line, '(') - substr_count($line, ')');
        // ---------- Part 2
        $ans2 = 0;
        $floor = 0;
        while ($ans2 < strlen($line) and ($floor >= 0)) {
            if ($line[$ans2] == '(') {
                ++$floor;
            } elseif ($line[$ans2] == ')') {
                --$floor;
            }
            ++$ans2;
        }
        return [strval($ans1), strval($ans2)];
    }
}
