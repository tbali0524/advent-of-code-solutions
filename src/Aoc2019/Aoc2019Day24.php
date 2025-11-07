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
 */
final class Aoc2019Day24 extends SolutionBase
{
    public const YEAR = 2019;
    public const DAY = 24;
    public const TITLE = 'Planet of Discord';
    public const SOLUTIONS = [24662545, 2063];
    public const EXAMPLE_SOLUTIONS = [[2129920, 99]];

    private const MAX_STEPS_PART2 = 200;
    private const MAX_STEPS_PART2_EXAMPLE = 10;
    private const ADJ_LIST = [
        // id => [[id, level]]
        1 => [[8, -1], [2, 0], [6, 0], [12, -1]],
        2 => [[8, -1], [3, 0], [7, 0], [1, 0]],
        3 => [[8, -1], [4, 0], [8, 0], [2, 0]],
        4 => [[8, -1], [5, 0], [9, 0], [3, 0]],
        5 => [[8, -1], [14, -1], [10, 0], [4, 0]],
        6 => [[1, 0], [7, 0], [11, 0], [12, -1]],
        7 => [[2, 0], [8, 0], [12, 0], [6, 0]],
        8 => [[3, 0], [9, 0], [1, 1], [2, 1], [3, 1], [4, 1], [5, 1], [7, 0]],
        9 => [[4, 0], [10, 0], [14, 0], [8, 0]],
        10 => [[5, 0], [14, -1], [15, 0], [9, 0]],
        11 => [[6, 0], [12, 0], [16, 0], [12, -1]],
        12 => [[7, 0], [1, 1], [6, 1], [11, 1], [16, 1], [21, 1], [17, 0], [11, 0]],
        13 => [],
        14 => [[9, 0], [15, 0], [19, 0], [5, 1], [10, 1], [15, 1], [20, 1], [25, 1]],
        15 => [[10, 0], [14, -1], [20, 0], [14, 0]],
        16 => [[11, 0], [17, 0], [21, 0], [12, -1]],
        17 => [[12, 0], [18, 0], [22, 0], [16, 0]],
        18 => [[21, 1], [22, 1], [23, 1], [24, 1], [25, 1], [19, 0], [23, 0], [17, 0]],
        19 => [[14, 0], [20, 0], [24, 0], [18, 0]],
        20 => [[15, 0], [14, -1], [25, 0], [19, 0]],
        21 => [[16, 0], [22, 0], [18, -1], [12, -1]],
        22 => [[17, 0], [23, 0], [18, -1], [21, 0]],
        23 => [[18, 0], [24, 0], [18, -1], [22, 0]],
        24 => [[19, 0], [25, 0], [18, -1], [23, 0]],
        25 => [[20, 0], [14, -1], [18, -1], [24, 0]],
    ];

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
        $startState = intval(bindec(strrev(strtr(implode('', $input), '.#', '01'))));
        // ---------- Part 1
        $ans1 = 0;
        $state = $startState;
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
                        $new = $adjBugs == 1 || $adjBugs == 2 ? 1 : 0;
                    } else {
                        $new = $adjBugs == 1 ? 1 : 0;
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
        $bugs = [];
        for ($i = 0; $i < 25; ++$i) {
            if ((($startState >> $i) & 1) != 0) {
                $bugs[] = [$i + 1, 0];
            }
        }
        if (count($bugs) == 8) {
            $maxSteps = self::MAX_STEPS_PART2_EXAMPLE;
        } else {
            $maxSteps = self::MAX_STEPS_PART2;
        }
        for ($step = 1; $step <= $maxSteps; ++$step) {
            $hasBug = [];
            foreach ($bugs as [$tile, $level]) {
                $hasBug[$level][$tile] = true;
            }
            $newBugs = [];
            for ($level = -$step; $level <= $step; ++$level) {
                for ($tile = 1; $tile <= 25; ++$tile) {
                    if ($tile == 13) {
                        continue;
                    }
                    $adjBugs = 0;
                    foreach (self::ADJ_LIST[$tile] as [$adjTile, $deltaLevel]) {
                        if (isset($hasBug[$level + $deltaLevel][$adjTile])) {
                            ++$adjBugs;
                        }
                    }
                    if (!isset($hasBug[$level][$tile])) {
                        $newBug = ($adjBugs == 1 || $adjBugs == 2);
                    } else {
                        $newBug = ($adjBugs == 1);
                    }
                    if ($newBug) {
                        $newBugs[] = [$tile, $level];
                    }
                }
            }
            $bugs = $newBugs;
        }
        $ans2 = count($bugs);
        return [strval($ans1), strval($ans2)];
    }
}
