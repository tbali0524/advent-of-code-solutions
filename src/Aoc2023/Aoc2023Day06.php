<?php

declare(strict_types=1);

namespace TBali\Aoc2023;

use TBali\Aoc\SolutionBase;

/**
 * AoC 2023 Day 6: Wait For It.
 *
 * Part 1: Determine the number of ways you could beat the record in each race.
 *         What do you get if you multiply these numbers together?
 * Part 2: How many ways can you beat the record in this one much longer race?
 *
 * @see https://adventofcode.com/2023/day/6
 */
final class Aoc2023Day06 extends SolutionBase
{
    public const YEAR = 2023;
    public const DAY = 6;
    public const TITLE = 'Wait For It';
    public const SOLUTIONS = [3316275, 27102791];
    public const EXAMPLE_SOLUTIONS = [[288, 71503]];

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
        // ---------- Parse input
        if (
            (count($input) != 2)
            or !str_starts_with($input[0], 'Time:      ')
            or !str_starts_with($input[1], 'Distance:  ')
        ) {
            throw new \Exception('Invalid input');
        }
        $parser = static fn (string $line) => array_values(array_map(
            intval(...),
            array_filter(
                array_map(trim(...), explode(' ', substr($line, 11))),
                static fn (string $s): bool => $s != '',
            )
        ));
        $times = $parser($input[0]);
        $distances = $parser($input[1]);
        if (count($times) != count($distances)) {
            throw new \Exception('Invalid input');
        }
        $times[] = intval(str_replace(' ', '', substr($input[0], 11)));
        $distances[] = intval(str_replace(' ', '', substr($input[1], 11)));
        // ---------- Part 1 + 2
        $ans1 = 1;
        $ans2 = 0;
        foreach ($times as $idx => $t) {
            $d = $distances[$idx];
            // solve for: x(t-x)>d
            $discriminant = $t ** 2 - 4 * $d;
            if ($discriminant < 0) {
                $ans1 = 0;
                break;
            }
            $rootDisc = sqrt($discriminant);
            $x1 = ($t - $rootDisc) / 2;
            $x2 = ($t + $rootDisc) / 2;
            if (($x1 <= 0) or ($x2 <= 0)) {
                $ans1 = 0;
                break;
            }
            if (fmod($x1, 1) !== 0.0) {
                $x1 = intval(ceil($x1));
            } else {
                $x1 = intval($x1) + 1;
            }
            if (fmod($x2, 1) !== 0.0) {
                $x2 = intval(floor($x2));
            } else {
                $x2 = intval($x2) - 1;
            }
            if ($x2 < $x1) {
                $ans1 = 0;
                break;
            }
            if ($idx < count($times) - 1) {
                $ans1 *= ($x2 - $x1 + 1);
            } else {
                $ans2 = ($x2 - $x1 + 1);
            }
        }
        return [strval($ans1), strval($ans2)];
    }
}
