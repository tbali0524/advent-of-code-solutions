<?php

declare(strict_types=1);

namespace TBali\Aoc2017;

use TBali\Aoc\SolutionBase;

/**
 * AoC 2017 Day 19: A Series of Tubes.
 *
 * Part 1: What letters will it see (in the order it would see them) if it follows the path?
 * Part 2: How many steps does the packet need to go?
 *
 * Topics: walking simulation
 *
 * @see https://adventofcode.com/2017/day/19
 */
final class Aoc2017Day19 extends SolutionBase
{
    public const YEAR = 2017;
    public const DAY = 19;
    public const TITLE = 'A Series of Tubes';
    public const SOLUTIONS = ['LXWCKGRAOY', 17302];
    public const EXAMPLE_SOLUTIONS = [['ABCDEF', 38]];

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
        $maxY = count($input);
        $startX = strpos($input[0] ?? '', '|');
        if ($startX === false) {
            throw new \Exception('Invalid input');
        }
        // ---------- Part 1 + 2
        $ans1 = '';
        $ans2 = -1;
        $x = $startX;
        $y = -1;
        $dx = 0;
        $dy = 1;
        while (true) {
            $x += $dx;
            $y += $dy;
            if (($x < 0) or ($y < 0) or ($y >= $maxY) or ($x >= strlen($input[$y]))) {
                break;
            }
            ++$ans2;
            $c = $input[$y][$x];
            if ($c == ' ') {
                break;
            }
            if (($c == '|') or ($c == '-')) {
                continue;
            }
            if ($c == '+') {
                foreach ([[1, 0], [0, 1], [-1, 0], [0, -1]] as [$dx1, $dy1]) {
                    if (($dx + $dx1 == 0) and ($dy + $dy1 == 0)) {
                        continue;
                    }
                    $x1 = $x + $dx1;
                    $y1 = $y + $dy1;
                    if (($x1 < 0) or ($y1 < 0) or ($y1 >= $maxY) or ($x1 >= strlen($input[$y1]))) {
                        continue;
                    }
                    if ($input[$y1][$x1] == ' ') {
                        continue;
                    }
                    $dx = $dx1;
                    $dy = $dy1;
                    break;
                }
                continue;
            }
            $ans1 .= $c;
        }
        return [$ans1, strval($ans2)];
    }
}
