<?php

declare(strict_types=1);

namespace TBali\Aoc2017;

use TBali\Aoc\SolutionBase;

/**
 * AoC 2017 Day 22: Sporifica Virus.
 *
 * Part 1: Given your actual map, after 10000 bursts of activity, how many bursts cause a node to become infected?
 * Part 2: Given your actual map, after 10000000 bursts of activity, how many bursts cause a node to become infected?
 *
 * Topics: walking simulation
 *
 * @see https://adventofcode.com/2017/day/22
 */
final class Aoc2017Day22 extends SolutionBase
{
    public const YEAR = 2017;
    public const DAY = 22;
    public const TITLE = 'Sporifica Virus';
    public const SOLUTIONS = [5538, 2511090];
    public const EXAMPLE_SOLUTIONS = [[5587, 2511944]];

    private const MAX_BURSTS_PART1 = 10_000;
    private const MAX_BURSTS_PART2 = 10_000_000;
    private const DIRS = [[0, -1], [1, 0], [0, 1], [-1, 0]]; // dir == 0 must be up, list in clockwise order
    private const CLEAN = 0;
    // private const WEAKENED = 1;
    private const INFECTED = 2;
    // private const FLAGGED = 3;

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
        $startNodes = [];
        $delta = intdiv(count($input), 2);
        foreach ($input as $idx => $line) {
            for ($i = 0; $i < strlen($line); ++$i) {
                if ($line[$i] == '#') {
                    $startNodes[strval($idx - $delta) . ' ' . strval($i - $delta)] = self::INFECTED;
                }
            }
        }
        // ---------- Part 1
        $ans1 = 0;
        $nodes = $startNodes;
        $x = 0;
        $y = 0;
        $dir = 0;
        for ($step = 0; $step < self::MAX_BURSTS_PART1; ++$step) {
            $hash = strval($y) . ' ' . strval($x);
            if (isset($nodes[$hash])) {
                $ddir = 1;
                unset($nodes[$hash]);
            } else {
                $ddir = -1;
                $nodes[$hash] = self::INFECTED;
                ++$ans1;
            }
            $dir = ($dir + $ddir + 4) % 4;
            [$dx, $dy] = self::DIRS[$dir];
            $x += $dx;
            $y += $dy;
        }
        // ---------- Part 2
        $ans2 = 0;
        $nodes = $startNodes;
        $x = 0;
        $y = 0;
        $dir = 0;
        for ($step = 0; $step < self::MAX_BURSTS_PART2; ++$step) {
            $hash = strval($y) . ' ' . strval($x);
            $state = $nodes[$hash] ?? self::CLEAN;
            $ddir = $state - 1;
            $state = ($state + 1) % 4;
            if ($state == self::CLEAN) {
                unset($nodes[$hash]);
            } else {
                $nodes[$hash] = $state;
                if ($state == self::INFECTED) {
                    ++$ans2;
                }
            }
            $dir = ($dir + $ddir + 4) % 4;
            [$dx, $dy] = self::DIRS[$dir];
            $x += $dx;
            $y += $dy;
        }
        return [strval($ans1), strval($ans2)];
    }
}
