<?php

declare(strict_types=1);

namespace TBali\Aoc2018;

use TBali\Aoc\SolutionBase;

/**
 * AoC 2018 Day 22: Mode Maze.
 *
 * Part 1: What is the total risk level for the smallest rectangle that includes 0,0 and the target's coordinates?
 * Part 2: What is the fewest number of minutes you can take to reach the target?
 *
 * Topics: pathfinding
 *
 * @see https://adventofcode.com/2018/day/22
 *
 * @todo complete part 2
 */
final class Aoc2018Day22 extends SolutionBase
{
    public const YEAR = 2018;
    public const DAY = 22;
    public const TITLE = 'Mode Maze';
    public const SOLUTIONS = [7299, 0];
    public const EXAMPLE_SOLUTIONS = [[114, 45]];

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
        $count1 = sscanf($input[0], 'depth: %d', $depth);
        /** @var int $depth */
        $count2 = sscanf($input[1] ?? '', 'target: %d,%d', $targetX, $targetY);
        // @var int $targetX
        // @var int $targetY
        if (($count1 != 1) or ($count2 != 2)) {
            throw new \Exception('Invalid input');
        }
        // ---------- Part 1
        $ans1 = 0;
        $erosions = [];
        for ($y = 0; $y <= $targetY; ++$y) {
            for ($x = 0; $x <= $targetX; ++$x) {
                if (($x == $targetX) and ($y == $targetY)) {
                    $geologic = 0;
                } elseif ($y == 0) {
                    $geologic = $x * 16807;
                } elseif ($x == 0) {
                    $geologic = $y * 48271;
                } else {
                    $geologic = $erosions[$y - 1][$x] * $erosions[$y][$x - 1];
                }
                $erosions[$y][$x] = ($geologic + $depth) % 20183;
                $ans1 += $erosions[$y][$x] % 3;
            }
        }
        // ---------- Part 2
        $ans2 = 0;
        return [strval($ans1), strval($ans2)];
    }
}
