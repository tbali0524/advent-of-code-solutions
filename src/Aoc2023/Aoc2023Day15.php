<?php

declare(strict_types=1);

namespace TBali\Aoc2023;

use TBali\Aoc\SolutionBase;

/**
 * AoC 2023 Day 15: Lens Library.
 *
 * Part 1: Run the HASH algorithm on each step in the initialization sequence. What is the sum of the results?
 * Part 2: What is the focusing power of the resulting lens configuration?
 *
 * @see https://adventofcode.com/2023/day/15
 */
final class Aoc2023Day15 extends SolutionBase
{
    public const YEAR = 2023;
    public const DAY = 15;
    public const TITLE = 'Lens Library';
    public const SOLUTIONS = [517015, 286104];
    public const EXAMPLE_SOLUTIONS = [[1320, 145]];

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
        $data = explode(',', $input[0]);
        $ans1 = array_sum(array_map(self::hash(...), $data));
        // ---------- Part 2
        // Note: php array is just we need for each box: an ordered hashmap
        $ans2 = 0;
        $boxes = array_fill(0, 256, []);
        foreach ($data as $command) {
            if ($command[-1] == '-') {
                $label = substr($command, 0, -1);
                $idBox = self::hash($label);
                unset($boxes[$idBox][$label]);
                continue;
            }
            $a = explode('=', $command);
            if (count($a) != 2) {
                throw new \Exception('Invalid input');
            }
            $label = $a[0];
            $idBox = self::hash($label);
            $value = intval($a[1]);
            $boxes[$idBox][$label] = $value;
        }
        foreach ($boxes as $idBox => $box) {
            $idItem = 0;
            foreach ($box as $value) {
                ++$idItem;
                $ans2 += ($idBox + 1) * $idItem * $value;
            }
        }
        return [strval($ans1), strval($ans2)];
    }

    private static function hash(string $s): int
    {
        return array_reduce(
            str_split($s),
            static fn (int $carry, string $item): int => (($carry + ord($item)) * 17) & 0xFF,
            0,
        );
    }
}
