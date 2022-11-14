<?php

// phpcs:disable PSR1.Classes.ClassDeclaration.MultipleClasses

declare(strict_types=1);

namespace TBali\Aoc2016;

use TBali\Aoc\SolutionBase;

/**
 * AoC 2016 Day 20: Firewall Rules.
 *
 * Part 1: Given the list of blocked IPs you retrieved from the firewall (your puzzle input),
 *         what is the lowest-valued IP that is not blocked?
 * Part 2: How many IPs are allowed by the blacklist?
 *
 * @see https://adventofcode.com/2016/day/20
 */
final class Aoc2016Day20 extends SolutionBase
{
    public const YEAR = 2016;
    public const DAY = 20;
    public const TITLE = 'Firewall Rules';
    public const SOLUTIONS = [19449262, 119];
    public const EXAMPLE_SOLUTIONS = [[3, self::MAX - 7], [0, 0]];

    private const MAX = 4294967295;

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
        $ranges = [[0, self::MAX]];
        foreach ($input as $line) {
            $a = explode('-', $line);
            $fromB = intval($a[0]);
            $toB = intval($a[1] ?? '0');
            $toAdd = [];
            foreach ($ranges as $idx => [$fromW, $toW]) {
                if ($toW < $fromB) {
                    continue;
                }
                if ($toB < $fromW) {
                    break;
                }
                if (($fromB <= $fromW) and ($toW <= $toB)) {
                    unset($ranges[$idx]);
                    continue;
                }
                if (($fromW < $fromB) and ($toB < $toW)) {
                    unset($ranges[$idx]);
                    $toAdd[] = [$fromW, $fromB - 1];
                    $toAdd[] = [$toB + 1, $toW];
                    break;
                }
                if (($fromW < $fromB) and ($toW <= $toB)) {
                    unset($ranges[$idx]);
                    $toAdd[] = [$fromW, $fromB - 1];
                    continue;
                }
                if (($fromB <= $fromW) and ($toB < $toW)) {
                    unset($ranges[$idx]);
                    $toAdd[] = [$toB + 1, $toW];
                    continue;
                }
            }
            $ranges = array_merge($ranges, $toAdd);
            usort($ranges, fn (array $a, array $b): int => $a[0] <=> $b[0]);
        }
        $ans1 = $ranges[0][0];
        $ans2 = array_sum(array_map(fn (array $a): int => $a[1] - $a[0] + 1, $ranges));
        return [strval($ans1), strval($ans2)];
    }
}
