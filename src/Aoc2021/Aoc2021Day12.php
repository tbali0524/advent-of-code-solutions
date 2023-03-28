<?php

declare(strict_types=1);

namespace TBali\Aoc2021;

use TBali\Aoc\SolutionBase;

/**
 * AoC 2021 Day 12: Passage Pathing.
 *
 * Part 1: How many paths through this cave system are there that visit small caves at most once?
 * Part 2: Given these new rules, how many paths through this cave system are there?
 *
 * Topics: DFS
 *
 * @see https://adventofcode.com/2021/day/12
 */
final class Aoc2021Day12 extends SolutionBase
{
    public const YEAR = 2021;
    public const DAY = 12;
    public const TITLE = 'Passage Pathing';
    public const SOLUTIONS = [3779, 96988];
    public const EXAMPLE_SOLUTIONS = [[10, 36], [19, 103], [226, 3509]];

    /** @var array<string, array<int, string>> */
    private array $adjL = [];
    /** @var array<string, bool> */
    private array $nodeBigCave = [];

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
        $this->adjL = [];
        $this->nodeBigCave = [];
        foreach ($input as $line) {
            $caves = explode('-', $line);
            if (count($caves) != 2) {
                throw new \Exception('Invalid input');
            }
            foreach ($caves as $idx => $cave) {
                if (!isset($this->nodeBigCave[$cave])) {
                    $this->nodeBigCave[$cave] = ($cave == strtoupper($cave));
                }
                if (!isset($this->adjL[$cave])) {
                    $this->adjL[$cave] = [];
                }
                $this->adjL[$cave][] = $caves[1 - $idx];
            }
        }
        foreach (array_keys($this->adjL) as $from) {
            sort($this->adjL[$from]);
        }
        ksort($this->adjL);
        // ---------- Part 1 + 2
        $ans1 = $this->countRoutesPart1();
        $ans2 = $this->countRoutesPart2();
        return [strval($ans1), strval($ans2)];
    }

    /**
     * @param array<string, bool> $visited
     */
    private function countRoutesPart1(string $node = 'start', array $visited = ['start' => true]): int
    {
        if ($node == 'end') {
            return 1;
        }
        $ans = 0;
        foreach (($this->adjL[$node] ?? []) as $nbNode) {
            if (!$this->nodeBigCave[$nbNode] and isset($visited[$nbNode])) {
                continue;
            }
            $visited1 = $visited;
            $visited1[strval($nbNode)] = true;
            $ans += $this->countRoutesPart1($nbNode, $visited1);
        }
        return $ans;
    }

    /**
     * @param array<string, bool> $visited
     */
    private function countRoutesPart2(
        string $node = 'start',
        array $visited = ['start' => true],
        string $double = ''
    ): int {
        if ($node == 'end') {
            return 1;
        }
        $ans = 0;
        foreach (($this->adjL[$node] ?? []) as $nbNode) {
            if ($nbNode == 'start') {
                continue;
            }
            $double1 = $double;
            if (!$this->nodeBigCave[$nbNode] and isset($visited[$nbNode])) {
                if ($double != '') {
                    continue;
                }
                $double1 = $nbNode;
            }
            $visited1 = $visited;
            $visited1[strval($nbNode)] = true;
            $ans += $this->countRoutesPart2($nbNode, $visited1, $double1);
        }
        return $ans;
    }
}
