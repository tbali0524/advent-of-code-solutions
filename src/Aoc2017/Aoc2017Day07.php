<?php

declare(strict_types=1);

namespace TBali\Aoc2017;

use TBali\Aoc\SolutionBase;

/**
 * AoC 2017 Day 7: Recursive Circus.
 *
 * Part 1: What is the name of the bottom program?
 * Part 2: Given that exactly one program is the wrong weight,
 *         what would its weight need to be to balance the entire tower?
 *
 * Topics: tree graph
 *
 * @see https://adventofcode.com/2017/day/7
 */
final class Aoc2017Day07 extends SolutionBase
{
    public const YEAR = 2017;
    public const DAY = 7;
    public const TITLE = 'Recursive Circus';
    public const SOLUTIONS = ['gynfwly', 1526];
    public const EXAMPLE_SOLUTIONS = [['tknk', 60]];

    /** @var array<string, string> */
    private array $parents = [];
    /** @var array<string, int> */
    private array $weights = [];
    /** @var array<string, array<int, string>> */
    private array $children = [];
    /** @var array<string, int> */
    private array $totals = [];

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
        $this->weights = [];
        $this->children = [];
        $this->parents = [];
        foreach ($input as $line) {
            $a = explode(' -> ', $line);
            $b = explode(' (', $a[0]);
            if (count($b) != 2) {
                throw new \Exception('Invalid input');
            }
            $name = $b[0];
            $weight = intval(substr($b[1], 0, -1));
            $this->weights[$name] = $weight;
            $this->children[$name] = match (count($a)) {
                1 => [],
                2 => explode(', ', $a[1]),
                default => throw new \Exception('Invalid input'),
            };
            foreach ($this->children[$name] as $child) {
                $this->parents[$child] = $name;
            }
        }
        // ---------- Part 1
        $ans1 = '';
        foreach ($this->weights as $name => $weight) {
            if (!isset($this->parents[$name])) {
                $ans1 = $name;
                break;
            }
        }
        // ---------- Part 2
        $ans2 = $this->updateTotals($ans1);
        return [strval($ans1), strval($ans2)];
    }

    private function updateTotals(string $name): int
    {
        $this->totals[$name] = $this->weights[$name];
        $sameResults = [];
        foreach (($this->children[$name] ?? []) as $child) {
            $ans = $this->updateTotals($child);
            if ($ans > 0) {
                return $ans;
            }
            $this->totals[$name] += $this->totals[$child];
            if (isset($sameResults[$this->totals[$child]])) {
                $sameResults[$this->totals[$child]][] = $child;
            } else {
                $sameResults[$this->totals[$child]] = [$child];
            }
        }
        if (count($sameResults) == 2) {
            $first = array_key_first($sameResults);
            $last = array_key_last($sameResults);
            if (count($sameResults[$first]) < count($sameResults[$last])) {
                return $last - $first + $this->weights[$sameResults[$first][0]];
            }
            if (count($sameResults[$first]) > count($sameResults[$last])) {
                return $first - $last + $this->weights[$sameResults[$last][0]];
            }
            throw new \Exception('Invalid input');
        }
        return 0;
    }
}
