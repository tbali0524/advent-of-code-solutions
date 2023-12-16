<?php

declare(strict_types=1);

namespace TBali\Aoc2023;

use TBali\Aoc\SolutionBase;

/**
 * AoC 2023 Day 12: Hot Springs.
 *
 * Part 1: What is the sum of those counts?
 * Part 2: Unfold your condition records; what is the new sum of possible arrangement counts?
 *
 * Topics: recursion, memoization
 *
 * @see https://adventofcode.com/2023/day/12
 */
final class Aoc2023Day12 extends SolutionBase
{
    public const YEAR = 2023;
    public const DAY = 12;
    public const TITLE = 'Hot Springs';
    public const SOLUTIONS = [8193, 45322533163795];
    public const EXAMPLE_SOLUTIONS = [[21, 525152]];

    /** @var array<string, int> */
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
        // ---------- Parse input
        $records = [];
        $sizes = [];
        foreach ($input as $idx => $line) {
            $a = explode(' ', $line);
            if (count($a) != 2) {
                throw new \Exception('Invalid input');
            }
            $records[] = $a[0];
            $sizes[] = array_map(intval(...), explode(',', $a[1]));
        }
        // ---------- Part 1
        $ans1 = 0;
        for ($i = 0; $i < count($input); ++$i) {
            $ans1 += $this->countSolutions($records[$i], $sizes[$i]);
        }
        // ---------- Part 2
        $ans2 = 0;
        for ($i = 0; $i < count($input); ++$i) {
            $record = $records[$i]
                . '?' . $records[$i]
                . '?' . $records[$i]
                . '?' . $records[$i]
                . '?' . $records[$i];
            $size = array_merge(
                $sizes[$i],
                $sizes[$i],
                $sizes[$i],
                $sizes[$i],
                $sizes[$i],
            );
            $ans2 += $this->countSolutions($record, $size);
        }
        return [strval($ans1), strval($ans2)];
    }

    /**
     * @param array<int, int> $sizes
     */
    private function countSolutions(string $pattern, array $sizes): int
    {
        if ($pattern == '') {
            return count($sizes) == 0 ? 1 : 0;
        }
        $hash = $pattern . ' ' . implode(' ', $sizes);
        if (isset($this->memo[$hash])) {
            return $this->memo[$hash];
        }
        $result = 0;
        if ($pattern[0] == '.') {
            $result = $this->countSolutions(substr($pattern, 1), $sizes);
        } elseif ($pattern[0] == '?') {
            $result = $this->countSolutions('.' . substr($pattern, 1), $sizes)
                + $this->countSolutions('#' . substr($pattern, 1), $sizes);
        } elseif ((count($sizes) == 0) or (strlen($pattern) < $sizes[0])) {
            $result = 0;
        } else {
            $isOk = true;
            for ($i = 0; $i < $sizes[0]; ++$i) {
                if ($pattern[$i] == '.') {
                    $isOk = false;
                    break;
                }
            }
            if (($sizes[0] < strlen($pattern)) and ($pattern[$sizes[0]] == '#')) {
                $isOk = false;
            }
            if ($isOk) {
                $result = $this->countSolutions(substr($pattern, $sizes[0] + 1), array_slice($sizes, 1));
            }
        }
        $this->memo[$hash] = $result;
        return $result;
    }
}
