<?php

declare(strict_types=1);

namespace TBali\Aoc2016;

use TBali\Aoc\SolutionBase;

/**
 * AoC 2016 Day 13: A Maze of Twisty Little Cubicles.
 *
 * Part 1: What is the fewest number of steps required for you to reach 31,39?
 * Part 2: How many locations (distinct x,y coordinates, including your starting location)
 *         can you reach in at most 50 steps?
 *
 * Topics: BFS
 *
 * @see https://adventofcode.com/2016/day/13
 */
final class Aoc2016Day13 extends SolutionBase
{
    public const YEAR = 2016;
    public const DAY = 13;
    public const TITLE = 'A Maze of Twisty Little Cubicles';
    public const SOLUTIONS = [92, 124];
    public const STRING_INPUT = '1350';
    public const EXAMPLE_SOLUTIONS = [[11, 0]];
    public const EXAMPLE_STRING_INPUTS = ['10', ''];

    private const MAX_STEPS = 50;

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
        $salt = intval($input[0] ?? 0);
        // ---------- Part 1 + 2
        $ans1 = -1;
        $ans2 = -1;
        $targetX = 31;
        $targetY = 39;
        // detect example input
        if ($salt == 10) {
            $targetX = 7;
            $targetY = 4;
        }
        $x = 1;
        $y = 1;
        $hash = ($y << 32) | $x;
        $visited = [$hash => true];
        $q = [[$x, $y, 0]];
        $readIdx = 0;
        while (true) {
            if ($readIdx >= count($q)) {
                // @codeCoverageIgnoreStart
                throw new \Exception('No solution found');
                // @codeCoverageIgnoreEnd
            }
            [$x, $y, $step] = $q[$readIdx];
            if (($step > self::MAX_STEPS) and ($ans2 < 0)) {
                $ans2 = $readIdx;
                if ($ans1 >= 0) {
                    break;
                }
            }
            ++$readIdx;
            if (($x == $targetX) and ($y == $targetY)) {
                $ans1 = $step;
                if ($step > self::MAX_STEPS) {
                    break;
                }
            }
            foreach ([[-1, 0], [0, -1], [1, 0], [0, 1]] as [$dx, $dy]) {
                [$x1, $y1] = [$x + $dx, $y + $dy];
                $hash = ($y1 << 32) | $x1;
                if (isset($visited[$hash])) {
                    continue;
                }
                if ($this->isWall($x1, $y1, $salt)) {
                    continue;
                }
                $q[] = [$x1, $y1, $step + 1];
                $visited[$hash] = true;
            }
        }
        return [strval($ans1), strval($ans2)];
    }

    private function isWall(int $x, int $y, int $salt): bool
    {
        if (($x < 0) or ($y < 0)) {
            return true;
        }
        $n = $x * $x + 3 * $x + 2 * $x * $y + $y + $y * $y + $salt;
        $count = 0;
        while ($n > 0) {
            if (($n & 1) == 1) {
                ++$count;
            }
            $n >>= 1;
        }
        return $count % 2 == 1;
    }
}
