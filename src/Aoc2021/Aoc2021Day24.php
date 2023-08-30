<?php

declare(strict_types=1);

namespace TBali\Aoc2021;

use TBali\Aoc\SolutionBase;

/**
 * AoC 2021 Day 24: Arithmetic Logic Unit.
 *
 * Part 1: What is the largest model number accepted by MONAD?
 * Part 2: What is the smallest model number accepted by MONAD?
 *
 * Topics: assembly reverse engineering
 *
 * @see https://adventofcode.com/2021/day/24
 *
 * @codeCoverageIgnore
 */
final class Aoc2021Day24 extends SolutionBase
{
    public const YEAR = 2021;
    public const DAY = 24;
    public const TITLE = 'Arithmetic Logic Unit';
    public const SOLUTIONS = [39999698799429, 18116121134117];

    private const SHOW_EMULATION = false;
    private const MAX_DIGITS = 14;

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
        $p = [];
        $q = [];
        $r = [];
        if (count($input) != 18 * self::MAX_DIGITS) {
            throw new \Exception('Invalid input');
        }
        for ($i = 0; $i < self::MAX_DIGITS; ++$i) {
            $p[] = intval(substr($input[$i * 18 + 4], 6));
            $q[] = intval(substr($input[$i * 18 + 5], 6));
            $r[] = intval(substr($input[$i * 18 + 15], 6));
        }
        // @phpstan-ignore-next-line
        if (self::SHOW_EMULATION) {
            // @codeCoverageIgnoreStart
            // -- 01234567890123
            $v = '39999698799429';
            $w = array_map(intval(...), str_split($v));
            echo 'd: | '
                . implode('| ', array_map(static fn ($x) => str_pad(strval($x), 3, ' ', STR_PAD_LEFT), range(0, 13)))
                . PHP_EOL
                . 'p: | ' . implode('| ', array_map(static fn ($x) => str_pad(strval($x), 3, ' ', STR_PAD_LEFT), $p))
                . PHP_EOL
                . 'q: | ' . implode('| ', array_map(static fn ($x) => str_pad(strval($x), 3, ' ', STR_PAD_LEFT), $q))
                . PHP_EOL
                . 'r: | ' . implode('| ', array_map(static fn ($x) => str_pad(strval($x), 3, ' ', STR_PAD_LEFT), $r))
                . PHP_EOL
                . 'w: | ' . implode('| ', array_map(static fn ($x) => str_pad(strval($x), 3, ' ', STR_PAD_LEFT), $w))
                . PHP_EOL . PHP_EOL;
            echo '| ' . str_pad('d', 3, ' ', STR_PAD_LEFT)
                . ' | ' . str_pad('p', 3, ' ', STR_PAD_LEFT)
                . ' | ' . str_pad('q', 3, ' ', STR_PAD_LEFT)
                . ' | ' . str_pad('r', 3, ' ', STR_PAD_LEFT)
                . ' | ' . str_pad('w', 3, ' ', STR_PAD_LEFT)
                . ' | ' . str_pad('x1', 3, ' ', STR_PAD_LEFT)
                . ' | ' . str_pad('x', 3, ' ', STR_PAD_LEFT)
                . ' | ' . str_pad('y', 3, ' ', STR_PAD_LEFT)
                . ' | ' . str_pad('z1', 10, ' ', STR_PAD_LEFT)
                . ' | ' . str_pad('z2', 10, ' ', STR_PAD_LEFT)
                . ' | ' . str_pad('z', 10, ' ', STR_PAD_LEFT), PHP_EOL;
            echo '+-' . str_pad('-', 3, '-', STR_PAD_LEFT)
                . '-+-' . str_pad('-', 3, '-', STR_PAD_LEFT)
                . '-+-' . str_pad('-', 3, '-', STR_PAD_LEFT)
                . '-+-' . str_pad('-', 3, '-', STR_PAD_LEFT)
                . '-+-' . str_pad('-', 3, '-', STR_PAD_LEFT)
                . '-+-' . str_pad('-', 3, '-', STR_PAD_LEFT)
                . '-+-' . str_pad('-', 3, '-', STR_PAD_LEFT)
                . '-+-' . str_pad('-', 3, '-', STR_PAD_LEFT)
                . '-+-' . str_pad('-', 10, '-', STR_PAD_LEFT)
                . '-+-' . str_pad('-', 10, '-', STR_PAD_LEFT)
                . '-+-' . str_pad('-', 10, '-', STR_PAD_LEFT), PHP_EOL;
            $x = 0;
            $y = 0;
            $z = 0;
            for ($i = 0; $i < self::MAX_DIGITS; ++$i) {
                $x1 = $z % 26 + $q[$i];
                $x = $x1 != $w[$i] ? 1 : 0;
                $y = 25 * $x + 1;
                $z1 = intdiv($z, $p[$i]) * $y;
                $z2 = ($w[$i] + $r[$i]) * $x;
                $z = $z1 + $z2;
                echo '| ' . str_pad(strval($i), 3, ' ', STR_PAD_LEFT)
                    . ' | ' . str_pad(strval($p[$i]), 3, ' ', STR_PAD_LEFT)
                    . ' | ' . str_pad(strval($q[$i]), 3, ' ', STR_PAD_LEFT)
                    . ' | ' . str_pad(strval($r[$i]), 3, ' ', STR_PAD_LEFT)
                    . ' | ' . str_pad(strval($w[$i]), 3, ' ', STR_PAD_LEFT)
                    . ' | ' . str_pad(strval($x1), 3, ' ', STR_PAD_LEFT)
                    . ' | ' . str_pad(strval($x), 3, ' ', STR_PAD_LEFT)
                    . ' | ' . str_pad(strval($y), 3, ' ', STR_PAD_LEFT)
                    . ' | ' . str_pad(strval($z1), 10, ' ', STR_PAD_LEFT)
                    . ' | ' . str_pad(strval($z2), 10, ' ', STR_PAD_LEFT)
                    . ' | ' . str_pad(strval($z), 10, ' ', STR_PAD_LEFT), PHP_EOL;
            }
            echo($z == 0 ? 'OK' : 'INVALID'), PHP_EOL;
            exit;
            // @codeCoverageIgnoreEnd
        }
        // ---------- Part 1
        $ans1 = 0;
        $try = array_fill(0, intdiv(self::MAX_DIGITS, 2), 9);
        while (true) {
            $idx = 0;
            $w = array_fill(0, self::MAX_DIGITS, 9);
            $x = 0;
            $y = 0;
            $z = 0;
            $isOk = true;
            for ($i = 0; $i < self::MAX_DIGITS; ++$i) {
                $x1 = $z % 26 + $q[$i];
                if (($x1 > 0) and ($x1 <= 9)) {
                    $w[$i] = $x1;
                } else {
                    if ($idx >= count($try)) {
                        $isOk = false;
                        break;
                    }
                    $w[$i] = $try[$idx];
                    ++$idx;
                }
                $x = $x1 != $w[$i] ? 1 : 0;
                $y = 25 * $x + 1;
                $z1 = intdiv($z, $p[$i]) * $y;
                $z2 = ($w[$i] + $r[$i]) * $x;
                $z = $z1 + $z2;
            }
            if ($isOk and ($z == 0)) {
                $ans1 = intval(implode('', $w));
                break;
            }
            $idx = count($try) - 1;
            while (($idx > 0) and ($try[$idx] == 1)) {
                --$idx;
            }
            --$try[$idx];
            ++$idx;
            while ($idx < count($try)) {
                $try[$idx] = 9;
                ++$idx;
            }
        }
        // ---------- Part 2
        $ans2 = 0;
        $try = array_fill(0, intdiv(self::MAX_DIGITS, 2), 1);
        while (true) {
            $idx = 0;
            $w = array_fill(0, self::MAX_DIGITS, 1);
            $x = 0;
            $y = 0;
            $z = 0;
            $isOk = true;
            for ($i = 0; $i < self::MAX_DIGITS; ++$i) {
                $x1 = $z % 26 + $q[$i];
                if (($x1 > 0) and ($x1 <= 9)) {
                    $w[$i] = $x1;
                } else {
                    if ($idx >= count($try)) {
                        $isOk = false;
                        break;
                    }
                    $w[$i] = $try[$idx];
                    ++$idx;
                }
                $x = $x1 != $w[$i] ? 1 : 0;
                $y = 25 * $x + 1;
                $z1 = intdiv($z, $p[$i]) * $y;
                $z2 = ($w[$i] + $r[$i]) * $x;
                $z = $z1 + $z2;
            }
            if ($isOk and ($z == 0)) {
                $ans2 = intval(implode('', $w));
                break;
            }
            $idx = count($try) - 1;
            while (($idx > 0) and ($try[$idx] == 9)) {
                --$idx;
            }
            ++$try[$idx];
            ++$idx;
            while ($idx < count($try)) {
                $try[$idx] = 1;
                ++$idx;
            }
        }
        return [strval($ans1), strval($ans2)];
    }
}
