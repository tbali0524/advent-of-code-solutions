<?php

declare(strict_types=1);

namespace TBali\Aoc2016;

use TBali\Aoc\SolutionBase;

/**
 * AoC 2016 Day 4: Security Through Obscurity.
 *
 * Part 1: What is the sum of the sector IDs of the real rooms?
 * Part 2: What is the sector ID of the room where North Pole objects are stored?
 *
 * @see https://adventofcode.com/2016/day/4
 */
final class Aoc2016Day04 extends SolutionBase
{
    public const YEAR = 2016;
    public const DAY = 4;
    public const TITLE = 'Security Through Obscurity';
    public const SOLUTIONS = [137896, 501];
    public const EXAMPLE_SOLUTIONS = [[1514, 0], [0, 0]];

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
        // example for Part 2: $input = ['qzmt-zixmtkozy-ivhz-343[zimth]'];
        foreach ($input as $line) {
            $origNames[] = substr($line, 0, -11);
            $names[] = str_replace('-', '', substr($line, 0, -11));
            $ids[] = intval(substr($line, -10, 3));
            $checksums[] = substr($line, -6, 5);
        }
        // ---------- Part 1
        $ans1 = 0;
        $realRoomIndices = [];
        foreach ($names as $idx => $name) {
            $dist = array_count_values(str_split($name));
            ksort($dist);
            arsort($dist);
            $top = substr(implode('', array_keys($dist)), 0, 5);
            if ($top == $checksums[$idx]) {
                $ans1 += $ids[$idx];
                $realRoomIndices[] = $idx;
            }
        }
        // ---------- Part 2
        $ans2 = 0;
        foreach ($realRoomIndices as $idx) {
            $s = $origNames[$idx];
            for ($i = 0; $i < strlen($s); ++$i) {
                if ($s[$i] == '-') {
                    $s[$i] = ' ';
                    continue;
                }
                $s[$i] = chr(ord('a') + ($ids[$idx] + ord($s[$i]) - ord('a')) % 26);
            }
            if (str_contains($s, 'northpole')) {
                $ans2 = $ids[$idx];
                break;
            }
        }
        return [strval($ans1), strval($ans2)];
    }
}
