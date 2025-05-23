<?php

declare(strict_types=1);

namespace TBali\Aoc2020;

use TBali\Aoc\SolutionBase;

/**
 * AoC 2020 Day 9: Encoding Error.
 *
 * Part 1: What is the first number that does not have this property?
 * Part 2: What is the encryption weakness in your XMAS-encrypted list of numbers?
 *
 * @see https://adventofcode.com/2020/day/9
 */
final class Aoc2020Day09 extends SolutionBase
{
    public const YEAR = 2020;
    public const DAY = 9;
    public const TITLE = 'Encoding Error';
    public const SOLUTIONS = [466456641, 55732936];
    public const EXAMPLE_SOLUTIONS = [[127, 62]];

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
        $window = 25;
        // detect puzzle example with reduced window size
        if (count($input) <= 20) {
            $window = 5;
        }
        // ---------- Part 1
        if (count($input) < $window) {
            throw new \Exception('Invalid input');
        }
        $ans1 = 0;
        $memo = [];
        for ($i = 0; $i < $window; ++$i) {
            for ($j = $i + 1; $j < $window; ++$j) {
                $memo[$input[$i] + $input[$j]] = $i;
            }
        }
        for ($i = $window; $i < count($input); ++$i) {
            $item = $input[$i];
            if (!isset($memo[$item]) or ($i - $memo[$item] > $window)) {
                $ans1 = $item;
                break;
            }
            for ($j = $i - $window + 1; $j < $i; ++$j) {
                $memo[$item + $input[$j]] = max($memo[$item + $input[$j]] ?? 0, $j);
            }
        }
        // ---------- Part 2
        $ans2 = 0;
        $from = 0;
        $to = 1;
        $sum = $input[$from] + $input[$to];
        while (true) {
            if ($sum == $ans1) {
                break;
            }
            while (($sum < $ans1) and ($to < count($input))) {
                ++$to;
                $sum += $input[$to];
            }
            if ($to >= count($input)) {
                // @codeCoverageIgnoreStart
                throw new \Exception('No solution found');
                // @codeCoverageIgnoreEnd
            }
            if ($sum == $ans1) {
                break;
            }
            while (($sum > $ans1) and ($from < $to)) {
                $sum -= $input[$from];
                ++$from;
            }
            if ($sum == $ans1) {
                break;
            }
            if ($from == $to) {
                ++$from;
                $to = $from + 1;
                $sum = $input[$from] + $input[$to];
            }
        }
        $slice = array_slice($input, $from, $to - $from + 1);
        $ans2 = min($slice ?: [0]) + max($slice ?: [0]);
        return [strval($ans1), strval($ans2)];
    }
}
