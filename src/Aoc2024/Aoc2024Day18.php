<?php

declare(strict_types=1);

namespace TBali\Aoc2024;

use TBali\Aoc\SolutionBase;

/**
 * AoC 2024 Day 18: RAM Run.
 *
 * @see https://adventofcode.com/2024/day/18
 */
final class Aoc2024Day18 extends SolutionBase
{
    public const YEAR = 2024;
    public const DAY = 18;
    public const TITLE = 'RAM Run';
    public const SOLUTIONS = [322, '60,21'];
    public const EXAMPLE_SOLUTIONS = [[22, '6,1']];

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
        /** @var array<int, array<int, int>> */
        $data = array_map(
            static fn (string $line): array => array_map(intval(...), explode(',', $line)),
            $input
        );
        if (array_any($data, static fn (array $x): bool => count($x) != 2)) {
            throw new \Exception('Invalid input');
        }
        // ---------- Part 1
        if (count($input) == 25) {
            $max_x = 7;
            $max_y = 7;
            $max_bytes = 12;
        } else {
            // @codeCoverageIgnoreStart
            $max_x = 71;
            $max_y = 71;
            $max_bytes = 1024;
            // @codeCoverageIgnoreEnd
        }
        $has_byte = [];
        for ($i = 0; $i < $max_bytes; ++$i) {
            [$x, $y] = $data[$i];
            $has_byte[$x | ($y << 16)] = true;
        }
        $ans1 = self::bfs($has_byte, $max_x, $max_y);
        // ---------- Part 2
        $ans2 = '0';
        for ($i = $max_bytes; $i < count($data); ++$i) {
            [$x, $y] = $data[$i];
            $has_byte[$x | ($y << 16)] = true;
            if (self::bfs($has_byte, $max_x, $max_y) < 0) {
                $ans2 = $x . ',' . $y;
                break;
            }
        }
        return [strval($ans1), $ans2];
    }

    /**
     * @param array<int, bool> $has_byte
     */
    private function bfs(array $has_byte, int $max_x, int $max_y): int
    {
        $visited = [];
        $q = [];
        $x = 0;
        $y = 0;
        $hash = $x | ($y << 16);
        $q[] = [$x, $y, 0];
        $visited[$hash] = true;
        $idx_read = 0;
        while ($idx_read < count($q)) {
            [$x, $y, $step] = $q[$idx_read];
            ++$idx_read;
            if (($x == $max_x - 1) and ($y == $max_y - 1)) {
                return $step;
            }
            foreach ([[1, 0], [0, 1], [-1, 0], [0, -1]] as [$dx, $dy]) {
                $x1 = $x + $dx;
                $y1 = $y + $dy;
                if (($x1 < 0) or ($x1 >= $max_x) or ($y1 < 0) or ($y1 >= $max_y)) {
                    continue;
                }
                $hash1 = $x1 | ($y1 << 16);
                if (isset($has_byte[$hash1]) or isset($visited[$hash1])) {
                    continue;
                }
                $visited[$hash1] = true;
                $q[] = [$x1, $y1, $step + 1];
            }
        }
        return -1;
    }
}
