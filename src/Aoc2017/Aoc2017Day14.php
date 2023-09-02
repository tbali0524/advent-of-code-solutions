<?php

declare(strict_types=1);

namespace TBali\Aoc2017;

use TBali\Aoc\SolutionBase;

/**
 * AoC 2017 Day 14: Disk Defragmentation.
 *
 * Part 1: Given your actual key string, how many squares are used?
 * Part 2: How many regions are present given your key string?
 *
 * Topics: flood fill
 *
 * @see https://adventofcode.com/2017/day/14
 */
final class Aoc2017Day14 extends SolutionBase
{
    public const YEAR = 2017;
    public const DAY = 14;
    public const TITLE = 'Disk Defragmentation';
    public const SOLUTIONS = [8204, 1089];
    public const STRING_INPUT = 'xlqgujun';
    public const EXAMPLE_SOLUTIONS = [[8108, 1242]];
    public const EXAMPLE_STRING_INPUTS = ['flqrgnkx'];

    /** @var array<int, string> */
    private array $grid = [];

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
        $ans1 = 0;
        $this->grid = [];
        for ($y = 0; $y < 128; ++$y) {
            $key = ($input[0] ?? '') . '-' . strval($y);
            $hash = $this->knotHash($key);
            $this->grid[$y] = '';
            for ($i = 0; $i < 4; ++$i) {
                $part = decbin(intval(hexdec(substr($hash, 8 * $i, 8))));
                $this->grid[$y] .= str_pad($part, 32, '0', STR_PAD_LEFT);
                $ans1 += count_chars($part)[ord('1')] ?? 0;
            }
        }
        // ---------- Part 2
        $ans2 = 0;
        for ($y = 0; $y < 128; ++$y) {
            for ($x = 0; $x < 128; ++$x) {
                if ($this->grid[$y][$x] == 0) {
                    continue;
                }
                ++$ans2;
                $this->floodFill($x, $y);
            }
        }
        return [strval($ans1), strval($ans2)];
    }

    private function knotHash(string $key): string
    {
        /** @var array<int, int> */
        $data = array_merge(array_map(ord(...), str_split($key)), [17, 31, 73, 47, 23]);
        $listSize = 256;
        $list = range(0, $listSize - 1);
        $pos = 0;
        $skipSize = 0;
        for ($j = 0; $j < 64; ++$j) {
            foreach ($data as $len) {
                for ($i = 0; $i < intdiv($len, 2); ++$i) {
                    $p1 = ($pos + $i) % $listSize;
                    $p2 = ($pos + $len - 1 - $i) % $listSize;
                    $temp = $list[$p1];
                    $list[$p1] = $list[$p2];
                    $list[$p2] = $temp;
                }
                $pos = ($pos + $len + $skipSize) % $listSize;
                ++$skipSize;
            }
        }
        $ans = '';
        for ($i = 0; $i < 16; ++$i) {
            $byte = 0;
            for ($j = 0; $j < 16; ++$j) {
                $byte ^= $list[$i * 16 + $j];
            }
            $ans .= str_pad(dechex($byte), 2, '0', STR_PAD_LEFT);
        }
        return $ans;
    }

    private function floodFill(int $x, int $y): void
    {
        $this->grid[$y][$x] = '0';
        foreach ([[1, 0], [0, 1], [-1, 0], [0, -1]] as [$dx, $dy]) {
            $x1 = $x + $dx;
            $y1 = $y + $dy;
            if (($x1 < 0) or ($x1 >= 128) or ($y1 < 0) or ($y1 >= 128)) {
                continue;
            }
            if ($this->grid[$y1][$x1] == '0') {
                continue;
            }
            $this->floodFill($x1, $y1);
        }
    }
}
