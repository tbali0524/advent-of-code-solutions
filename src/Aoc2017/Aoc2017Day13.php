<?php

declare(strict_types=1);

namespace TBali\Aoc2017;

use TBali\Aoc\SolutionBase;

/**
 * AoC 2017 Day 13: Packet Scanners.
 *
 * Part 1: If you leave immediately, what is the severity of your whole trip?
 * Part 2: What is the fewest number of picoseconds that you need to delay the packet to pass through the firewall
 *         without being caught?
 *
 * @see https://adventofcode.com/2017/day/13
 */
final class Aoc2017Day13 extends SolutionBase
{
    public const YEAR = 2017;
    public const DAY = 13;
    public const TITLE = 'Packet Scanners';
    public const SOLUTIONS = [1728, 3946838];
    public const EXAMPLE_SOLUTIONS = [[24, 10]];

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
        $scanners = [];
        foreach ($input as $line) {
            $a = explode(': ', $line);
            if (count($a) != 2) {
                throw new \Exception('Invalid input');
            }
            $scanners[intval($a[0])] = intval($a[1]);
        }
        // ---------- Part 1
        $ans1 = 0;
        foreach ($scanners as $depth => $range) {
            if ($depth % (2 * ($range - 1)) == 0) {
                $ans1 += $depth * $range;
            }
        }
        // ---------- Part 2
        $ans2 = 0;
        while (true) {
            $isOk = true;
            foreach ($scanners as $depth => $range) {
                if (($depth + $ans2) % (2 * ($range - 1)) == 0) {
                    $isOk = false;
                    break;
                }
            }
            if ($isOk) {
                break;
            }
            ++$ans2;
        }
        return [strval($ans1), strval($ans2)];
    }
}
