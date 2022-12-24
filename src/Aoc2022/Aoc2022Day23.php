<?php

declare(strict_types=1);

namespace TBali\Aoc2022;

use TBali\Aoc\SolutionBase;

/**
 * AoC 2022 Day 23: Unstable Diffusion.
 *
 * Part 1: Simulate the Elves' process and find the smallest rectangle that contains the Elves after 10 rounds.
 *         How many empty ground tiles does that rectangle contain?
 * Part 2: Figure out where the Elves need to go. What is the number of the first round where no Elf moves?
 *
 * Topics: walking simulation
 *
 * @see https://adventofcode.com/2022/day/23
 */
final class Aoc2022Day23 extends SolutionBase
{
    public const YEAR = 2022;
    public const DAY = 23;
    public const TITLE = 'Unstable Diffusion';
    public const SOLUTIONS = [3766, 954];
    public const EXAMPLE_SOLUTIONS = [[110, 20]];

    private const MAX_TURNS_PART1 = 10;
    private const DELTA_CONSIDERING = [
        0 => [[0, -1], [-1, -1], [1, -1]],
        1 => [[0, 1], [-1, 1], [1, 1]],
        2 => [[-1, 0], [-1, -1], [-1, 1]],
        3 => [[1, 0], [1, -1], [1, 1]],
    ];

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
        $startElves = $this->parseInput($input);
        // ---------- Part 1 + 2{
        $ans1 = -1;
        $ans2 = -1;
        $elves = $startElves;
        $turn = 0;
        while (true) {
            $isTileElf = [];
            foreach ($elves as $elf) {
                $isTileElf[$elf[0] . ' ' . $elf[1]] = true;
            }
            $firstDir = $turn % 4;
            $proposedElves = [];
            $countTileProposed = [];
            foreach ($elves as $idxElf => $elf) {
                $x = $elf[0];
                $y = $elf[1];
                $okDir = -1;
                $countDirOk = 0;
                for ($i = 0; $i < 4; ++$i) {
                    $dir = ($firstDir + $i) % 4;
                    $isDirOk = true;
                    foreach (self::DELTA_CONSIDERING[$dir] as [$dx, $dy]) {
                        $x1 = $x + $dx;
                        $y1 = $y + $dy;
                        if (isset($isTileElf[$x1 . ' ' . $y1])) {
                            $isDirOk = false;
                            break;
                        }
                    }
                    if ($isDirOk) {
                        ++$countDirOk;
                        if ($okDir < 0) {
                            $okDir = $dir;
                        }
                    }
                }
                if (($countDirOk == 4) or ($countDirOk == 0)) {
                    $proposedElf = $elf;
                } else {
                    [$dx, $dy] = self::DELTA_CONSIDERING[$okDir][0];
                    $proposedElf = [$x + $dx, $y + $dy];
                }
                $proposedElves[$idxElf] = $proposedElf;
                $hash = $proposedElf[0] . ' ' . $proposedElf[1];
                $countTileProposed[$hash] = ($countTileProposed[$hash] ?? 0) + 1;
            }
            $newElves = [];
            foreach ($proposedElves as $idxElf => $elf) {
                if (($countTileProposed[$elf[0] . ' ' . $elf[1]] ?? 0) > 1) {
                    $newElves[$idxElf] = $elves[$idxElf];
                } else {
                    $newElves[$idxElf] = $elf;
                }
            }
            ++$turn;
            if (($ans1 < 0) and ($turn == self::MAX_TURNS_PART1)) {
                $xs = array_map(fn (array $e): int => $e[0], $newElves);
                $ys = array_map(fn (array $e): int => $e[1], $newElves);
                $ans1 = (intval(max($xs)) - intval(min($xs)) + 1) * (intval(max($ys)) - intval(min($ys)) + 1)
                    - count($elves);
            }
            if (($ans2 < 0) and ($elves === $newElves)) {
                $ans2 = $turn;
            }
            if (($ans1 >= 0) and ($ans2 >= 0)) {
                break;
            }
            $elves = $newElves;
        }
        return [strval($ans1), strval($ans2)];
    }

    /**
     * @param array<int, string> $input The lines of the input, without LF
     *
     * @return array<int, array<int, int>>
     */
    private function parseInput(array $input): array
    {
        $elves = [];
        foreach ($input as $y => $line) {
            for ($x = 0; $x < strlen($line); ++$x) {
                if ($line[$x] == '#') {
                    $elves[] = [$x, $y];
                }
            }
        }
        if (count($elves) == 0) {
            throw new \Exception('Invalid input');
        }
        return $elves;
    }
}
