<?php

declare(strict_types=1);

namespace TBali\Aoc2024;

use TBali\Aoc\SolutionBase;

/**
 * AoC 2024 Day 25: Code Chronicle.
 *
 * @see https://adventofcode.com/2024/day/25
 */
final class Aoc2024Day25 extends SolutionBase
{
    public const YEAR = 2024;
    public const DAY = 25;
    public const TITLE = 'Code Chronicle';
    public const SOLUTIONS = [3317, 0];
    public const EXAMPLE_SOLUTIONS = [[3, 0]];

    public const FILL = '#';
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
        // ---------- Parse input
        $locks = [];
        $keys = [];
        $i = 0;
        while ($i + 6 < count($input)) {
            $shape = [];
            for ($y = $i; $y <= $i + 6; ++$y) {
                if (strlen($input[$y]) != 5) {
                    throw new \Exception('input must be 5 chars wide');
                }
                for ($x = 0; $x < 5; ++$x) {
                    if (($input[$y][$x] != self::FILL) and ($input[$y][$x] != self::EMPTY)) {
                        throw new \Exception('input must contain only `#` and `.`');
                    }
                }
            }
            $code = array_fill(0, 5, 0);
            $is_lock = $input[$i][0] == self::FILL;
            if ($is_lock) {
                for ($x = 0; $x < 5; ++$x) {
                    if (($input[$i][$x] != self::FILL) or ($input[$i + 6][$x] != self::EMPTY)) {
                        throw new \Exception('lock shapes must have filled top row and empty bottom row');
                    }
                    for ($y = 0; $y <= 5; ++$y) {
                        if ($input[$i + $y + 1][$x] == self::EMPTY) {
                            $code[$x] = $y;
                            break;
                        }
                    }
                }
                $locks[] = $code;
            } else {
                for ($x = 0; $x < 5; ++$x) {
                    if (($input[$i][$x] != self::EMPTY) or ($input[$i + 6][$x] != self::FILL)) {
                        throw new \Exception('key shapes must have empty top row and filled bottom row');
                    }
                    for ($y = 0; $y <= 5; ++$y) {
                        if ($input[$i + 5 - $y][$x] == self::EMPTY) {
                            $code[$x] = $y;
                            break;
                        }
                    }
                }
                $keys[] = $code;
            }
            if (($i + 7 < count($input)) and ($input[$i + 7] != '')) {
                throw new \Exception('shapes must be separated by an empty line');
            }
            $i += 8;
        }
        // ---------- Part 1
        $ans1 = 0;
        foreach ($locks as $lock) {
            foreach ($keys as $key) {
                $is_ok = true;
                for ($x = 0; $x < 5; ++$x) {
                    if ($lock[$x] + $key[$x] > 5) {
                        $is_ok = false;
                        break;
                    }
                }
                if ($is_ok) {
                    ++$ans1;
                }
            }
        }
        $ans2 = 0;
        return [strval($ans1), strval($ans2)];
    }
}
