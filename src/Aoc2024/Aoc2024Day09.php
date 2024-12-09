<?php

declare(strict_types=1);

namespace TBali\Aoc2024;

use TBali\Aoc\SolutionBase;

/**
 * AoC 2024 Day 9: Disk Fragmenter.
 *
 * @see https://adventofcode.com/2024/day/9
 */
final class Aoc2024Day09 extends SolutionBase
{
    public const YEAR = 2024;
    public const DAY = 9;
    public const TITLE = 'Disk Fragmenter';
    public const SOLUTIONS = [6332189866718, 6353648390778];
    public const EXAMPLE_SOLUTIONS = [[1928, 2858]];

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
        if (count($input) != 1) {
            throw new \Exception('input must have a single line');
        }
        $data = array_map(intval(...), str_split($input[0]));
        // ---------- Part 1
        $disk = [];
        foreach ($data as $idx => $length) {
            for ($i = 0; $i < $length; ++$i) {
                match ($idx % 2) {
                    0 => $disk[] = intdiv($idx, 2),
                    1 => $disk[] = -1,
                };
            }
        }
        $left = 0;
        $right = count($disk) - 1;
        while (true) {
            while (($left < $right) and ($disk[$left] >= 0)) {
                ++$left;
            }
            while (($left < $right) and ($disk[$right] < 0)) {
                --$right;
            }
            if ($left == $right) {
                break;
            }
            $disk[$left] = $disk[$right];
            $disk[$right] = -1;
        }
        $pos = 0;
        $ans1 = 0;
        while (($pos < count($disk)) and ($disk[$pos] >= 0)) {
            $ans1 += $pos * $disk[$pos];
            ++$pos;
        }
        // ---------- Part 2
        $files = [];
        $gaps = [];
        $pos = 0;
        foreach ($data as $idx => $length) {
            match ($idx % 2) {
                0 => $files[] = [$pos, $length, intdiv($idx, 2)],
                1 => $gaps[] = [$pos, $length],
            };
            $pos += $length;
        }
        $idx_file = count($files) - 1;
        while (true) {
            [$file_pos, $file_len, $file_id] = $files[$idx_file];
            $idx_gap = array_find_key(
                $gaps,
                static fn (array $x): bool => $x[0] < $file_pos && $x[1] >= $file_len,
            );
            if (!is_null($idx_gap)) {
                [$gap_pos, $gap_len] = $gaps[$idx_gap];
                if ($gap_len > $file_len) {
                    $gaps[$idx_gap] = [$gap_pos + $file_len, $gap_len - $file_len];
                } else {
                    unset($gaps[$idx_gap]);
                }
                $files[$idx_file] = [$gap_pos, $file_len, $file_id];
            }
            if ($idx_file == 0) {
                break;
            }
            --$idx_file;
        }
        usort($files, static fn (array $a, array $b): int => $a[0] <=> $b[0]);
        $ans2 = 0;
        foreach ($files as $file) {
            [$file_pos, $file_len, $file_id] = $file;
            for ($i = 0; $i < $file_len; ++$i) {
                $ans2 += ($file_pos + $i) * $file_id;
            }
        }
        return [strval($ans1), strval($ans2)];
    }
}
