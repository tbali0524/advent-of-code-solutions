<?php

declare(strict_types=1);

namespace TBali\Aoc2024;

use TBali\Aoc\SolutionBase;

/**
 * AoC 2024 Day 4: Ceres Search.
 *
 * @see https://adventofcode.com/2024/day/4
 */
final class Aoc2024Day04 extends SolutionBase
{
    public const YEAR = 2024;
    public const DAY = 4;
    public const TITLE = '';
    public const SOLUTIONS = [2458, 1945];
    public const EXAMPLE_SOLUTIONS = [[18, 0], [0, 9]];

    public const TARGET = 'XMAS';

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
        // ---------- Check input
        $max_y = count($input);
        $max_x = strlen($input[0]);
        if (array_any(array_map(strlen(...), $input), static fn (int $x): bool => $x != $max_x)) {
            throw new \Exception('grid must be rectangular');
        }
        // ---------- Part 1
        $ans1 = 0;
        for ($start_y = 0; $start_y < $max_y; ++$start_y) {
            for ($start_x = 0; $start_x < $max_x; ++$start_x) {
                if ($input[$start_y][$start_x] != self::TARGET[0]) {
                    continue;
                }
                for ($dy = -1; $dy <= 1; ++$dy) {
                    for ($dx = -1; $dx <= 1; ++$dx) {
                        if (($dy == 0) and ($dx == 0)) {
                            continue;
                        }
                        $is_ok = true;
                        $x = $start_x;
                        $y = $start_y;
                        for ($i = 1; $i < strlen(self::TARGET); ++$i) {
                            $x += $dx;
                            $y += $dy;
                            if (
                                ($y < 0)
                                or ($y >= $max_y)
                                or ($x < 0)
                                or ($x >= $max_x)
                                or ($input[$y][$x] != self::TARGET[$i])
                            ) {
                                $is_ok = false;
                                break;
                            }
                        }
                        if ($is_ok) {
                            ++$ans1;
                        }
                    }
                }
            }
        }
        // ---------- Part 2
        $ans2 = 0;
        for ($y = 1; $y < $max_y - 1; ++$y) {
            for ($x = 1; $x < $max_x - 1; ++$x) {
                if ($input[$y][$x] != 'A') {
                    continue;
                }
                $c1 = $input[$y - 1][$x - 1];
                $c2 = $input[$y + 1][$x + 1];
                if (!(($c1 == 'M' && $c2 == 'S') || ($c1 == 'S' && $c2 == 'M'))) {
                    continue;
                }
                $c1 = $input[$y - 1][$x + 1];
                $c2 = $input[$y + 1][$x - 1];
                if (!(($c1 == 'M' && $c2 == 'S') || ($c1 == 'S' && $c2 == 'M'))) {
                    continue;
                }
                ++$ans2;
            }
        }
        return [strval($ans1), strval($ans2)];
    }
}
