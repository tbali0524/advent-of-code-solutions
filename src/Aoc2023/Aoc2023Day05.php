<?php

declare(strict_types=1);

namespace TBali\Aoc2023;

use TBali\Aoc\SolutionBase;

/**
 * AoC 2023 Day 5: If You Give A Seed A Fertilizer.
 *
 * Part 1: What is the lowest location number that corresponds to any of the initial seed numbers?
 * Part 2: Consider all of the initial seed numbers listed in the ranges on the first line of the almanac.
 *         What is the lowest location number that corresponds to any of the initial seed numbers?
 *
 * @see https://adventofcode.com/2023/day/5
 */
final class Aoc2023Day05 extends SolutionBase
{
    public const YEAR = 2023;
    public const DAY = 5;
    public const TITLE = 'If You Give A Seed A Fertilizer';
    public const SOLUTIONS = [289863851, 60568880];
    public const EXAMPLE_SOLUTIONS = [[35, 46]];

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
        if (!str_starts_with($input[0], 'seeds: ') or (count($input) < 4) or ($input[1] != '')) {
            throw new \Exception('Invalid input');
        }
        $seeds = array_map(intval(...), explode(' ', substr($input[0], 7)));
        $maps = [];
        for ($i = 1; $i < count($input); ++$i) {
            if ($input[$i] == '') {
                ++$i;
                if (!str_ends_with($input[$i], ' map:')) {
                    throw new \Exception('Invalid input');
                }
                $maps[] = [];
                continue;
            }
            $a = array_map(intval(...), explode(' ', $input[$i]));
            if (count($a) != 3) {
                throw new \Exception('Invalid input');
            }
            $maps[count($maps) - 1][] = $a;
        }
        // ---------- Part 1
        $ans1 = PHP_INT_MAX;
        foreach ($seeds as $seed) {
            $prev = $seed;
            foreach ($maps as $map) {
                $next = $prev;
                foreach ($map as [$dest, $source, $len]) {
                    if (($prev >= $source) and ($prev < $source + $len)) {
                        $next = $dest + $prev - $source;
                        break;
                    }
                }
                $prev = $next;
            }
            if ($next < $ans1) {
                $ans1 = $next;
            }
        }
        // ---------- Part 2
        $seedRanges = array_chunk($seeds, 2);
        $prevRanges = $seedRanges;
        foreach ($maps as $map) {
            $nextRanges = [];
            $q = $prevRanges;
            $idxRead = 0;
            while ($idxRead < count($q)) {
                [$rangeFrom, $rangeLen] = $q[$idxRead];
                ++$idxRead;
                $isProcessed = false;
                foreach ($map as [$dest, $source, $mapLen]) {
                    if (($rangeFrom + $rangeLen <= $source) or ($source + $mapLen <= $rangeFrom)) {
                        continue;
                    }
                    if ($rangeFrom < $source) {
                        $q[] = [$rangeFrom, $source - $rangeFrom];
                    }
                    if ($source + $mapLen < $rangeFrom + $rangeLen) {
                        $q[] = [$source + $mapLen, $rangeFrom + $rangeLen - ($source + $mapLen)];
                    }
                    $overlapFrom = intval(max($source, $rangeFrom));
                    $overlapTo = intval(min($source + $mapLen, $rangeFrom + $rangeLen));
                    $overlapLen = $overlapTo - $overlapFrom;
                    $nextRanges[] = [$overlapFrom + $dest - $source, $overlapLen];
                    $isProcessed = true;
                    break;
                }
                if (!$isProcessed) {
                    $nextRanges[] = [$rangeFrom, $rangeLen];
                }
            }
            $prevRanges = $nextRanges;
        }
        $ans2 = intval(min(array_map(
            static fn (array $a): int => $a[0],
            $nextRanges,
        ) ?: [0]));
        return [strval($ans1), strval($ans2)];
    }
}
