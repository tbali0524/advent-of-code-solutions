<?php

declare(strict_types=1);

namespace TBali\Aoc2025;

use TBali\Aoc\SolutionBase;

/**
 * AoC 2025 Day 8: Playground.
 *
 * @see https://adventofcode.com/2025/day/8
 */
final class Aoc2025Day08 extends SolutionBase
{
    public const YEAR = 2025;
    public const DAY = 8;
    public const TITLE = 'Playground';
    public const SOLUTIONS = [42315, 8079278220];
    public const EXAMPLE_SOLUTIONS = [[40, 25272]];

    public const CONNECTIONS_PART1_EXAMPLE = 10;
    public const CONNECTIONS_PART1 = 1000;

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
        $points = [];
        foreach ($input as $line) {
            $point = array_map(intval(...), explode(',', $line));
            if (count($point) != 3) {
                throw new \Exception('Invalid input');
            }
            $points[] = $point;
        }
        // ---------- Part 1
        $distances = [];
        for ($a = 0; $a < count($points); ++$a) {
            for ($b = $a + 1; $b < count($points); ++$b) {
                [$ax, $ay, $az] = $points[$a];
                [$bx, $by, $bz] = $points[$b];
                $dist2 = ($ax - $bx) * ($ax - $bx) + ($ay - $by) * ($ay - $by) + ($az - $bz) * ($az - $bz);
                $distances[] = [$dist2, $a, $b];
            }
        }
        usort($distances, static fn (array $a, array $b): int => $a[0] <=> $b[0]);
        if (count($points) < 25) {
            $connections_part1 = self::CONNECTIONS_PART1_EXAMPLE;
        } else {
            $connections_part1 = self::CONNECTIONS_PART1;
        }
        $adj_list = array_fill(0, count($points), []);
        foreach (array_slice($distances, 0, $connections_part1) as [$dist, $a, $b]) {
            $adj_list[$a][] = $b;
            $adj_list[$b][] = $a;
        }
        $visited = array_fill(0, count($points), false);
        $component_sizes = [];
        $count_components = 0;
        for ($from = 0; $from < count($points); ++$from) {
            if ($visited[$from]) {
                continue;
            }
            ++$count_components;
            $component_sizes[] = 1;
            $stack = [];
            $stack[] = $from;
            $visited[$from] = true;
            while (count($stack) > 0) {
                $p = array_pop($stack);
                foreach ($adj_list[$p] as $next) {
                    if ($visited[$next]) {
                        continue;
                    }
                    $visited[$next] = true;
                    $stack[] = $next;
                    ++$component_sizes[$count_components - 1];
                }
            }
        }
        rsort($component_sizes);
        if (count($component_sizes) < 3) {
            throw new \Exception('Invalid input');
        }
        $ans1 = $component_sizes[0] * $component_sizes[1] * $component_sizes[2];
        // ---------- Part 2
        $ans2 = 0;
        $circuit = array_fill(0, count($points), false);
        [$dist, $a, $b] = $distances[0];
        $circuit[$a] = true;
        $circuit[$b] = true;
        $circuit_size = 2;
        while ($circuit_size < count($points)) {
            foreach ($distances as [$dist, $a, $b]) {
                if ($circuit[$a] == $circuit[$b]) {
                    continue;
                }
                ++$circuit_size;
                $circuit[$a] = true;
                $circuit[$b] = true;
                if ($circuit_size == count($points)) {
                    $ans2 = $points[$a][0] * $points[$b][0];
                }
                break;
            }
        }
        return [strval($ans1), strval($ans2)];
    }
}
