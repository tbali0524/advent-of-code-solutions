<?php

// phpcs:disable PSR1.Classes.ClassDeclaration.MultipleClasses

declare(strict_types=1);

namespace TBali\Aoc2021;

use TBali\Aoc\SolutionBase;

/**
 * AoC 2021 Day 4: Giant Squid.
 *
 * Part 1: What will your final score be if you choose that board?
 * Part 2: Once it wins, what would its final score be?
 *
 * Topics: Bingo simulation
 *
 * @see https://adventofcode.com/2021/day/4
 */
final class Aoc2021Day04 extends SolutionBase
{
    public const YEAR = 2021;
    public const DAY = 4;
    public const TITLE = 'Giant Squid';
    public const SOLUTIONS = [6592, 31755];
    public const EXAMPLE_SOLUTIONS = [[4512, 1924]];

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
        /** @var array<int, int> */
        $draw = array_map(intval(...), explode(',', $input[0]));
        $maxBoard = intdiv(count($input) - 1, Bingo::SIZE + 1);
        if ($maxBoard == 0) {
            throw new \Exception('Invalid input');
        }
        $boards = [];
        for ($id = 0; $id < $maxBoard; ++$id) {
            if (strlen($input[1 + $id * (Bingo::SIZE + 1)]) != 0) {
                throw new \Exception('Invalid input');
            }
            $lines = array_slice($input, 2 + $id * (Bingo::SIZE + 1), Bingo::SIZE);
            $boards[] = new Bingo($id, $lines);
        }
        // ---------- Part 1 + 2
        $ans1 = 0;
        $ans2 = 0;
        $countWon = 0;
        foreach ($draw as $number) {
            foreach ($boards as $board) {
                if ($board->isWon) {
                    continue;
                }
                $board->mark($number);
                if (!$board->isWon) {
                    continue;
                }
                ++$countWon;
                if ($countWon == 1) {
                    $ans1 = $number * $board->sumUnmarked();
                }
                if ($countWon == count($boards)) {
                    $ans2 = $number * $board->sumUnmarked();
                    break 2;
                }
            }
        }
        return [strval($ans1), strval($ans2)];
    }
}

// --------------------------------------------------------------------
final class Bingo
{
    public const SIZE = 5;
    public const MAX_NUMBER = 100;
    private const WIN_MASKS = [
        0b00000_00000_00000_00000_11111,
        0b00000_00000_00000_11111_00000,
        0b00000_00000_11111_00000_00000,
        0b00000_11111_00000_00000_00000,
        0b11111_00000_00000_00000_00000,
        0b00001_00001_00001_00001_00001,
        0b00010_00010_00010_00010_00010,
        0b00100_00100_00100_00100_00100,
        0b01000_01000_01000_01000_01000,
        0b10000_10000_10000_10000_10000,
    ];

    public bool $isWon = false;
    public readonly int $id;
    /** @var array<int, int> number to bit position */
    private array $board = [];
    private int $markedMask = 0;

    /**
     * @param array<int, string> $lines the initial board as a list of 5 strings exactly 14 chars long
     */
    public function __construct(int $id, array $lines)
    {
        $this->id = $id;
        $this->board = array_fill(0, self::MAX_NUMBER, -1);
        if (count($lines) != 5) {
            // @codeCoverageIgnoreStart
            throw new \Exception('Invalid input');
            // @codeCoverageIgnoreEnd
        }
        for ($y = 0; $y < self::SIZE; ++$y) {
            if (strlen($lines[$y]) != 14) {
                throw new \Exception('Invalid input');
            }
            for ($x = 0; $x < self::SIZE; ++$x) {
                $number = intval(trim(substr($lines[$y], 3 * $x, 2)));
                if (($this->board[$number] ?? 0) != -1) {
                    throw new \Exception('Invalid input');
                }
                if (($x > 0) and ($lines[$y][3 * $x - 1] != ' ')) {
                    throw new \Exception('Invalid input');
                }
                $this->board[$number] = $y * self::SIZE + $x;
            }
        }
    }

    public function mark(int $number): void
    {
        if ($this->isWon) {
            // @codeCoverageIgnoreStart
            return;
            // @codeCoverageIgnoreEnd
        }
        if (($this->board[$number] ?? -1) == -1) {
            return;
        }
        $this->markedMask |= (1 << $this->board[$number]);
        foreach (self::WIN_MASKS as $mask) {
            if (($this->markedMask & $mask) == $mask) {
                $this->isWon = true;
                return;
            }
        }
    }

    public function sumUnmarked(): int
    {
        $ans = 0;
        foreach ($this->board as $number => $pos) {
            if ($pos < 0) {
                continue;
            }
            if ((($this->markedMask >> $pos) & 1) == 0) {
                $ans += $number;
            }
        }
        return $this->isWon ? $ans : 0;
    }
}
