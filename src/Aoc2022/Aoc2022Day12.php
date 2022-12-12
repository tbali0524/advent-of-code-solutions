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
        // ---------- Part 1
        $ans1 = 0;
        $q = [[$startX, $startY, 0]];
        $visited = [$startX . ' ' . $startY => true];
        $readIdx = 0;
        while (true) {
            if ($readIdx >= count($q)) {
                // @codeCoverageIgnoreStart
                throw new \Exception('No solution found');
                // @codeCoverageIgnoreEnd
            }
            [$x, $y, $step] = $q[$readIdx];
            ++$readIdx;
            if (($x == $targetX) and ($y == $targetY)) {
                $ans1 = $step;
                break;
            }
            $z = ord($input[$y][$x]);
            foreach ([[-1, 0], [0, -1], [1, 0], [0, 1]] as [$dx, $dy]) {
                $x1 = $x + $dx;
                $y1 = $y + $dy;
                if (($x1 < 0) or ($x1 >= $maxX) or ($y1 < 0) or ($y1 >= $maxY)) {
                    continue;
                }
                $z1 = ord($input[$y1][$x1]);
                if ($z1 - $z > 1) {
                    continue;
                }
                $hash = $x1 . ' ' . $y1;
                if (isset($visited[$hash])) {
                    continue;
                }
                $q[] = [$x1, $y1, $step + 1];
                $visited[$hash] = true;
            }
        }
        // ---------- Part 2
        $ans2 = 0;
        $q = [[$targetX, $targetY, 0]];
        $visited = [$targetX . ' ' . $targetY => true];
        $readIdx = 0;
        while (true) {
            if ($readIdx >= count($q)) {
                // @codeCoverageIgnoreStart
                throw new \Exception('No solution found');
                // @codeCoverageIgnoreEnd
            }
            [$x, $y, $step] = $q[$readIdx];
            ++$readIdx;
            $z = ord($input[$y][$x]);
            if ($z == ord('a')) {
                $ans2 = $step;
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
                $hash = $x1 . ' ' . $y1;
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
