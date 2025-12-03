<?php

declare(strict_types=1);

namespace TBali\Aoc2025;

use TBali\Aoc\SolutionBase;

/**
 * AoC 2025 Day 2: Gift Shop.
 *
 * @see https://adventofcode.com/2025/day/2
 */
final class Aoc2025Day02 extends SolutionBase
{
    public const YEAR = 2025;
    public const DAY = 2;
    public const TITLE = 'Gift Shop';
    public const SOLUTIONS = [40055209690, 50857215650];
    public const EXAMPLE_SOLUTIONS = [[1227775554, 4174379265]];

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
        if (count($input) != 1) {
            throw new \Exception('Invalid input');
        }
        $ranges = [];
        foreach (explode(',', $input[0]) as $range) {
            $a = array_map(intval(...), explode('-', $range));
            if (count($a) != 2) {
                throw new \Exception('Invalid input');
            }
            $ranges[] = $a;
        }
        // ---------- Part 1 + 2
        $ans1 = 0;
        $ans2 = 0;
        $memo = [];
        foreach ($ranges as [$from, $to]) {
            $from_digits = strlen(strval($from));
            $to_digits = strlen(strval($to));
            $max_repeat = $to_digits;
            for ($repeat = 2; $repeat <= $max_repeat; ++$repeat) {
                $from_chunk = intdiv($from, 10 ** ($from_digits - intdiv($from_digits, $repeat)));
                $to_chunk = 10 ** intdiv($to_digits, $repeat);
                for ($chunk = $from_chunk; $chunk <= $to_chunk; ++$chunk) {
                    // suppress php warning, there is a i64 overflow (but fits in u64)
                    // @mago-expect lint:no-error-control-operator
                    $candidate = @intval(str_repeat(strval($chunk), $repeat));
                    if ($candidate >= $from && $candidate <= $to && !isset($memo[$candidate])) {
                        $ans2 += $candidate;
                        if ($repeat == 2) {
                            $ans1 += $candidate;
                        }
                        $memo[$candidate] = true;
                    }
                }
            }
        }
        return [strval($ans1), strval($ans2)];
    }
}
