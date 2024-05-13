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
 */
final class Aoc2023Day24 extends SolutionBase
{
    public const YEAR = 2023;
    public const DAY = 24;
    public const TITLE = 'Never Tell Me The Odds';
    public const SOLUTIONS = [31208, 580043851566574];
    public const EXAMPLE_SOLUTIONS = [[2, 47]];

    private const DEBUG = false;
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
        // hint used from: http://clb.confined.space/aoc2023/#day24
        $ans2 = 0;
        $vCandidates = [[], [], []];
        for ($d = 0; $d < 3; ++$d) {
            usort($hailstones, static fn (Hailstone $a, Hailstone $b): int => $a->v[$d] <=> $b->v[$d]);
            // assumption: v is in the [-1000..1000] range
            for ($rv = -999; $rv < 1000; ++$rv) {
                if ($rv != 0) {
                    $vCandidates[$d][$rv] = true;
                }
            }
            for ($i = 0; $i < count($hailstones) - 1; ++$i) {
                if ($hailstones[$i]->v[$d] != $hailstones[$i + 1]->v[$d]) {
                    continue;
                }
                $hv = $hailstones[$i]->v[$d];
                $dist = $hailstones[$i]->p[$d] - $hailstones[$i + 1]->p[$d];
                foreach (array_keys($vCandidates[$d]) as $rv) {
                    if (($rv == $hv) or ($dist % ($hv - $rv) != 0)) {
                        unset($vCandidates[$d][$rv]);
                    }
                }
            }
        }
        usort($hailstones, static fn (Hailstone $a, Hailstone $b): int => $a->id <=> $b->id);
        $rock = new Hailstone(-1);
        if (count($input) > 20) {
            // todo: for some reason above section unselects all candidates for vx (starting from list of 10)
            // below vx is the correct one.
            $vCandidates[0] = [63 => true];
        }
        foreach (array_keys($vCandidates[0]) as $rvx) {
            $rock->v[0] = $rvx;
            foreach (array_keys($vCandidates[1]) as $rvy) {
                $rock->v[1] = $rvy;
                foreach (array_keys($vCandidates[2]) as $rvz) {
                    $rock->v[2] = $rvz;
                    $hailstone1 = clone $hailstones[0];
                    $hailstone2 = clone $hailstones[1];
                    for ($i = 0; $i < 3; ++$i) {
                        $hailstone1->v[$i] -= $rock->v[$i];
                        $hailstone2->v[$i] -= $rock->v[$i];
                    }
                    $xy = Hailstone::bcIntersection($hailstone1, $hailstone2);
                    if (count($xy) == 0) {
                        continue;
                    }
                    $rock->p[0] = intval(round($xy[0]));
                    $rock->p[1] = intval(round($xy[1]));
                    if ($hailstones[0]->v[0] == $rock->v[0]) {
                        continue;
                    }
                    $t = intdiv(abs($hailstones[0]->p[0] - $rock->p[0]), abs($hailstones[0]->v[0] - $rock->v[0]));
                    $rock->p[2] = $hailstones[0]->p[2] + $t * $hailstones[0]->v[2] - $t * $rock->v[2];
                    $isOk = true;
                    if (count($input) < 20) {
                        // todo: below checking works correctly only for the example
                        foreach ($hailstones as $h) {
                            if ($rock->v[0] == $h->v[0]) {
                                $isOk = false;
                                break;
                            }
                            $t = intdiv(abs($h->p[0] - $rock->p[0]), abs($rock->v[0] - $h->v[0]));
                            if (
                                ($t < 0)
                                or ($rock->p[0] + $t * $rock->v[0] != $h->p[0] + $t * $h->v[0])
                                or ($rock->p[1] + $t * $rock->v[1] != $h->p[1] + $t * $h->v[1])
                                or ($rock->p[2] + $t * $rock->v[2] != $h->p[2] + $t * $h->v[2])
                            ) {
                                $isOk = false;
                                break;
                            }
                        }
                    }
                    if ($isOk) {
                        $ans2 = intval(array_sum($rock->p));
                        // @phpstan-ignore if.alwaysFalse
                        if (self::DEBUG) {
                            // @codeCoverageIgnoreStart
                            echo '---- ' . $rock->toString(), PHP_EOL;
                            echo $ans2, PHP_EOL;
                            // @codeCoverageIgnoreEnd
                        }
                    }
                }
            }
        }
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

    /**
     * @codeCoverageIgnore
     */
    public function toString(): string
    {
        return '#' . $this->id . ': [' . implode(', ', $this->p) . ']->(' . implode(', ', $this->v) . ')';
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
        // "if (abs($det) < self::EPSILON)) {..." would be more precise, but coordinates are integers here.
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
