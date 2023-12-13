<?php

// phpcs:disable PSR1.Classes.ClassDeclaration.MultipleClasses

declare(strict_types=1);

namespace TBali\Aoc2023;

use TBali\Aoc\SolutionBase;

/**
 * AoC 2023 Day 13: Point of Incidence.
 *
 * Part 1: What number do you get after summarizing all of your notes?
 * Part 2: What number do you get after summarizing the new reflection line in each pattern in your notes?
 *
 * @see https://adventofcode.com/2023/day/13
 */
final class Aoc2023Day13 extends SolutionBase
{
    public const YEAR = 2023;
    public const DAY = 13;
    public const TITLE = 'Point of Incidence';
    public const SOLUTIONS = [29165, 32192];
    public const EXAMPLE_SOLUTIONS = [[405, 400]];

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
        $borders = array_merge(
            [-1],
            array_keys(array_filter($input, static fn (string $s): bool => $s == '')),
            [count($input)],
        );
        $patterns = [];
        for ($i = 0; $i < count($borders) - 1; ++$i) {
            $patterns[] = new Pattern(array_slice($input, $borders[$i] + 1, $borders[$i + 1] - $borders[$i] - 1));
        }
        // ---------- Part 1
        $ans1 = 0;
        foreach ($patterns as $pattern) {
            $ans1 += $pattern->note();
        }
        // ---------- Part 2
        $ans2 = 0;
        foreach ($patterns as $pattern) {
            $ans2 += $pattern->smudgeNote();
        }
        return [strval($ans1), strval($ans2)];
    }
}

// --------------------------------------------------------------------
final class Pattern
{
    public int $maxX = 0;
    public int $maxY = 0;
    /** @var array<int, int> */
    public array $rows = [];
    /** @var array<int, int> */
    public array $columns = [];

    /**
     * @param array<int, string> $grid The lines of the input, without LF
     */
    public function __construct(array $grid)
    {
        $this->maxY = count($grid);
        $this->maxX = strlen($grid[0] ?? '');
        for ($x = 0; $x < $this->maxX; ++$x) {
            $s = '';
            for ($y = 0; $y < $this->maxY; ++$y) {
                if (($grid[$y][$x] != '.') and ($grid[$y][$x] != '#')) {
                    throw new \Exception('Invalid input');
                }
                $s .= $grid[$y][$x];
            }
            $this->columns[] = $this->encode($s);
        }
        for ($y = 0; $y < $this->maxY; ++$y) {
            $this->rows[] = $this->encode($grid[$y]);
        }
    }

    public function note(): int
    {
        return 100 * $this->singleDirReflections($this->rows) + $this->singleDirReflections($this->columns);
    }

    public function smudgeNote(): int
    {
        $noteR = $this->singleDirReflections($this->rows);
        $noteC = $this->singleDirReflections($this->columns);
        for ($y = 0; $y < $this->maxY; ++$y) {
            for ($x = 0; $x < $this->maxX; ++$x) {
                $this->rows[$y] ^= (1 << $x);
                $this->columns[$x] ^= (1 << $y);
                $smudgeNoteR = $this->singleDirReflections($this->rows, $noteR);
                $smudgeNoteC = $this->singleDirReflections($this->columns, $noteC);
                $smudgeNote = 100 * $smudgeNoteR + $smudgeNoteC;
                $this->rows[$y] ^= (1 << $x);
                $this->columns[$x] ^= (1 << $y);
                if ($smudgeNote != 0) {
                    return $smudgeNote;
                }
            }
        }
        // @codeCoverageIgnoreStart
        return 0;
        // @codeCoverageIgnoreEnd
    }

    private function encode(string $s): int
    {
        return intval(bindec(strtr($s, '.#', '01')));
    }

    /**
     * @param array<int, int> $lines    the encoded row or column array to check for reflection
     * @param                 $original if positive given, then skip this result and search for another reflection
     */
    private function singleDirReflections(array $lines, int $original = -1): int
    {
        for ($pos = 0; $pos < count($lines) - 1; ++$pos) {
            $isOk = true;
            for ($i = 0; $i < count($lines); ++$i) {
                if (($pos - $i < 0) or ($pos + 1 + $i >= count($lines))) {
                    break;
                }
                if ($lines[$pos - $i] != $lines[$pos + 1 + $i]) {
                    $isOk = false;
                    break;
                }
            }
            if ($isOk and ($pos + 1 != $original)) {
                return $pos + 1;
            }
        }
        return 0;
    }
}
