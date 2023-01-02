<?php

declare(strict_types=1);

namespace TBali\Aoc2017;

use TBali\Aoc\SolutionBase;

/**
 * AoC 2017 Day 10: Knot Hash.
 *
 * Part 1: Once this process is complete, what is the result of multiplying the first two numbers in the list?
 * Part 2: Treating your puzzle input as a string of ASCII characters, what is the Knot Hash of your puzzle input?
 *         Ignore any leading or trailing whitespace you might encounter.
 *
 * Topics: walking simulation on hex grid
 *
 * @see https://adventofcode.com/2017/day/10
 */
final class Aoc2017Day10 extends SolutionBase
{
    public const YEAR = 2017;
    public const DAY = 10;
    public const TITLE = 'Knot Hash';
    public const SOLUTIONS = [52070, '7f94112db4e32e19cf6502073c66f9bb'];
    public const EXAMPLE_SOLUTIONS = [[12, 0], [0, '3efbe78a8d82f29979031a4aa0b16a9d']];
    public const EXAMPLE_STRING_INPUTS = ['3,4,1,5', '1,2,3'];

    private const LIST_SIZE_EXAMPLE1_PART1 = 5;
    private const LIST_SIZE_INPUT = 256;

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
        /** @var array<int, int> */
        $data = array_map('intval', explode(',', $input[0] ?? ''));
        // ---------- Part 1
        $listSize = count($data) == 4 ? self::LIST_SIZE_EXAMPLE1_PART1 : self::LIST_SIZE_INPUT;
        $list = range(0, $listSize - 1);
        $pos = 0;
        $skipSize = 0;
        foreach ($data as $len) {
            if ($len > $listSize) {
                throw new \Exception('Invalid input');
            }
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
        $ans1 = ($list[0] ?? 0) * ($list[1] ?? 0);
        // ---------- Part 2
        /** @var array<int, int> */
        $data = array_map('ord', str_split($input[0] ?? ''));
        $data = array_merge($data, [17, 31, 73, 47, 23]);
        $listSize = self::LIST_SIZE_INPUT;
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
        $ans2 = '';
        for ($i = 0; $i < 16; ++$i) {
            $byte = 0;
            for ($j = 0; $j < 16; ++$j) {
                $byte ^= $list[$i * 16 + $j];
            }
            $ans2 .= str_pad(dechex($byte), 2, '0', STR_PAD_LEFT);
        }
        return [strval($ans1), $ans2];
    }
}
