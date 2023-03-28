<?php

// phpcs:disable PSR1.Classes.ClassDeclaration.MultipleClasses

declare(strict_types=1);

namespace TBali\Aoc2019;

use TBali\Aoc\SolutionBase;

/**
 * AoC 2019 Day 12: The N-Body Problem.
 *
 * Part 1: What is the total energy in the system after simulating the moons given in your scan for 1000 steps?
 * Part 2: How many steps does it take to reach the first state that exactly matches a previous state?
 *
 * Topics: simulation
 *
 * @see https://adventofcode.com/2019/day/12
 */
final class Aoc2019Day12 extends SolutionBase
{
    public const YEAR = 2019;
    public const DAY = 12;
    public const TITLE = 'The N-Body Problem';
    public const SOLUTIONS = [7988, 337721412394184];
    public const EXAMPLE_SOLUTIONS = [[179, 2772], [1940, 4686774924]];

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
        /** @var array<int, Moon> */
        $moons = array_map(
            fn (int $id, string $line): Moon => Moon::fromString($id, $line),
            range(0, count($input) - 1),
            $input
        );
        // ---------- Part 1 + 2
        $ans1 = 0;
        $cycleX = 0;
        $cycleY = 0;
        $cycleZ = 0;
        $maxStepPart1 = match ($input[0]) {
            '<x=-1, y=0, z=2>' => 10,
            '<x=-8, y=-10, z=0>' => 100,
            default => 1000,
        };
        $startHashX = implode(';', array_map(fn (Moon $m) => strval($m->x) . ',' . strval($m->vx), $moons));
        $startHashY = implode(';', array_map(fn (Moon $m) => strval($m->y) . ',' . strval($m->vy), $moons));
        $startHashZ = implode(';', array_map(fn (Moon $m) => strval($m->z) . ',' . strval($m->vz), $moons));
        $step = 0;
        while (true) {
            foreach ($moons as $moon) {
                foreach ($moons as $otherMoon) {
                    $moon->gravity($otherMoon);
                }
            }
            foreach ($moons as $moon) {
                $moon->move();
            }
            ++$step;
            $hashX = implode(';', array_map(fn (Moon $m) => strval($m->x) . ',' . strval($m->vx), $moons));
            $hashY = implode(';', array_map(fn (Moon $m) => strval($m->y) . ',' . strval($m->vy), $moons));
            $hashZ = implode(';', array_map(fn (Moon $m) => strval($m->z) . ',' . strval($m->vz), $moons));
            if (($cycleX == 0) and ($hashX == $startHashX)) {
                $cycleX = $step;
            }
            if (($cycleY == 0) and ($hashY == $startHashY)) {
                $cycleY = $step;
            }
            if (($cycleZ == 0) and ($hashZ == $startHashZ)) {
                $cycleZ = $step;
            }
            if (($ans1 == 0) and ($step == $maxStepPart1)) {
                $ans1 = array_sum(array_map(fn (Moon $m): int => $m->energy(), $moons));
            }
            if (($cycleX != 0) and ($cycleY != 0) and ($cycleZ != 0) and ($ans1 != 0)) {
                break;
            }
        }
        $gcdXY = self::gcd($cycleX, $cycleY);
        $lcmXY = intdiv($cycleX, $gcdXY) * $cycleY;
        $gcd = self::gcd($lcmXY, $cycleZ);
        $ans2 = intdiv($lcmXY, $gcd) * $cycleZ;
        return [strval($ans1), strval($ans2)];
    }

    private static function gcd(int $a, int $b): int
    {
        while ($b != 0) {
            $t = $b;
            $b = $a % $b;
            $a = $t;
        }
        return $a;
    }
}

// --------------------------------------------------------------------
final class Moon
{
    public int $vx = 0;
    public int $vy = 0;
    public int $vz = 0;

    public function __construct(
        public int $id,
        public int $x,
        public int $y,
        public int $z,
    ) {
    }

    /**
     * @codeCoverageIgnore
     */
    public function toString(): string
    {
        return '#' . $this->id
            . ': pos=<' . $this->x
            . ', ' . $this->y
            . ', ' . $this->z
            . '>, vel=<' . $this->vx
            . ',' . $this->vy
            . ',' . $this->vz
            . '>' . PHP_EOL;
    }

    public function gravity(Moon $moon): void
    {
        $this->vx += ($moon->x <=> $this->x);
        $this->vy += ($moon->y <=> $this->y);
        $this->vz += ($moon->z <=> $this->z);
    }

    public function move(): void
    {
        $this->x += $this->vx;
        $this->y += $this->vy;
        $this->z += $this->vz;
    }

    public function energy(): int
    {
        return (abs($this->x) + abs($this->y) + abs($this->z)) * (abs($this->vx) + abs($this->vy) + abs($this->vz));
    }

    public static function fromString(int $id, string $s): self
    {
        $count = sscanf($s, '<x=%d, y= %d, z=%d>', $x, $y, $z);
        if ($count != 3) {
            throw new \Exception('Invalid input');
        }
        return new self($id, intval($x), intval($y), intval($z));
    }
}
