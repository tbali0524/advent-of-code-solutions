<?php

// phpcs:disable PSR1.Classes.ClassDeclaration.MultipleClasses

declare(strict_types=1);

namespace TBali\Aoc2023;

use TBali\Aoc\SolutionBase;

/**
 * AoC 2023 Day 24: Never Tell Me The Odds.
 *
 * Part 1: How many of these intersections occur within the test area?
 * Part 2: What do you get if you add up the X, Y, and Z coordinates of that initial position?
 *
 * @see https://adventofcode.com/2023/day/24
 *
 * @todo Part 2
 */
final class Aoc2023Day24 extends SolutionBase
{
    public const YEAR = 2023;
    public const DAY = 24;
    public const TITLE = 'Never Tell Me The Odds';
    public const SOLUTIONS = [31208, 0];
    public const EXAMPLE_SOLUTIONS = [[2, 0]]; // part 2: 47

    private const TEST_AREA_MIN_EXAMPLE = 7;
    private const TEST_AREA_MAX_EXAMPLE = 27;
    private const TEST_AREA_MIN = 200000000000000;
    private const TEST_AREA_MAX = 400000000000000;

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
        $hailstones = [];
        foreach ($input as $id => $line) {
            $hailstones[$id] = Hailstone::fromString($line, $id);
        }
        // ---------- Part 1
        $isExample = count($input) < 6;
        if ($isExample) {
            $testAreaMin = self::TEST_AREA_MIN_EXAMPLE;
            $testAreaMax = self::TEST_AREA_MAX_EXAMPLE;
        } else {
            // @codeCoverageIgnoreStart
            $testAreaMin = self::TEST_AREA_MIN;
            $testAreaMax = self::TEST_AREA_MAX;
            // @codeCoverageIgnoreEnd
        }
        $ans1 = 0;
        $memo = [];
        for ($i = 0; $i < count($hailstones); ++$i) {
            for ($j = $i + 1; $j < count($hailstones); ++$j) {
                if ($isExample) {
                    $xy = Hailstone::intersection($hailstones[$i], $hailstones[$j]);
                } else {
                    // @codeCoverageIgnoreStart
                    $xy = Hailstone::bcIntersection($hailstones[$i], $hailstones[$j]);
                    // @codeCoverageIgnoreEnd
                }
                if ($xy == []) {
                    continue;
                }
                if (
                    ($xy[0] < $testAreaMin) or ($xy[0] > $testAreaMax)
                    or ($xy[1] < $testAreaMin) or ($xy[1] > $testAreaMax)
                ) {
                    continue;
                }
                ++$ans1;
                $memo[$xy[0] . ' ' . $xy[1]] = true;
            }
        }
        // ---------- Part 2
        $ans2 = 0;
        return [strval($ans1), strval($ans2)];
    }
}

// --------------------------------------------------------------------
final class Hailstone
{
    public int $id;
    /** @phpstan-var array{int, int, int} */
    public array $p = [0, 0, 0];
    /** @phpstan-var array{int, int, int} */
    public array $v = [0, 0, 0];

    public function __construct(int $id = 0)
    {
        $this->id = $id;
    }

    public static function fromString(string $s, int $id = 0): self
    {
        $s = str_replace('  ', ' ', $s);
        $count = sscanf($s, '%d, %d, %d @ %d, %d, %d', $px, $py, $pz, $vx, $vy, $vz);
        if ($count != 6) {
            throw new \Exception('Invalid input');
        }
        $h = new self($id);
        $h->p = [intval($px), intval($py), intval($pz)];
        $h->v = [intval($vx), intval($vy), intval($vz)];
        return $h;
    }

    /**
     * Line-line intersection.
     *
     * @phpstan-return array{float, float}|array{}
     *
     * @see https://en.wikipedia.org/wiki/Line%E2%80%93line_intersection
     */
    public static function intersection(self $a, self $b): array
    {
        $x1 = $a->p[0];
        $y1 = $a->p[1];
        $x2 = $x1 + $a->v[0];
        $y2 = $y1 + $a->v[1];
        $x3 = $b->p[0];
        $y3 = $b->p[1];
        $x4 = $x3 + $b->v[0];
        $y4 = $y3 + $b->v[1];
        $det = ($x1 - $x2) * ($y3 - $y4) - ($y1 - $y2) * ($x3 - $x4);
        // "if (abs($det) < self::EPSILON)) {..." would be more precise, but coordinated are integers here.
        if ($det == 0) {
            return [];
        }
        $xNom = ($x1 * $y2 - $y1 * $x2) * ($x3 - $x4) - ($x1 - $x2) * ($x3 * $y4 - $y3 * $x4);
        $yNom = ($x1 * $y2 - $y1 * $x2) * ($y3 - $y4) - ($y1 - $y2) * ($x3 * $y4 - $y3 * $x4);
        $x = $xNom / $det;
        $y = $yNom / $det;
        // check if result happened in the past
        if (
            ($a->p[0] <=> $x) != (0 <=> $a->v[0])
            or ($a->p[1] <=> $y) != (0 <=> $a->v[1])
            or ($b->p[0] <=> $x) != (0 <=> $b->v[0])
            or ($b->p[1] <=> $y) != (0 <=> $b->v[1])
        ) {
            return [];
        }
        return [$x, $y];
    }

    /**
     * Line-line intersection using bcmath (because interim calculation values overflow int64).
     *
     * @phpstan-return array{float, float}|array{}
     *
     * @see https://en.wikipedia.org/wiki/Line%E2%80%93line_intersection
     *
     * @codeCoverageIgnore
     */
    public static function bcIntersection(self $a, self $b): array
    {
        $x1 = strval($a->p[0]);
        $y1 = strval($a->p[1]);
        $x2 = bcadd($x1, strval($a->v[0]));
        $y2 = bcadd($y1, strval($a->v[1]));
        $x3 = strval($b->p[0]);
        $y3 = strval($b->p[1]);
        $x4 = bcadd($x3, strval($b->v[0]));
        $y4 = bcadd($y3, strval($b->v[1]));
        $det = bcsub(
            bcmul(bcsub($x1, $x2), bcsub($y3, $y4)),
            bcmul(bcsub($y1, $y2), bcsub($x3, $x4)),
        );
        // "if (abs($det) < self::EPSILON)) {..." would be more precise, but coordinated are integers here.
        if ($det == '0') {
            return [];
        }
        $xNom = bcsub(
            bcmul(bcsub(bcmul($x1, $y2), bcmul($y1, $x2)), bcsub($x3, $x4)),
            bcmul(bcsub($x1, $x2), bcsub(bcmul($x3, $y4), bcmul($y3, $x4))),
        );
        $yNom = bcsub(
            bcmul(bcsub(bcmul($x1, $y2), bcmul($y1, $x2)), bcsub($y3, $y4)),
            bcmul(bcsub($y1, $y2), bcsub(bcmul($x3, $y4), bcmul($y3, $x4))),
        );
        $x = floatval(bcdiv($xNom, $det));
        $y = floatval(bcdiv($yNom, $det));
        // check if result happened in the past
        if (
            ($a->p[0] <=> $x) != (0 <=> $a->v[0])
            or ($a->p[1] <=> $y) != (0 <=> $a->v[1])
            or ($b->p[0] <=> $x) != (0 <=> $b->v[0])
            or ($b->p[1] <=> $y) != (0 <=> $b->v[1])
        ) {
            return [];
        }
        return [$x, $y];
    }
}
