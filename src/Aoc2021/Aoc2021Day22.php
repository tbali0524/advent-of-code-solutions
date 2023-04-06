<?php

// phpcs:disable PSR1.Classes.ClassDeclaration.MultipleClasses

declare(strict_types=1);

namespace TBali\Aoc2021;

use TBali\Aoc\SolutionBase;

/**
 * AoC 2021 Day 22: Reactor Reboot.
 *
 * Part 1: Afterward, considering only cubes in the region x=-50..50,y=-50..50,z=-50..50, how many cubes are on?
 * Part 2: Afterward, considering all cubes, how many cubes are on?
 *
 * @see https://adventofcode.com/2021/day/22
 */
final class Aoc2021Day22 extends SolutionBase
{
    public const YEAR = 2021;
    public const DAY = 22;
    public const TITLE = 'Reactor Reboot';
    public const SOLUTIONS = [644257, 1235484513229032];
    public const EXAMPLE_SOLUTIONS = [[39, 39], [590784, 0], [474140, 2758514936282235]];

    private const CLIP_PART1 = 50;

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
        $dividers = [[], [], []];
        $cuboids = [];
        foreach ($input as $line) {
            $c = Cuboid::fromString($line);
            $cuboids[] = $c;
            for ($i = 0; $i < 3; ++$i) {
                $dividers[$i][] = $c->from[$i];
                $dividers[$i][] = $c->to[$i] + 1;
            }
        }
        for ($i = 0; $i < 3; ++$i) {
            $dividers[$i][] = -self::CLIP_PART1;
            $dividers[$i][] = self::CLIP_PART1 + 1;
            sort($dividers[$i]);
            $dividers[$i] = array_values(array_unique($dividers[$i]));
        }
        // ---------- Part 1 + 2
        $ans1 = 0;
        $ans2 = 0;
        $regionOn = str_repeat('0', count($dividers[0]) * count($dividers[1]) * count($dividers[2]));
        foreach ($cuboids as $id => $c) {
            $posFrom = [];
            $posTo = [];
            for ($i = 0; $i < 3; ++$i) {
                $posFrom[$i] = array_search($c->from[$i], $dividers[$i], true);
                if ($posFrom[$i] === false) {
                    throw new \Exception('Invalid input');
                }
                $posTo[$i] = array_search($c->to[$i] + 1, $dividers[$i], true);
                if ($posTo[$i] === false) {
                    throw new \Exception('Invalid input');
                }
            }
            for ($idxX = $posFrom[0]; $idxX < $posTo[0]; ++$idxX) {
                for ($idxY = $posFrom[1]; $idxY < $posTo[1]; ++$idxY) {
                    for ($idxZ = $posFrom[2]; $idxZ < $posTo[2]; ++$idxZ) {
                        $pos = $idxX * count($dividers[1]) * count($dividers[2]) + $idxY * count($dividers[2]) + $idxZ;
                        $regionOn[$pos] = $c->isOn ? '1' : '0';
                    }
                }
            }
        }
        for ($idxX = 0; $idxX < count($dividers[0]) - 1; ++$idxX) {
            for ($idxY = 0; $idxY < count($dividers[1]) - 1; ++$idxY) {
                for ($idxZ = 0; $idxZ < count($dividers[2]) - 1; ++$idxZ) {
                    $pos = $idxX * count($dividers[1]) * count($dividers[2]) + $idxY * count($dividers[2]) + $idxZ;
                    if ($regionOn[$pos] != '1') {
                        continue;
                    }
                    $size = ($dividers[0][$idxX + 1] - $dividers[0][$idxX])
                        * ($dividers[1][$idxY + 1] - $dividers[1][$idxY])
                        * ($dividers[2][$idxZ + 1] - $dividers[2][$idxZ]);
                    $ans2 += $size;
                    if (
                        ($dividers[0][$idxX] < -self::CLIP_PART1) or ($dividers[0][$idxX + 1] > self::CLIP_PART1 + 1)
                        or ($dividers[1][$idxY] < -self::CLIP_PART1) or ($dividers[1][$idxY + 1] > self::CLIP_PART1 + 1)
                        or ($dividers[2][$idxZ] < -self::CLIP_PART1) or ($dividers[2][$idxZ + 1] > self::CLIP_PART1 + 1)
                    ) {
                        continue;
                    }
                    $ans1 += $size;
                }
            }
        }
        return [strval($ans1), strval($ans2)];
    }
}

// --------------------------------------------------------------------
final class Cuboid
{
    /** @var array<int, int> */
    public array $from = [0, 0, 0];
    /** @var array<int, int> */
    public array $to = [0, 0, 0];
    public bool $isOn = false;

    public static function fromString(string $inputLine): self
    {
        $c = new self();
        $s = '';
        if (str_starts_with($inputLine, 'on ')) {
            $c->isOn = true;
            $s = substr($inputLine, 3);
        } elseif (str_starts_with($inputLine, 'off ')) {
            $c->isOn = false;
            $s = substr($inputLine, 4);
        }
        $count = sscanf(
            $s,
            'x=%d..%d,y=%d..%d,z=%d..%d',
            $c->from[0],
            $c->to[0],
            $c->from[1],
            $c->to[1],
            $c->from[2],
            $c->to[2],
        );
        if (($count != 6) or ($c->from[0] > $c->to[0]) or ($c->from[1] > $c->to[1]) or ($c->from[2] > $c->to[2])) {
            throw new \Exception('Invalid input');
        }
        return $c;
    }
}
