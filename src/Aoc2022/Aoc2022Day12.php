<?php

declare(strict_types=1);

namespace TBali\Aoc2022;

use TBali\Aoc\SolutionBase;

/**
 * AoC 2022 Day 12: Hill Climbing Algorithm.
 *
 * Part 1: What is the fewest steps required to move from your current position to the location
 *         that should get the best signal?
 * Part 2: What is the fewest steps required to move starting from any square with elevation a to the location
 *         that should get the best signal?
 *
 * Topics: BFS
 *
 * @see https://adventofcode.com/2022/day/12
 */
final class Aoc2022Day12 extends SolutionBase
{
    public const YEAR = 2022;
    public const DAY = 12;
    public const TITLE = 'Hill Climbing Algorithm';
    public const SOLUTIONS = [412, 402];
    public const EXAMPLE_SOLUTIONS = [[31, 29], [0, 0]];
    // large input #2 takes ~0.5 mins, so skipped
    // public const LARGE_SOLUTIONS = [[1299999, 1200001]];
    // public const LARGE_SOLUTIONS = [[1299999, 1200001], [12999999, 12000001]];

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
        $maxX = strlen($input[0] ?? '');
        $maxY = count($input);
        $startY = -1;
        $startX = 0;
        $targetY = -1;
        $targetX = 0;
        foreach ($input as $y => $line) {
            $pos = strpos($line, 'S');
            if ($pos !== false) {
                $startX = $pos;
                $startY = $y;
                $input[$y][$pos] = 'a';
            }
            $pos = strpos($line, 'E');
            if ($pos !== false) {
                $targetX = $pos;
                $targetY = $y;
                $input[$y][$pos] = 'z';
            }
        }
        if (($startY < 0) or ($targetY < 0)) {
            throw new \Exception('Invalid input');
        }
        // ---------- Part 1 + 2
        $ans1 = -1;
        $ans2 = -1;
        $q = [[$targetX, $targetY, 0]];
        $hash = ($targetX | ($targetY << 32));
        $visited = [$hash => true];
        $readIdx = 0;
        while (true) {
            if ($readIdx >= count($q)) {
                throw new \Exception('No solution found');
            }
            [$x, $y, $step] = $q[$readIdx];
            ++$readIdx;
            if (($ans1 < 0) and ($x == $startX) and ($y == $startY)) {
                $ans1 = $step;
            }
            $z = ord($input[$y][$x]);
            if (($ans2 < 0) and ($z == ord('a'))) {
                $ans2 = $step;
            }
            if (($ans1 >= 0) and ($ans2 >= 0)) {
                break;
            }
            foreach ([[-1, 0], [0, -1], [1, 0], [0, 1]] as [$dx, $dy]) {
                $x1 = $x + $dx;
                $y1 = $y + $dy;
                if (($x1 < 0) or ($x1 >= $maxX) or ($y1 < 0) or ($y1 >= $maxY)) {
                    continue;
                }
                $z1 = ord($input[$y1][$x1]);
                if ($z - $z1 > 1) {
                    continue;
                }
                $hash = $x1 | ($y1 << 32);
                if (isset($visited[$hash])) {
                    continue;
                }
                $q[] = [$x1, $y1, $step + 1];
                $visited[$hash] = true;
            }
        }
        return [strval($ans1), strval($ans2)];
    }
}
