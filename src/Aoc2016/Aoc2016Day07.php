<?php

declare(strict_types=1);

namespace TBali\Aoc2016;

use TBali\Aoc\SolutionBase;

/**
 * AoC 2016 Day 7: Internet Protocol Version 7.
 *
 * Part 1: How many IPs in your puzzle input support TLS?
 * Part 2: How many IPs in your puzzle input support SSL?
 *
 * @see https://adventofcode.com/2016/day/7
 */
final class Aoc2016Day07 extends SolutionBase
{
    public const YEAR = 2016;
    public const DAY = 7;
    public const TITLE = 'Internet Protocol Version 7';
    public const SOLUTIONS = [118, 260];
    public const EXAMPLE_SOLUTIONS = [[2, 0], [0, 3]];

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
        $ans1 = 0;
        $ans2 = 0;
        foreach ($input as $line) {
            $start = 0;
            $hasAbbaOut = false;
            $hasAbbaIn = false;
            $allAbaOut = [];
            $allBabIn = [];
            while ($start < strlen($line)) {
                $end = strpos($line, '[', $start);
                if ($end === false) {
                    $end = strlen($line);
                }
                if ($start != $end) {
                    $sub = substr($line, $start, $end - $start);
                    if ($this->hasAbba($sub)) {
                        $hasAbbaOut = true;
                    }
                    $allAbaOut = array_merge($allAbaOut, $this->getAllAba($sub));
                    $start = $end;
                    continue;
                }
                ++$start;
                $end = strpos($line, ']', $start);
                if ($end === false) {
                    // @codeCoverageIgnoreStart
                    continue;
                    // @codeCoverageIgnoreEnd
                }
                if ($start != $end) {
                    $sub = substr($line, $start, $end - $start);
                    if ($this->hasAbba($sub)) {
                        $hasAbbaIn = true;
                    }
                    $allBabIn = array_merge($allBabIn, $this->getAllBab($sub));
                    $start = $end + 1;
                    continue;
                }
            }
            if ($hasAbbaOut and !$hasAbbaIn) {
                ++$ans1;
            }
            foreach (array_keys($allAbaOut) as $ab) {
                if (isset($allBabIn[$ab])) {
                    ++$ans2;
                    break;
                }
            }
        }
        return [strval($ans1), strval($ans2)];
    }

    private function hasAbba(string $s): bool
    {
        for ($i = 3; $i < strlen($s); ++$i) {
            if (($s[$i] == $s[$i - 3]) and ($s[$i - 1] == $s[$i - 2]) and ($s[$i] != $s[$i - 1])) {
                return true;
            }
        }
        return false;
    }

    /** @return array<string, bool> */
    private function getAllAba(string $s): array
    {
        $a = [];
        for ($i = 2; $i < strlen($s); ++$i) {
            if (($s[$i] == $s[$i - 2]) and ($s[$i] != $s[$i - 1])) {
                $a[$s[$i] . $s[$i - 1]] = true;
            }
        }
        return $a;
    }

    /** @return array<string, bool> */
    private function getAllBab(string $s): array
    {
        $a = [];
        for ($i = 2; $i < strlen($s); ++$i) {
            if (($s[$i] == $s[$i - 2]) and ($s[$i] != $s[$i - 1])) {
                $a[$s[$i - 1] . $s[$i]] = true;
            }
        }
        return $a;
    }
}
