<?php

declare(strict_types=1);

namespace TBali\Aoc2020;

use TBali\Aoc\SolutionBase;

/**
 * AoC 2020 Day 17: Conway Cubes.
 *
 * Part 1: How many cubes are left in the active state after the sixth cycle?
 * Part 2: Simulate six cycles in a 4-dimensional space. How many cubes are left in the active state
 *         after the sixth cycle?
 *
 * Topics: Conway's Game of Life, simulation
 *
 * @see https://adventofcode.com/2020/day/17
 *
 * @codeCoverageIgnore
 */
final class Aoc2020Day17 extends SolutionBase
{
    public const YEAR = 2020;
    public const DAY = 17;
    public const TITLE = 'Conway Cubes';
    public const SOLUTIONS = [388, 2280];
    public const EXAMPLE_SOLUTIONS = [[112, 848]];

    private const MAX_STEPS = 6;

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
        // ---------- Process input
        $startCubes = [];
        foreach ($input as $y => $line) {
            foreach (str_split($line) as $x => $c) {
                if ($c == '#') {
                    $startCubes[] = [$x, $y, 0, 0];
                }
            }
        }
        // ---------- Part 1
        $nbDeltas = $this->getNbDeltas();
        $ans1 = $this->simulate($startCubes, $nbDeltas);
        // ---------- Part 2
        $nbDeltas = array_merge($nbDeltas, $this->getNbDeltas(-1), $this->getNbDeltas(1));
        $ans2 = $this->simulate($startCubes, $nbDeltas);
        return [strval($ans1), strval($ans2)];
    }

    /**
     * @return array<array<int, int>>
     *
     * @phpstan-return array<array{int, int, int, int}>
     */
    private function getNbDeltas(int $dim4Value = 0): array
    {
        $nbDeltas = [];
        for ($dz = -1; $dz <= 1; ++$dz) {
            for ($dy = -1; $dy <= 1; ++$dy) {
                for ($dx = -1; $dx <= 1; ++$dx) {
                    if (($dx == 0) and ($dy == 0) and ($dz == 0) and ($dim4Value == 0)) {
                        continue;
                    }
                    $nbDeltas[] = [$dx, $dy, $dz, $dim4Value];
                }
            }
        }
        return $nbDeltas;
    }

    /**
     * @param array<array<int, int>> $startCubes
     * @param array<array<int, int>> $nbDeltas
     *
     * @phpstan-param array<array{int, int, int, int}> $startCubes
     * @phpstan-param array<array{int, int, int, int}> $nbDeltas
     */
    private function simulate(array $startCubes, array $nbDeltas): int
    {
        $prevCubes = $startCubes;
        for ($step = 0; $step < self::MAX_STEPS; ++$step) {
            $toCheckList = [];
            $toCheckMap = [];
            $prevGrid = [];
            foreach ($prevCubes as [$x, $y, $z, $w]) {
                if (!isset($toCheckMap[$w][$z][$y][$x])) {
                    $toCheckList[] = [$x, $y, $z, $w];
                    $toCheckMap[$w][$z][$y][$x] = true;
                }
                $prevGrid[$w][$z][$y][$x] = true;
                foreach ($nbDeltas as [$dx, $dy, $dz, $dw]) {
                    [$x1, $y1, $z1, $w1] = [$x + $dx, $y + $dy, $z + $dz, $w + $dw];
                    if (isset($toCheckMap[$w1][$z1][$y1][$x1])) {
                        continue;
                    }
                    $toCheckList[] = [$x1, $y1, $z1, $w1];
                    $toCheckMap[$w1][$z1][$y1][$x1] = true;
                }
            }
            $nextCubes = [];
            foreach ($toCheckList as [$x, $y, $z, $w]) {
                $count = 0;
                foreach ($nbDeltas as [$dx, $dy, $dz, $dw]) {
                    [$x1, $y1, $z1, $w1] = [$x + $dx, $y + $dy, $z + $dz, $w + $dw];
                    if (isset($prevGrid[$w1][$z1][$y1][$x1])) {
                        ++$count;
                    }
                }
                if (
                    (isset($prevGrid[$w][$z][$y][$x]) and (($count == 2) or ($count == 3)))
                    or (!isset($prevGrid[$w][$z][$y][$x]) and ($count == 3))
                ) {
                    $nextCubes[] = [$x, $y, $z, $w];
                }
            }
            $prevCubes = $nextCubes;
        }
        return count($prevCubes);
    }
}
