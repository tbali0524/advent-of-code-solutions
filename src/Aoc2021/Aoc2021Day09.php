<?php

declare(strict_types=1);

namespace TBali\Aoc2021;

use TBali\Aoc\SolutionBase;

/**
 * AoC 2021 Day 9: Smoke Basin.
 *
 * Part 1: What is the sum of the risk levels of all low points on your heightmap?
 * Part 2: What do you get if you multiply together the sizes of the three largest basins?
 *
 * @see https://adventofcode.com/2021/day/9
 */
final class Aoc2021Day09 extends SolutionBase
{
    public const YEAR = 2021;
    public const DAY = 9;
    public const TITLE = 'Smoke Basin';
    public const SOLUTIONS = [486, 1059300];
    public const EXAMPLE_SOLUTIONS = [[15, 1134]];

    private const DELTA_XY = [[0, -1], [1, 0], [0, 1], [-1, 0]];

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
        // ---------- Part 1
        $maxY = count($input);
        $maxX = strlen($input[0]);
        $lowPoints = [];
        $ans1 = 0;
        foreach ($input as $y => $row) {
            for ($x = 0; $x < strlen($row); ++$x) {
                $isOk = true;
                foreach (self::DELTA_XY as [$dx, $dy]) {
                    $x1 = $x + $dx;
                    $y1 = $y + $dy;
                    if (($x1 < 0) or ($x1 >= $maxX) or ($y1 < 0) or ($y1 >= $maxY)) {
                        continue;
                    }
                    if ($input[$y1][$x1] <= $row[$x]) {
                        $isOk = false;
                        break;
                    }
                }
                if ($isOk) {
                    $ans1 += intval($row[$x]) + 1;
                    $lowPoints[] = [$x, $y];
                }
            }
        }
        // ---------- Part 2
        $basinSize = [];
        foreach ($lowPoints as $idxBasin => [$lowX, $lowY]) {
            $basinSize[$idxBasin] = 0;
            $hash = $lowX . ',' . $lowY;
            $visited = [$hash => true];
            $q = [[$lowX, $lowY]];
            $readIdx = 0;
            while ($readIdx < count($q)) {
                [$x, $y] = $q[$readIdx];
                ++$readIdx;
                ++$basinSize[$idxBasin];
                foreach (self::DELTA_XY as [$dx, $dy]) {
                    $x1 = $x + $dx;
                    $y1 = $y + $dy;
                    if (($x1 < 0) or ($x1 >= $maxX) or ($y1 < 0) or ($y1 >= $maxY)) {
                        continue;
                    }
                    if ($input[$y1][$x1] == '9') {
                        continue;
                    }
                    $hash = $x1 . ',' . $y1;
                    if (isset($visited[$hash])) {
                        continue;
                    }
                    $visited[$hash] = true;
                    $q[] = [$x1, $y1];
                }
            }
        }
        rsort($basinSize);
        $ans2 = ($basinSize[0] ?? 0) * ($basinSize[1] ?? 0) * ($basinSize[2] ?? 0);
        return [strval($ans1), strval($ans2)];
    }
}
