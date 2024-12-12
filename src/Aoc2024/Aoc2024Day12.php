<?php

declare(strict_types=1);

namespace TBali\Aoc2024;

use TBali\Aoc\SolutionBase;

/**
 * AoC 2024 Day 12: Garden Groups.
 *
 * @see https://adventofcode.com/2024/day/12
 */
final class Aoc2024Day12 extends SolutionBase
{
    public const YEAR = 2024;
    public const DAY = 12;
    public const TITLE = 'Garden Groups';
    public const SOLUTIONS = [1344578, 814302];
    public const EXAMPLE_SOLUTIONS = [[140, 80], [772, 436], [1930, 1206], [0, 236], [0, 368]];

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
        $max_y = count($input);
        $max_x = strlen($input[0]);
        if (array_any(array_map(strlen(...), $input), static fn (int $x): bool => $x != $max_x)) {
            throw new \Exception('grid must be rectangular');
        }
        // ---------- Part 1 + 2
        $region_grid = array_fill(0, $max_y, array_fill(0, $max_x, -1));
        $side_grid = array_fill(0, $max_y, array_fill(0, $max_x, [-1, -1, -1, -1]));
        $areas = [];
        $perimeters = [];
        $count_regions = 0;
        for ($start_y = 0; $start_y < $max_y; ++$start_y) {
            for ($start_x = 0; $start_x < $max_x; ++$start_x) {
                if ($region_grid[$start_y][$start_x] >= 0) {
                    continue;
                }
                ++$count_regions;
                $region_char = $input[$start_y][$start_x];
                $areas[] = 0;
                $perimeters[] = 0;
                $q = [[$start_x, $start_y]];
                $region_grid[$start_y][$start_x] = $count_regions - 1;
                $idx_read = 0;
                while ($idx_read < count($q)) {
                    [$x, $y] = $q[$idx_read];
                    ++$idx_read;
                    ++$areas[$count_regions - 1];
                    foreach ([[1, 0], [0, 1], [-1, 0], [0, -1]] as $dir => [$dx, $dy]) {
                        $x1 = $x + $dx;
                        $y1 = $y + $dy;
                        if (
                            $x1 < 0
                            || $x1 >= $max_x
                            || $y1 < 0
                            || $y1 >= $max_y
                            || $input[$y1][$x1] != $region_char
                        ) {
                            ++$perimeters[$count_regions - 1];
                            $side_grid[$y][$x][$dir] = $count_regions - 1;
                            continue;
                        }
                        if ($region_grid[$y1][$x1] >= 0) {
                            continue;
                        }
                        $region_grid[$y1][$x1] = $count_regions - 1;
                        $q[] = [$x1, $y1];
                    }
                }
            }
        }
        $ans1 = 0;
        for ($i = 0; $i < $count_regions; ++$i) {
            $ans1 += $areas[$i] * $perimeters[$i];
        }
        $sides = array_fill(0, $count_regions, 0);
        for ($dir = 0; $dir < 4; ++$dir) {
            if ($dir % 2 == 0) {
                for ($x = 0; $x < $max_x; ++$x) {
                    for ($y = 0; $y < $max_y; ++$y) {
                        $idx_region = $side_grid[$y][$x][$dir];
                        if ($idx_region < 0) {
                            continue;
                        }
                        if ($y == 0 || $side_grid[$y - 1][$x][$dir] != $idx_region) {
                            ++$sides[$idx_region];
                        }
                    }
                }
            } else {
                for ($y = 0; $y < $max_y; ++$y) {
                    for ($x = 0; $x < $max_x; ++$x) {
                        $idx_region = $side_grid[$y][$x][$dir];
                        if ($idx_region < 0) {
                            continue;
                        }
                        if ($x == 0 || $side_grid[$y][$x - 1][$dir] != $idx_region) {
                            ++$sides[$idx_region];
                        }
                    }
                }
            }
        }
        $ans2 = 0;
        for ($i = 0; $i < $count_regions; ++$i) {
            $ans2 += $areas[$i] * $sides[$i];
        }
        return [strval($ans1), strval($ans2)];
    }
}
