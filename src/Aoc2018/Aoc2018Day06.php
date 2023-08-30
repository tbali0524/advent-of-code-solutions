<?php

declare(strict_types=1);

namespace TBali\Aoc2018;

use TBali\Aoc\SolutionBase;

/**
 * AoC 2018 Day 6: Chronal Coordinates.
 *
 * Part 1: What is the size of the largest area that isn't infinite?
 * Part 2: What is the size of the region containing all locations which have a total distance
 *         to all given coordinates of less than 10000?
 *
 * @see https://adventofcode.com/2018/day/6
 */
final class Aoc2018Day06 extends SolutionBase
{
    public const YEAR = 2018;
    public const DAY = 6;
    public const TITLE = 'Chronal Coordinates';
    public const SOLUTIONS = [3006, 42998];
    public const EXAMPLE_SOLUTIONS = [[17, 16]];

    private const DIST_THRESHOLD_EXAMPLE = 32;
    private const DIST_THRESHOLD_PART2 = 10_000;

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
        $points = array_map(
            static fn (string $line): array => array_map(intval(...), explode(', ', $line)),
            $input
        );
        // ---------- Part 1 + 2
        $threshold = count($input) == 6 ? self::DIST_THRESHOLD_EXAMPLE : self::DIST_THRESHOLD_PART2;
        $minX = intval(min(array_map(static fn (array $p): int => $p[0], $points) ?: [0]));
        $maxX = intval(max(array_map(static fn (array $p): int => $p[0], $points) ?: [0]));
        $minY = intval(min(array_map(static fn (array $p): int => $p[1], $points) ?: [0]));
        $maxY = intval(max(array_map(static fn (array $p): int => $p[1], $points) ?: [0]));
        $ans1 = 0;
        $ans2 = 0;
        $areas = array_fill(0, count($input), 0);
        $isInfinite = [];
        for ($y = $minY; $y <= $maxY; ++$y) {
            for ($x = $minX; $x <= $maxX; ++$x) {
                $dists = array_map(
                    static fn (array $p): int => abs($p[0] - $x) + abs($p[1] - $y),
                    $points,
                );
                $totalDist = intval(array_sum($dists));
                if ($totalDist < $threshold) {
                    ++$ans2;
                }
                asort($dists);
                $bestP = array_key_first($dists);
                $bestDist = $dists[$bestP];
                if (array_count_values($dists)[$bestDist] != 1) {
                    continue;
                }
                ++$areas[$bestP];
                if (($y == $minY) or ($y == $maxY) or ($x == $minX) or ($x == $maxX)) {
                    $isInfinite[$bestP] = true;
                }
            }
        }
        $finiteAreas = array_filter(
            $areas,
            static fn ($idx) => !isset($isInfinite[$idx]),
            ARRAY_FILTER_USE_KEY,
        );
        $ans1 = intval(max($finiteAreas ?: [0]));
        return [strval($ans1), strval($ans2)];
    }
}
