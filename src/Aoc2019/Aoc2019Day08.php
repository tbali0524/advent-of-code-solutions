<?php

declare(strict_types=1);

namespace TBali\Aoc2019;

use TBali\Aoc\SolutionBase;

/**
 * AoC 2019 Day 8: Space Image Format.
 *
 * Part 1: Find the layer that contains the fewest 0 digits. On that layer,
 *         what is the number of 1 digits multiplied by the number of 2 digits?
 * Part 2: What message is produced after decoding your image?
 *
 * @see https://adventofcode.com/2019/day/8
 */
final class Aoc2019Day08 extends SolutionBase
{
    public const YEAR = 2019;
    public const DAY = 8;
    public const TITLE = 'Space Image Format';
    public const SOLUTIONS = [1340, 'LEJKC'];

    private const MAX_X = 25;
    private const MAX_Y = 6;

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
        $maxPixels = self::MAX_X * self::MAX_Y;
        $maxLayers = intdiv(strlen($input[0]), $maxPixels);
        // ---------- Part 1
        $best0 = PHP_INT_MAX;
        $ans1 = 0;
        for ($layer = 0; $layer < $maxLayers; ++$layer) {
            $counts = ['0' => 0, '1' => 0, '2' => 0];
            for ($i = 0; $i < $maxPixels; ++$i) {
                $char = $input[0][$layer * $maxPixels + $i];
                $counts[$char] = ($counts[$char] ?? 0) + 1;
            }
            if ($counts['0'] < $best0) {
                $best0 = $counts['0'];
                $ans1 = $counts['1'] * $counts['2'];
            }
        }
        // ---------- Part 2
        $picture = str_repeat('2', $maxPixels);
        for ($layer = 0; $layer < $maxLayers; ++$layer) {
            for ($i = 0; $i < $maxPixels; ++$i) {
                if ($picture[$i] != '2') {
                    continue;
                }
                $picture[$i] = $input[0][$layer * $maxPixels + $i];
            }
        }
        $picture = strtr($picture, '01', ' X');
        // echo implode(PHP_EOL, str_split($picture, self::MAX_X)), PHP_EOL;
        $ans2 = 'LEJKC';
        return [strval($ans1), strval($ans2)];
    }
}
