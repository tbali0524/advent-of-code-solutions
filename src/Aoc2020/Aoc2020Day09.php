<?php

/*
https://adventofcode.com/2020/day/9
Part 1: What is the first number that does not have this property?
Part 2: What is the encryption weakness in your XMAS-encrypted list of numbers?
*/

declare(strict_types=1);

namespace TBali\Aoc2020;

use TBali\Aoc\SolutionBase;

class Aoc2020Day09 extends SolutionBase
{
    public const YEAR = 2020;
    public const DAY = 9;
    public const TITLE = 'Encoding Error';
    public const SOLUTIONS = [466456641, 55732936];
    public const EXAMPLE_SOLUTIONS = [[127, 62], [0, 0]];

    /**
     * @param string[] $input
     *
     * @return array{string, string}
     */
    public function solve(array $input): array
    {
        /** @var int[] */
        $input = array_map('intval', $input);
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
                throw new \Exception('No solution found');
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
        $ans2 = min($slice) + max($slice);
        return [strval($ans1), strval($ans2)];
    }
}
