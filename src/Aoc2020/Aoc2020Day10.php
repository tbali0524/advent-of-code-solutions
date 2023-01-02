<?php

declare(strict_types=1);

namespace TBali\Aoc2020;

use TBali\Aoc\SolutionBase;

/**
 * AoC 2020 Day 10: Adapter Array.
 *
 * Part 1: What is the number of 1-jolt differences multiplied by the number of 3-jolt differences?
 * Part 2: What is the total number of distinct ways you can arrange the adapters to connect
 *         the charging outlet to your device?
 *
 * Topics: recursion, memoization
 *
 * @see https://adventofcode.com/2020/day/10
 */
final class Aoc2020Day10 extends SolutionBase
{
    public const YEAR = 2020;
    public const DAY = 10;
    public const TITLE = 'Adapter Array';
    public const SOLUTIONS = [2112, 3022415986688];
    public const EXAMPLE_SOLUTIONS = [[35, 8], [220, 19208]];

    /** @var array<int, int> */
    private array $memo = [];

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
        /** @var array<int, int> */
        $input = array_map(intval(...), $input);
        // ---------- Part 1
        $a = $input;
        $a[] = max($input) + 3;
        $a[] = 0;
        sort($a);
        $counts = [0, 0, 0, 0];
        for ($i = 1; $i < count($a); ++$i) {
            $counts[$a[$i] - $a[$i - 1]] = ($counts[$a[$i] - $a[$i - 1]] ?? 0) + 1;
        }
        $ans1 = $counts[1] * $counts[3];
        // ---------- Part 2
        $this->memo = [];
        $ans2 = $this->solvePart2($a);
        return [strval($ans1), strval($ans2)];
    }

    /** @param array<int, int> $a */
    private function solvePart2(array $a, int $idx = -1): int
    {
        if ($idx < 0) {
            $idx = count($a) - 1;
        }
        if (isset($this->memo[$idx])) {
            return $this->memo[$idx];
        }
        if ($idx == 0) {
            $ans = 1;
        } else {
            $ans = 0;
            for ($i = 1; $i <= 3; ++$i) {
                if ($idx - $i < 0) {
                    break;
                }
                if ($a[$idx] - $a[$idx - $i] > 3) {
                    break;
                }
                $ans += $this->solvePart2($a, $idx - $i);
            }
        }
        $this->memo[$idx] = $ans;
        return $ans;
    }
}
