<?php

// @TODO Part2

/*
https://adventofcode.com/2020/day/13
Part 1: What is the ID of the earliest bus you can take to the airport
    multiplied by the number of minutes you'll need to wait for that bus?
Part 2: What is the earliest timestamp such that all of the listed bus IDs depart at offsets
    matching their positions in the list?
*/

declare(strict_types=1);

namespace TBali\Aoc2020;

use TBali\Aoc\SolutionBase;

final class Aoc2020Day13 extends SolutionBase
{
    public const YEAR = 2020;
    public const DAY = 13;
    public const TITLE = 'Shuttle Search';
    public const SOLUTIONS = [261, 0];
    public const EXAMPLE_SOLUTIONS = [[295, 0], [0, 0]];

    /**
     * @param string[] $input
     *
     * @return array{string, string}
     */
    public function solve(array $input): array
    {
        if (count($input) != 2) {
            throw new \Exception('Invalid input');
        }
        $time = intval($input[0]);
        // ---------- Part 1
        $buses = $input = array_map(
            'intval',
            array_filter(
                explode(',', $input[1]),
                fn ($x) => $x != 'x'
            )
        );
        $idToWait = array_combine(
            $buses,
            array_map(
                fn ($x) => ($x - ($time % $x)) % $x,
                $buses
            )
        );
        asort($idToWait);
        $id = array_key_first($idToWait);
        $ans1 = $id * $idToWait[$id];
        // ---------- Part 2
        $ans2 = 0;
        return [strval($ans1), strval($ans2)];
    }
}
