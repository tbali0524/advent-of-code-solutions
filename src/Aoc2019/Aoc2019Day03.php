<?php

declare(strict_types=1);

namespace TBali\Aoc2019;

use TBali\Aoc\SolutionBase;

/**
 * AoC 2019 Day 3: Crossed Wires.
 *
 * Part 1: What is the Manhattan distance from the central port to the closest intersection?
 * Part 2: What is the fewest combined steps the wires must take to reach an intersection?
 *
 * Topics: walking simulation
 *
 * @see https://adventofcode.com/2019/day/3
 */
final class Aoc2019Day03 extends SolutionBase
{
    public const YEAR = 2019;
    public const DAY = 3;
    public const TITLE = 'Crossed Wires';
    public const SOLUTIONS = [245, 48262];
    public const EXAMPLE_SOLUTIONS = [[6, 30], [159, 610], [135, 410]];

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
        $wires = [];
        $wires[0] = explode(',', $input[0]);
        $wires[1] = explode(',', $input[1] ?? '');
        // ---------- Part 1 + 2
        $points = [];
        $steps = [];
        $ans1 = PHP_INT_MAX;
        $ans2 = PHP_INT_MAX;
        foreach ($wires as $idx => $wire) {
            $x = 0;
            $y = 0;
            $step = 0;
            foreach ($wire as $command) {
                [$dx, $dy] = ['U' => [0, -1], 'R' => [1, 0], 'D' => [0, 1], 'L' => [-1, 0]][$command[0]]
                    ?? throw new \Exception('Invalid input');
                $len = intval(substr($command, 1));
                for ($i = 0; $i < $len; ++$i) {
                    ++$step;
                    $x += $dx;
                    $y += $dy;
                    if (!isset($points[$y][$x])) {
                        $points[$y][$x] = $idx;
                        $steps[$y][$x] = $step;
                        continue;
                    }
                    if ($points[$y][$x] == $idx) {
                        continue;
                    }
                    $points[$y][$x] = $idx;
                    $dist = abs($x) + abs($y);
                    $sumStep = $steps[$y][$x] + $step;
                    if ($dist < $ans1) {
                        $ans1 = $dist;
                    }
                    if ($sumStep < $ans2) {
                        $ans2 = $sumStep;
                    }
                }
            }
        }
        return [strval($ans1), strval($ans2)];
    }
}
