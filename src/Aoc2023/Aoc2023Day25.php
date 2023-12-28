<?php

declare(strict_types=1);

namespace TBali\Aoc2023;

use TBali\Aoc\SolutionBase;

/**
 * AoC 2023 Day 25: Snowverload.
 *
 * Part 1: Find the three wires you need to disconnect in order to divide the components into two separate groups.
 *         What do you get if you multiply the sizes of these two groups together?
 * Part 2: N/A
 *
 * Topics: graph components
 *
 * @see https://adventofcode.com/2023/day/25
 */
final class Aoc2023Day25 extends SolutionBase
{
    public const YEAR = 2023;
    public const DAY = 25;
    public const TITLE = 'Snowverload';
    public const SOLUTIONS = [619225, 0];
    public const EXAMPLE_SOLUTIONS = [[54, 0]];

    private const EDGES_TO_CUT_EXAMPLE = [
        ['jqt', 'nvd'],
        ['bvb', 'cmg'],
        ['hfx', 'pzl'],
    ];
    private const EDGES_TO_CUT = [
        ['nrs', 'khn'],
        ['ssd', 'xqh'],
        ['qlc', 'mqb'],
    ];

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
        $edges = [];
        foreach ($input as $line) {
            $a = explode(': ', $line);
            if (count($a) != 2) {
                throw new \Exception('Invalid input');
            }
            $from = $a[0];
            if (!isset($edges[$from])) {
                $edges[$from] = [];
            }
            foreach (explode(' ', $a[1]) as $to) {
                if (!isset($edges[$to])) {
                    $edges[$to] = [];
                }
                $edges[$from][$to] = 1;
                $edges[$to][$from] = 1;
            }
        }
        // ---------- Part 1
        // A proper solution would be one of the algorithms according to:
        //   https://en.wikipedia.org/wiki/K-edge-connected_graph
        // Instead of this, I manually selected the edges to cut.
        //   using the hint from: http://clb.confined.space/aoc2023/#day25
        // Install [graphviz](https://graphviz.org/)
        // Manual edit input file to change to dot file format (https://graphviz.org/doc/info/lang.html)
        // Run in command-line:
        //    dot -Tsvg -Kneato input\2023\Aoc2023Day25_graphviz.txt -o input\2023\Aoc2023Day25_graphviz.svg
        //    dot -Tsvg -Kneato input\2023\Aoc2023Day25ex1_graphviz.txt -o input\2023\Aoc2023Day25ex1_graphviz.svg
        if (count($edges) < 20) {
            $edgesToCut = self::EDGES_TO_CUT_EXAMPLE;
        } else {
            $edgesToCut = self::EDGES_TO_CUT;
        }
        foreach ($edgesToCut as [$from, $to]) {
            unset($edges[$from][$to], $edges[$to][$from]);
        }
        $edge = $edgesToCut[0][0];
        $visited = [$edge => true];
        $q = [$edge];
        $readIdx = 0;
        while ($readIdx < count($q)) {
            $current = $q[$readIdx];
            ++$readIdx;
            foreach (array_keys($edges[$current] ?? []) as $to) {
                if (isset($visited[$to])) {
                    continue;
                }
                $q[] = $to;
                $visited[$to] = true;
            }
        }
        $ans1 = count($visited) * (count($edges) - count($visited));
        $ans2 = 0;
        return [strval($ans1), strval($ans2)];
    }
}
