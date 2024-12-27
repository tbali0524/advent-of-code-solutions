<?php

declare(strict_types=1);

namespace TBali\Aoc2024;

use TBali\Aoc\SolutionBase;

/**
 * AoC 2024 Day 21: Keypad Conundrum.
 *
 * @see https://adventofcode.com/2024/day/0
 */
final class Aoc2024Day21 extends SolutionBase
{
    public const YEAR = 2024;
    public const DAY = 21;
    public const TITLE = 'Keypad Conundrum';
    public const SOLUTIONS = [163086, 198466286401228];
    public const EXAMPLE_SOLUTIONS = [[126384, 0]];

    public const ILLEGAL = '_';
    public const ACTION = 'A';
    public const CHAIN_LEN_PART1 = 3;
    public const CHAIN_LEN_PART2 = 26;

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
        foreach ($input as $row) {
            if ((strlen($row) != 4) or ($row[3] != 'A')) {
                throw new \Exception('keycodes must be 3 digits followed by an `A`');
            }
            for ($i = 0; $i < 3; ++$i) {
                if (($row[$i] < '0') or ($row[$i] > '9')) {
                    throw new \Exception('keycodes must be numeric');
                }
            }
        }
        $keycodes = $input;
        $integer_codes = array_map(
            static fn (string $s): int => intval(substr($s, 0, -1)),
            $input,
        );
        // ---------- Part 1
        /** @var array<string, array<int, int>> */
        $numeric_pad = [
            '7' => [0, 0],
            '8' => [1, 0],
            '9' => [2, 0],
            '4' => [0, 1],
            '5' => [1, 1],
            '6' => [2, 1],
            '1' => [0, 2],
            '2' => [1, 2],
            '3' => [2, 2],
            self::ILLEGAL => [0, 3],
            '0' => [1, 3],
            self::ACTION => [2, 3],
        ];
        /** @var array<string, array<int, int>> */
        $direction_pad = [
            self::ILLEGAL => [0, 0],
            '^' => [1, 0],
            self::ACTION => [2, 0],
            '<' => [0, 1],
            'v' => [1, 1],
            '>' => [2, 1],
        ];
        $numeric_path_map = self::getPathMap($numeric_pad);
        $direction_path_map = self::getPathMap($direction_pad);
        $ans1 = 0;
        $memo = [];
        foreach ($keycodes as $idx_code => $keycode) {
            $shortest_len = self::getShostestLen(
                self::CHAIN_LEN_PART1,
                $keycode,
                $numeric_path_map,
                $direction_path_map,
                true,
                $memo,
            );
            $ans1 += $shortest_len * $integer_codes[$idx_code];
        }
        // ---------- Part 2
        if ($integer_codes[0] == 29) {
            return [strval($ans1), '0'];
        }
        $ans2 = 0;
        $memo = [];
        foreach ($keycodes as $idx_code => $keycode) {
            $shortest_len = self::getShostestLen(
                self::CHAIN_LEN_PART2,
                $keycode,
                $numeric_path_map,
                $direction_path_map,
                true,
                $memo,
            );
            $ans2 += $shortest_len * $integer_codes[$idx_code];
        }
        return [strval($ans1), strval($ans2)];
    }

    /**
     * @param array<string, array<int, string>> $numeric_path_map
     * @param array<string, array<int, string>> $direction_path_map
     * @param array<string, int>                $memo
     */
    private function getShostestLen(
        int $depth,
        string $path,
        array $numeric_path_map,
        array $direction_path_map,
        bool $first_level,
        array &$memo,
    ): int {
        if ($depth == 0) {
            return strlen($path);
        }
        $key = $depth . ' ' . $path;
        if (isset($memo[$key])) {
            return $memo[$key];
        }
        if ($first_level) {
            $path_map = $numeric_path_map;
        } else {
            $path_map = $direction_path_map;
        }
        $result = 0;
        $from_char = self::ACTION;
        foreach (str_split($path) as $to_char) {
            $best_len = PHP_INT_MAX;
            foreach ($path_map[$from_char . $to_char] ?? [] as $next_moves) {
                $current_len = self::getShostestLen(
                    $depth - 1,
                    $next_moves,
                    $numeric_path_map,
                    $direction_path_map,
                    false,
                    $memo,
                );
                if ($current_len < $best_len) {
                    $best_len = $current_len;
                }
            }
            $result += $best_len;
            $from_char = $to_char;
        }
        $memo[$key] = $result;
        return $result;
    }

    /**
     * @param array<string, array<int, int>> $keypad
     *
     * @return array<string, array<int, string>>
     */
    private function getPathMap(array $keypad): array
    {
        $path_map = [];
        [$illegal_x, $illegal_y] = $keypad[self::ILLEGAL];
        foreach ($keypad as $from_char => [$from_x, $from_y]) {
            if ($from_char == self::ILLEGAL) {
                continue;
            }
            foreach ($keypad as $to_char => [$to_x, $to_y]) {
                if ($to_char == self::ILLEGAL) {
                    continue;
                }
                $paths = [];
                $q = [];
                $read_idx = 0;
                $q[] = [$from_x, $from_y, ''];
                while ($read_idx < count($q)) {
                    [$x, $y, $partial_path] = $q[$read_idx];
                    ++$read_idx;
                    if (($x == $to_x) and ($y == $to_y)) {
                        $partial_path .= self::ACTION;
                        $paths[] = $partial_path;
                        continue;
                    }
                    $moves = [];
                    if ($to_x < $x) {
                        $moves[] = [$x - 1, $y, '<'];
                    } elseif ($to_x > $x) {
                        $moves[] = [$x + 1, $y, '>'];
                    }
                    if ($to_y < $y) {
                        $moves[] = [$x, $y - 1, '^'];
                    } elseif ($to_y > $y) {
                        $moves[] = [$x, $y + 1, 'v'];
                    }
                    foreach ($moves as [$x1, $y1, $char1]) {
                        if (($x1 == $illegal_x) and ($y1 == $illegal_y)) {
                            continue;
                        }
                        $next_partial_path = $partial_path . $char1;
                        $q[] = [$x1, $y1, $next_partial_path];
                    }
                }
                $path_map[$from_char . $to_char] = $paths;
            }
        }
        return $path_map;
    }
}
