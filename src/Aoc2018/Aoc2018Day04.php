<?php

declare(strict_types=1);

namespace TBali\Aoc2018;

use TBali\Aoc\SolutionBase;

/**
 * AoC 2018 Day 4: Repose Record.
 *
 * Part 1: Strategy 1: Find the guard that has the most minutes asleep.
 *         What is the ID of the guard you chose multiplied by the minute you chose?
 * Part 2: Strategy 2: Of all guards, which guard is most frequently asleep on the same minute?
 *         What is the ID of the guard you chose multiplied by the minute you chose?
 *
 * @see https://adventofcode.com/2018/day/4
 */
final class Aoc2018Day04 extends SolutionBase
{
    public const YEAR = 2018;
    public const DAY = 4;
    public const TITLE = 'Repose Record';
    public const SOLUTIONS = [19830, 43695];
    public const EXAMPLE_SOLUTIONS = [[240, 4455]];

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
        sort($input);
        $guard = -1;
        $totalSleeps = [];
        $countSleepingAt = [];
        $lastFall = -1;
        foreach ($input as $line) {
            if (strlen($line) < 27) {
                throw new \Exception('Invalid input');
            }
            $action = $line[19];
            if ($action == 'G') {
                $guard = intval(explode(' ', substr($line, 26))[0]);
                continue;
            }
            $day = intval(substr($line, 9, 2));
            $min = intval(substr($line, 15, 2));
            if ($action == 'f') {
                $lastFall = $min;
                continue;
            }
            if (($action != 'w') or ($lastFall < 0) or ($guard < 0)) {
                throw new \Exception('Invalid input');
            }
            $totalSleeps[$guard] = ($totalSleeps[$guard] ?? 0) + $min - $lastFall;
            for ($t = $lastFall; $t < $min; ++$t) {
                $countSleepingAt[$guard][$t] = ($countSleepingAt[$guard][$t] ?? 0) + 1;
            }
            $lastFall = -1;
        }
        arsort($totalSleeps);
        $bestGuard = array_key_first($totalSleeps);
        arsort($countSleepingAt[$bestGuard]);
        $bestMin = array_key_first($countSleepingAt[$bestGuard]);
        $ans1 = $bestGuard * $bestMin;
        // ---------- Part 2
        $bestGuard = 0;
        $bestCount = 0;
        $bestMin = 0;
        foreach ($countSleepingAt as $guard => $counts) {
            arsort($counts);
            $min = array_key_first($counts);
            $count = $counts[$min];
            if ($count > $bestCount) {
                $bestCount = $count;
                $bestMin = $min;
                $bestGuard = $guard;
            }
        }
        $ans2 = $bestGuard * $bestMin;
        return [strval($ans1), strval($ans2)];
    }
}
