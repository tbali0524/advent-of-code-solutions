<?php

declare(strict_types=1);

namespace TBali\Aoc2016;

use TBali\Aoc\SolutionBase;

/**
 * AoC 2016 Day 9: Explosives in Cyberspace.
 *
 * Part 1: What is the decompressed length of the file (your puzzle input)? Don't count whitespace.
 * Part 2: What is the decompressed length of the file using this improved format?
 *
 * @see https://adventofcode.com/2016/day/9
 */
final class Aoc2016Day09 extends SolutionBase
{
    public const YEAR = 2016;
    public const DAY = 9;
    public const TITLE = 'Explosives in Cyberspace';
    public const SOLUTIONS = [74532, 11558231665];
    public const EXAMPLE_SOLUTIONS = [[57, 0], [0, 9 + 20 + 241920 + 445]];

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
        $data = '';
        foreach ($input as $line) {
            $data .= str_replace(' ', '', $line);
        }
        $ans1 = $this->getDecompressLen($data, false);
        $ans2 = $this->getDecompressLen($data, true);
        return [strval($ans1), strval($ans2)];
    }

    private function getDecompressLen(string $data, bool $recursive = false): int
    {
        $ans = 0;
        $start = 0;
        while ($start < strlen($data)) {
            $end = strpos($data, '(', $start);
            if ($end === false) {
                $end = strlen($data);
            }
            if ($start != $end) {
                $ans += $end - $start;
                $start = $end;
                continue;
            }
            ++$start;
            $end = strpos($data, ')', $start);
            if ($end === false) {
                continue;
            }
            if ($end - $start < 3) {
                throw new \Exception('Invalid input');
            }
            $a = explode('x', substr($data, $start, $end - $start));
            if (count($a) != 2) {
                throw new \Exception('Invalid input');
            }
            $len = intval($a[0]);
            $count = intval($a[1]);
            if ($recursive) {
                $ans += $this->getDecompressLen(substr($data, $end + 1, $len), true) * $count;
            } else {
                $ans += $len * $count;
            }
            $start = $end + 1 + $len;
        }
        return $ans;
    }
}
