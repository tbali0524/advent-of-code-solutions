<?php

declare(strict_types=1);

namespace TBali\Aoc2023;

use TBali\Aoc\SolutionBase;

/**
 * AoC 2023 Day 8: Haunted Wasteland.
 *
 * Part 1: Starting at AAA, follow the left/right instructions. How many steps are required to reach ZZZ?
 * Part 2: How many steps does it take before you're only on nodes that end with Z?
 *
 * Topics: cycle detection, least common multiple
 *
 * @see https://adventofcode.com/2023/day/8
 */
final class Aoc2023Day08 extends SolutionBase
{
    public const YEAR = 2023;
    public const DAY = 8;
    public const TITLE = 'Haunted Wasteland';
    public const SOLUTIONS = [21883, 12833235391111];
    public const EXAMPLE_SOLUTIONS = [[2, 0], [6, 0], [0, 6]];

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
        if (
            (count($input) < 3)
            or ($input[1] != '')
        ) {
            throw new \Exception('Invalid input');
        }
        $dirs = $input[0];
        $links = [];
        for ($i = 2; $i < count($input); ++$i) {
            $a = explode(' = (', $input[$i]);
            if ((count($a) != 2) or ($a[1][-1] != ')')) {
                throw new \Exception('Invalid input');
            }
            $links[$a[0]] = explode(', ', substr($a[1], 0, -1));
            if (count($links[$a[0]]) != 2) {
                throw new \Exception('Invalid input');
            }
        }
        // ---------- Part 1
        $ans1 = 0;
        if (isset($links['AAA'])) {
            $node = 'AAA';
            while (true) {
                if ($node == 'ZZZ') {
                    break;
                }
                $node = match ($dirs[$ans1 % strlen($dirs)]) {
                    'L' => $links[$node][0] ?? throw new \Exception('Invalid input'),
                    'R' => $links[$node][1] ?? throw new \Exception('Invalid input'),
                    default => throw new \Exception('Invalid input'),
                };
                ++$ans1;
            }
        }
        // ---------- Part 2
        $ans2 = 0;
        $startNodes = [];
        foreach (array_keys($links) as $node) {
            if ($node[-1] == 'A') {
                $startNodes[] = $node;
            }
        }
        if (count($startNodes) <= 1) {
            return [strval($ans1), '0'];
        }
        $cycleStarts = array_fill(0, count($startNodes), 0);
        $cycleLengths = array_fill(0, count($startNodes), 0);
        $finalSteps = array_fill(0, count($startNodes), 0);
        foreach ($startNodes as $idx => $startNode) {
            $lastSeenAt = [];
            $step = 0;
            $node = $startNode;
            while (true) {
                if (($node[-1] == 'Z') and ($finalSteps[$idx] == 0)) {
                    $finalSteps[$idx] = $step;
                }
                $hash = $node . ' ' . ($step % strlen($dirs));
                if (isset($lastSeenAt[$hash])) {
                    $cycleStarts[$idx] = $lastSeenAt[$hash];
                    $cycleLengths[$idx] = $step - $lastSeenAt[$hash];
                    break;
                }
                $lastSeenAt[$hash] = $step;
                $node = match ($dirs[$step % strlen($dirs)]) {
                    'L' => $links[$node][0] ?? throw new \Exception('Invalid input'),
                    'R' => $links[$node][1] ?? throw new \Exception('Invalid input'),
                    default => throw new \Exception('Impossible'),
                };
                ++$step;
            }
        }
        // echo implode(' ', $cycleStarts), PHP_EOL;
        // echo implode(' ', $cycleLengths), PHP_EOL;
        // echo implode(' ', $finalSteps), PHP_EOL;
        // for the input, $cycleLength == $finalSteps, so the solution is the least common multiple of $cycleLengths.
        $ans2 = 1;
        foreach ($cycleLengths as $cycleLength) {
            $ans2 = self::lcm($ans2, $cycleLength);
        }
        return [strval($ans1), strval($ans2)];
    }

    /**
     * Greatest common divisor.
     *
     * @see https://en.wikipedia.org/wiki/Greatest_common_divisor
     */
    private static function gcd(int $a, int $b): int
    {
        $a1 = max($a, $b);
        $b1 = min($a, $b);
        while ($b1 != 0) {
            $t = $b1;
            $b1 = $a1 % $b1;
            $a1 = $t;
        }
        return $a1;
    }

    /**
     * Least common multiple.
     *
     * @see https://en.wikipedia.org/wiki/Least_common_multiple
     */
    private static function lcm(int $a, int $b): int
    {
        return abs($a) * intdiv(abs($b), self::gcd($a, $b));
    }
}
