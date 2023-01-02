<?php

declare(strict_types=1);

namespace TBali\Aoc2017;

use TBali\Aoc\SolutionBase;

/**
 * AoC 2017 Day 12: Digital Plumber.
 *
 * Part 1: How many programs are in the group that contains program ID 0?
 * Part 2: How many groups are there in total?
 *
 * Topics: graph, BFS, components
 *
 * @see https://adventofcode.com/2017/day/12
 */
final class Aoc2017Day12 extends SolutionBase
{
    public const YEAR = 2017;
    public const DAY = 12;
    public const TITLE = 'Digital Plumber';
    public const SOLUTIONS = [288, 211];
    public const EXAMPLE_SOLUTIONS = [[6, 2]];

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
        $adjList = array_fill(0, count($input), []);
        foreach ($input as $line) {
            $a = explode(' <-> ', $line);
            $adjList[intval($a[0])] = array_map('intval', explode(', ', $a[1] ?? ''));
        }
        // ---------- Part 1 + 2
        $visited = [];
        $ans1 = 0;
        $ans2 = 0;
        for ($from = 0; $from < count($input); ++$from) {
            if (isset($visited[$from])) {
                continue;
            }
            ++$ans2;
            $q = [$from];
            $visited[$from] = true;
            $readIdx = 0;
            while ($readIdx < count($q)) {
                if ($from == 0) {
                    ++$ans1;
                }
                $id = $q[$readIdx];
                ++$readIdx;
                foreach ($adjList[$id] as $nb) {
                    if (isset($visited[$nb])) {
                        continue;
                    }
                    $visited[$nb] = true;
                    $q[] = $nb;
                }
            }
        }
        return [strval($ans1), strval($ans2)];
    }
}
