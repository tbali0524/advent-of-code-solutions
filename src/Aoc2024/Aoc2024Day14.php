<?php

declare(strict_types=1);

namespace TBali\Aoc2024;

use TBali\Aoc\SolutionBase;

/**
 * AoC 2024 Day 14: Restroom Redoubt.
 *
 * @see https://adventofcode.com/2024/day/14
 */
final class Aoc2024Day14 extends SolutionBase
{
    public const YEAR = 2024;
    public const DAY = 14;
    public const TITLE = 'Restroom Redoubt';
    public const SOLUTIONS = [229069152, 7383];
    public const EXAMPLE_SOLUTIONS = [[12, 0]];

    public const MAX_XY_EXAMPLE = [11, 7];
    public const MAX_XY = [101, 103];
    public const MAX_TURNS_PART1 = 100;
    public const MAX_TURNS_PART2 = 10000;
    public const DRAW_RESULT = false;

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
        $positions = [];
        $velocities = [];
        foreach ($input as $row) {
            $count = sscanf($row, 'p=%d,%d v=%d,%d', $px, $py, $vx, $vy);
            if ($count != 4) {
                throw new \Exception('Invalid input');
            }
            $positions[] = [intval($px), intval($py)];
            $velocities[] = [intval($vx), intval($vy)];
        }
        // ---------- Part 1
        if (count($input) == 12) {
            $max_xy = self::MAX_XY_EXAMPLE;
        } else {
            $max_xy = self::MAX_XY;
        }
        $count_quadrants = [0, 0, 0, 0];
        for ($idx_robot = 0; $idx_robot < count($input); ++$idx_robot) {
            $quadrant = 0;
            $is_ok = true;
            for ($d = 0; $d <= 1; ++$d) {
                $max = $max_xy[$d];
                $p = $positions[$idx_robot][$d];
                $v = $velocities[$idx_robot][$d];
                $final_pos = ($p + ($v + $max) * self::MAX_TURNS_PART1) % $max;
                if ($final_pos == intdiv($max, 2)) {
                    $is_ok = false;
                    break;
                }
                if ($final_pos > intdiv($max, 2)) {
                    $quadrant += $d + 1;
                }
            }
            if ($is_ok) {
                ++$count_quadrants[$quadrant];
            }
        }
        $ans1 = intval(array_product($count_quadrants));
        // ---------- Part 2
        if (count($input) == 12) {
            return [strval($ans1), '0'];
        }
        $ans2 = $this->drawSim($positions, $velocities);
        return [strval($ans1), strval($ans2)];
    }

    /**
     * @param array<int, array<int, int>> $positions
     * @param array<int, array<int, int>> $velocities
     */
    private function drawSim(array $positions, array $velocities): int
    {
        $ans = 0;
        $pattern = str_repeat('*', 20);
        for ($turn = 1; $turn <= self::MAX_TURNS_PART2; ++$turn) {
            $grid = array_fill(0, self::MAX_XY[1], str_repeat('.', self::MAX_XY[0]));
            for ($idx_robot = 0; $idx_robot < count($positions); ++$idx_robot) {
                $pos = [0, 0];
                for ($d = 0; $d <= 1; ++$d) {
                    $max = self::MAX_XY[$d];
                    $p = $positions[$idx_robot][$d];
                    $v = $velocities[$idx_robot][$d];
                    $pos[$d] = ($p + ($v + $max) * $turn) % $max;
                }
                $grid[$pos[1]][$pos[0]] = '*';
            }
            for ($y = 0; $y < count($grid); ++$y) {
                if (str_contains($grid[$y], $pattern)) {
                    $ans = $turn;
                    // @phpstan-ignore if.alwaysFalse
                    if (self::DRAW_RESULT) {
                        // @codeCoverageIgnoreStart
                        echo 'Turn #' . $turn, PHP_EOL;
                        for ($y1 = 0; $y1 < count($grid); ++$y1) {
                            echo $grid[$y1], PHP_EOL;
                        }
                        // @codeCoverageIgnoreEnd
                    }
                    break 2;
                }
            }
        }
        return $ans;
    }
}
