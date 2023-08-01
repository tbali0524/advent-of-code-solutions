<?php

declare(strict_types=1);

namespace TBali\Aoc2019;

use TBali\Aoc\SolutionBase;

/**
 * AoC 2019 Day 24: Planet of Discord.
 *
 * Part 1: What is the biodiversity rating for the first layout that appears twice?
 * Part 2: Starting with your scan, how many bugs are present after 200 minutes?
 *
 * @see https://adventofcode.com/2019/day/24
 *
 * @todo complete part2
 */
final class Aoc2019Day24 extends SolutionBase
{
    public const YEAR = 2019;
    public const DAY = 24;
    public const TITLE = 'Planet of Discord';
    public const SOLUTIONS = [24662545, 0];
    public const EXAMPLE_SOLUTIONS = [[2129920, 0]];

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
        if ((count($input) != 5) or (strlen($input[0]) != 5)) {
            throw new \Exception('Invalid input');
        }
        $state = intval(bindec(strrev(strtr(implode('', $input), '.#', '01'))));
        // ---------- Part 1
        $ans1 = 0;
        $memo = [];
        while (true) {
            $memo[$state] = true;
            $newState = 0;
            for ($y = 0; $y < 5; ++$y) {
                for ($x = 0; $x < 5; ++$x) {
                    $adjBugs = 0;
                    foreach ([[0, -1], [1, 0], [0, 1], [-1, 0]] as [$dx, $dy]) {
                        $x1 = $x + $dx;
                        $y1 = $y + $dy;
                        if (($x1 < 0) or ($x1 >= 5) or ($y1 < 0) or ($y1 >= 5)) {
                            continue;
                        }
                        if ((($state >> ($y1 * 5 + $x1)) & 1) != 0) {
                            ++$adjBugs;
                        }
                    }
                    $pos = $y * 5 + $x;
                    $old = ($state >> $pos) & 1;
                    if ($old == 0) {
                        $new = ($adjBugs == 1 || $adjBugs == 2 ? 1 : 0);
                    } else {
                        $new = ($adjBugs == 1 ? 1 : 0);
                    }
                    $newState |= ($new << $pos);
                }
            }
            $state = $newState;
            if (isset($memo[$state])) {
                $ans1 = $state;
                break;
            }
        }
        // ---------- Part 2
        $ans2 = 0;
        return [strval($ans1), strval($ans2)];
    }
}
