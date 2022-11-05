<?php

declare(strict_types=1);

namespace TBali\Aoc2015;

use TBali\Aoc\SolutionBase;

/**
 * AoC 2015 Day 24: It Hangs in the Balance.
 *
 * Part 1: What is the quantum entanglement of the first group of packages in the ideal configuration?
 * Part 2: Now, what is the quantum entanglement of the first group of packages in the ideal configuration?
 *
 * @see https://adventofcode.com/2015/day/24
 */
final class Aoc2015Day24 extends SolutionBase
{
    public const YEAR = 2015;
    public const DAY = 24;
    public const TITLE = 'It Hangs in the Balance';
    public const SOLUTIONS = [10439961859, 72050269];
    public const EXAMPLE_SOLUTIONS = [[99, 44], [0, 0]];

    /** @var array<int, int> */
    private array $weights;
    private int $target;
    /** @var array<int, int> */
    private array $totalRemaining;
    /** @var array<int, int> */
    private array $grp;
    private int $grpSum;
    /** @var array<array<int, int>> */
    private array $candidates;

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
        $this->weights = array_map('intval', $input);
        // ---------- Part 1 + 2
        rsort($this->weights);
        $this->totalRemaining = [];
        $this->totalRemaining[count($this->weights)] = 0;
        for ($i = count($this->weights) - 1; $i >= 0; --$i) {
            $this->totalRemaining[$i] = $this->totalRemaining[$i + 1] + $this->weights[$i];
        }
        $ans1 = $this->solveForGroupCount(3);
        $ans2 = $this->solveForGroupCount(4);
        return [strval($ans1), strval($ans2)];
    }

    private function solveForGroupCount(int $countGroups): int
    {
        $this->target = intdiv(array_sum($this->weights), $countGroups);
        $this->grp = [];
        $this->grpSum = 0;
        $this->candidates = [];
        $this->findCandidates();
        $minCount = min(array_map(fn (array $a): int => count($a), $this->candidates));
        return intval(min(array_map(
            fn (array $a): int => intval(array_product($a)),
            array_filter($this->candidates, fn (array $a): bool => count($a) == $minCount)
        )));
    }

    private function findCandidates(int $idx = -1): void
    {
        if ($this->grpSum == $this->target) {
            $this->candidates[] = $this->grp;
            return;
        }
        ++$idx;
        if ($idx >= count($this->weights)) {
            return;
        }
        $w = $this->weights[$idx];
        if ($this->grpSum + $w <= $this->target) {
            $this->grp[] = $w;
            $this->grpSum += $w;
            $this->findCandidates($idx);
            array_pop($this->grp);
            $this->grpSum -= $w;
        }
        if (($this->totalRemaining[$idx + 1] ?? 0) >= $this->target - $this->grpSum) {
            $this->findCandidates($idx);
        }
    }
}
