<?php

declare(strict_types=1);

namespace TBali\Aoc2024;

use TBali\Aoc\SolutionBase;

/**
 * AoC 2024 Day 8: Resonant Collinearity.
 *
 * @see https://adventofcode.com/2024/day/8
 */
final class Aoc2024Day08 extends SolutionBase
{
    public const YEAR = 2024;
    public const DAY = 8;
    public const TITLE = 'Resonant Collinearity';
    public const SOLUTIONS = [320, 1157];
    public const EXAMPLE_SOLUTIONS = [[14, 34], [3, 9]];

    public const EMPTY = '.';

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
        $max_y = count($input);
        $max_x = strlen($input[0]);
        if (array_any(array_map(strlen(...), $input), static fn (int $x): bool => $x != $max_x)) {
            throw new \Exception('grid must be rectangular');
        }
        $antennas = [];
        for ($y = 0; $y < $max_y; ++$y) {
            for ($x = 0; $x < $max_x; ++$x) {
                $c = $input[$y][$x];
                if ($input[$y][$x] == self::EMPTY) {
                    continue;
                }
                if (isset($antennas[$c])) {
                    $antennas[$c][] = [$x, $y];
                } else {
                    $antennas[$c] = [[$x, $y]];
                }
            }
        }
        // ---------- Part 1
        $antinodes_part1 = [];
        foreach ($antennas as $positions) {
            foreach ($positions as [$x1, $y1]) {
                foreach ($positions as [$x2, $y2]) {
                    if (($x1 == $x2) and ($y1 == $y2)) {
                        continue;
                    }
                    $x = $x2 + $x2 - $x1;
                    $y = $y2 + $y2 - $y1;
                    if (($x >= 0) and ($x < $max_x) and ($y >= 0) and ($y < $max_y)) {
                        $antinodes_part1[$x | ($y << 32)] = true;
                    }
                    $x = $x1 + $x1 - $x2;
                    $y = $y1 + $y1 - $y2;
                    if (($x >= 0) and ($x < $max_x) and ($y >= 0) and ($y < $max_y)) {
                        $antinodes_part1[$x | ($y << 32)] = true;
                    }
                }
            }
        }
        $ans1 = count($antinodes_part1);
        // ---------- Part 2
        $antinodes_part2 = [];
        foreach ($antennas as $positions) {
            foreach ($positions as [$x1, $y1]) {
                foreach ($positions as [$x2, $y2]) {
                    if (($x1 == $x2) and ($y1 == $y2)) {
                        continue;
                    }
                    $x = $x2;
                    $y = $y2;
                    while (($x >= 0) and ($x < $max_x) and ($y >= 0) and ($y < $max_y)) {
                        $antinodes_part2[$x | ($y << 32)] = true;
                        $x += $x2 - $x1;
                        $y += $y2 - $y1;
                    }
                    $x = $x1;
                    $y = $y1;
                    while (($x >= 0) and ($x < $max_x) and ($y >= 0) and ($y < $max_y)) {
                        $antinodes_part2[$x | ($y << 32)] = true;
                        $x += $x1 - $x2;
                        $y += $y1 - $y2;
                    }
                }
            }
        }
        $ans2 = count($antinodes_part2);
        return [strval($ans1), strval($ans2)];
    }
}
