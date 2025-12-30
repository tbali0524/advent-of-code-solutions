<?php

declare(strict_types=1);

namespace TBali\Aoc2025;

use TBali\Aoc\SolutionBase;

/**
 * AoC 2025 Day 9: Movie Theater.
 *
 * @see https://adventofcode.com/2025/day/9
 */
final class Aoc2025Day09 extends SolutionBase
{
    public const YEAR = 2025;
    public const DAY = 9;
    public const TITLE = 'Movie Theater';
    public const SOLUTIONS = [4774877510, 1560475800];
    public const EXAMPLE_SOLUTIONS = [[50, 24]];

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
            $p = array_map(intval(...), explode(',', $line));
            if (count($p) != 2) {
                throw new \Exception('Invalid input');
            }
            $points[] = $p;
        }
        // ---------- Part 1
        $ans1 = 0;
        for ($a = 0; $a < count($points); ++$a) {
            for ($b = $a + 1; $b < count($points); ++$b) {
                [$ax, $ay] = $points[$a];
                [$bx, $by] = $points[$b];
                $area = (abs($ax - $bx) + 1) * (abs($ay - $by) + 1);
                if ($area > $ans1) {
                    $ans1 = $area;
                }
            }
        }
        // ---------- Part 2
        $x_set = [];
        $y_set = [];
        $point_set = [];
        foreach ($points as [$x, $y]) {
            $x_set[$x] = true;
            $y_set[$y] = true;
            $point_set[$x . ' ' . $y] = true;
        }
        $horiz_lines = [];
        $vert_lines = [];
        for ($a = 0; $a < count($points); ++$a) {
            $b = ($a + 1) % count($points);
            [$ax, $ay] = $points[$a];
            [$bx, $by] = $points[$b];
            if ($ax > $bx) {
                [$ax, $bx] = [$bx, $ax];
            }
            if ($ay > $by) {
                [$ay, $by] = [$by, $ay];
            }
            if ($ay == $by) {
                $horiz_lines[] = [$ay, $ax, $bx];
            } elseif ($ax == $bx) {
                $vert_lines[] = [$ax, $ay, $by];
            } else {
                throw new \Exception('Invalid input');
            }
        }
        $rect_top = [];
        $rect_left = [];
        $rect_inside = [];
        $rect_topleft = [];
        foreach (array_keys($x_set) as $ax) {
            foreach (array_keys($y_set) as $ay) {
                $has_top = false;
                if (!isset($x_set[$ax + 1])) {
                    $crossing = 0;
                    foreach ($horiz_lines as [$y, $x1, $x2]) {
                        if ($y < $ay && $x1 <= $ax + 1 && $ax + 1 <= $x2) {
                            ++$crossing;
                        } elseif ($y == $ay && $x1 <= $ax + 1 && $ax + 1 <= $x2) {
                            $has_top = true;
                        }
                    }
                    if ($crossing % 2 == 1) {
                        $rect_top[$ax . ' ' . $ay] = true;
                    }
                } else {
                    $rect_top[$ax . ' ' . $ay] = true;
                }
                $has_left = false;
                if (!isset($y_set[$ay + 1])) {
                    $crossing = 0;
                    foreach ($vert_lines as [$x, $y1, $y2]) {
                        if ($x < $ax && $y1 <= $ay + 1 && $ay + 1 <= $y2) {
                            ++$crossing;
                        } elseif ($x == $ax && $y1 <= $ay + 1 && $ay + 1 <= $y2) {
                            $has_left = true;
                        }
                    }
                    if ($crossing % 2 == 1) {
                        $rect_left[$ax . ' ' . $ay] = true;
                    }
                } else {
                    $rect_left[$ax . ' ' . $ay] = true;
                }
                if (isset($rect_left[$ax . ' ' . $ay]) != $has_left || isset($rect_top[$ax . ' ' . $ay]) != $has_top) {
                    $rect_inside[$ax . ' ' . $ay] = true;
                }
                if ($has_top) {
                    $rect_top[$ax . ' ' . $ay] = true;
                }
                if ($has_left) {
                    $rect_left[$ax . ' ' . $ay] = true;
                }
                if (
                    isset($point_set[$ax . ' ' . $ay])
                    || isset($rect_top[$ax . ' ' . $ay])
                    || isset($rect_left[$ax . ' ' . $ay])
                ) {
                    $rect_topleft[$ax . ' ' . $ay] = true;
                }
            }
        }
        $ans2 = 0;
        for ($a = 0; $a < count($points); ++$a) {
            for ($b = $a + 1; $b < count($points); ++$b) {
                [$ax, $ay] = $points[$a];
                [$bx, $by] = $points[$b];
                if ($ax > $bx) {
                    [$ax, $bx] = [$bx, $ax];
                }
                if ($ay > $by) {
                    [$ay, $by] = [$by, $ay];
                }
                $is_ok = true;
                foreach (array_keys($x_set) as $px) {
                    foreach (array_keys($y_set) as $py) {
                        if ($px < $ax || $px > $bx || $py < $ay || $py > $by) {
                            continue;
                        }
                        if (!isset($rect_topleft[$px . ' ' . $py])) {
                            $is_ok = false;
                            break 2;
                        }
                        if ($px < $bx && !isset($rect_top[$px . ' ' . $py])) {
                            $is_ok = false;
                            break 2;
                        }
                        if ($py < $by && !isset($rect_left[$px . ' ' . $py])) {
                            $is_ok = false;
                            break 2;
                        }
                        if ($px < $bx && $py < $by && !isset($rect_inside[$px . ' ' . $py])) {
                            $is_ok = false;
                            break 2;
                        }
                    }
                }
                if (!$is_ok) {
                    continue;
                }
                $area = (abs($ax - $bx) + 1) * (abs($ay - $by) + 1);
                if ($area > $ans2) {
                    $ans2 = $area;
                }
            }
        }
        return [strval($ans1), strval($ans2)];
    }
}
