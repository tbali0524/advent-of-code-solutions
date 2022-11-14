<?php

declare(strict_types=1);

namespace TBali\Aoc2016;

use TBali\Aoc\SolutionBase;

/**
 * AoC 2016 Day 24: Air Duct Spelunking.
 *
 * Part 1: What is the fewest number of steps required to visit every non-0 number marked on the map at least once?
 * Part 2: What is the fewest number of steps required to start at 0,
 *         visit every non-0 number marked on the map at least once, and then return to 0?
 *
 * Topics: BFS
 *
 * @see https://adventofcode.com/2016/day/24
 */
final class Aoc2016Day24 extends SolutionBase
{
    public const YEAR = 2016;
    public const DAY = 24;
    public const TITLE = 'Air Duct Spelunking';
    public const SOLUTIONS = [502, 724];
    public const EXAMPLE_SOLUTIONS = [[14, 20], [0, 0]];

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
        // ---------- Part 1 + 2
        $startX = -1;
        $startY = -1;
        $targets = '';
        foreach ($input as $y => $line) {
            foreach (str_split($line) as $x => $c) {
                if (($c == '#') or ($c == '.')) {
                    continue;
                }
                if ($c == '0') {
                    $startX = $x;
                    $startY = $y;
                    continue;
                }
                $targets .= $c;
            }
        }
        if (($startX < 0) or (strlen($targets) == 0) or (strlen($targets) > 16)) {
            throw new \Exception('Invalid input');
        }
        $ans1 = -1;
        $ans2 = -1;
        $hash = ($startY << 32) | ($startX << 16);
        $visited = [$hash => true];
        $q = [[$startX, $startY, 0, 0]];
        $readIdx = 0;
        while (true) {
            if ($readIdx >= count($q)) {
                throw new \Exception('No solution found');
            }
            [$x, $y, $mask, $step] = $q[$readIdx];
            ++$readIdx;
            if ($mask == (1 << strlen($targets)) - 1) {
                if ($ans1 < 0) {
                    $ans1 = $step;
                }
                if (($ans2 < 0) and ($x == $startX) and ($y == $startY)) {
                    $ans2 = $step;
                    break;
                }
            }
            foreach ([[-1, 0], [0, -1], [1, 0], [0, 1]] as [$dx, $dy]) {
                [$x1, $y1] = [$x + $dx, $y + $dy];
                if (!isset($input[$y1][$x1]) or ($input[$y1][$x1] == '#')) {
                    continue;
                }
                $mask1 = $mask;
                if (($input[$y1][$x1] != '.') and ($input[$y1][$x1] != '0')) {
                    $mask1 |= (1 << (intval($input[$y1][$x1]) - 1));
                }
                $hash = ($y1 << 32) | ($x1 << 16) | $mask1;
                if (isset($visited[$hash])) {
                    continue;
                }
                $q[] = [$x1, $y1, $mask1, $step + 1];
                $visited[$hash] = true;
            }
        }
        return [strval($ans1), strval($ans2)];
    }
}
