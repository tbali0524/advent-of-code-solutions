<?php

declare(strict_types=1);

namespace TBali\Aoc2024;

use TBali\Aoc\SolutionBase;

/**
 * AoC 2024 Day 10: Hoof It.
 *
 * @see https://adventofcode.com/2024/day/10
 */
final class Aoc2024Day10 extends SolutionBase
{
    public const YEAR = 2024;
    public const DAY = 10;
    public const TITLE = 'Hoof It';
    public const SOLUTIONS = [674, 1372];
    public const EXAMPLE_SOLUTIONS = [
        [36, 0],
        [1, 0],
        [2, 0],
        [4, 0],
        [3, 0],
        [0, 3],
        [0, 13],
        [0, 227],
        [0, 81],
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
        $max_x = strlen($input[0]);
        if (array_any(array_map(strlen(...), $input), static fn (int $x): bool => $x != $max_x)) {
            throw new \Exception('grid must be rectangular');
        }
        // ---------- Part 1 + 2
        $ans1 = $this->solvePart($input);
        $ans2 = $this->solvePart($input, false);
        return [strval($ans1), strval($ans2)];
    }

    /**
     * @param array<int, string> $grid
     */
    private function solvePart(array $grid, bool $is_part1 = true): int
    {
        $max_y = count($grid);
        $max_x = strlen($grid[0]);
        $scores = [];
        for ($start_y = 0; $start_y < $max_y; ++$start_y) {
            for ($start_x = 0; $start_x < $max_x; ++$start_x) {
                if ($grid[$start_y][$start_x] != '0') {
                    continue;
                }
                $start_pos = $start_x | ($start_y << 32);
                $scores[$start_pos] = 0;
                $visited = [];
                $visited[$start_pos] = true;
                $q = [[$start_x, $start_y, 0]];
                $idx_read = 0;
                while ($idx_read < count($q)) {
                    [$x, $y, $height] = $q[$idx_read];
                    ++$idx_read;
                    if ($height == 9) {
                        ++$scores[$start_pos];
                        continue;
                    }
                    foreach ([[1, 0], [0, 1], [-1, 0], [0, -1]] as [$dx, $dy]) {
                        $x1 = $x + $dx;
                        $y1 = $y + $dy;
                        if ($y1 < 0 || $y1 >= $max_y || $x1 < 0 || $x1 >= $max_x) {
                            continue;
                        }
                        $pos1 = $x1 | ($y1 << 32);
                        if ($is_part1 and isset($visited[$pos1])) {
                            continue;
                        }
                        $c = $grid[$y1][$x1];
                        if ($c == '.') {
                            continue;
                        }
                        $height1 = intval($c);
                        if ($height1 == $height + 1) {
                            $visited[$pos1] = true;
                            $q[] = [$x1, $y1, $height1];
                        }
                    }
                }
            }
        }
        return intval(array_sum($scores));
    }
}
