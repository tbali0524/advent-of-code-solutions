<?php

/*
https://adventofcode.com/2015/day/14
Part 1: After exactly 2503 seconds, what distance has the winning reindeer traveled?
Part 2: After exactly 2503 seconds, how many points does the winning reindeer have?
*/

// phpcs:disable PSR1.Classes.ClassDeclaration

declare(strict_types=1);

namespace TBali\Aoc2015;

use TBali\Aoc\SolutionBase;

final class Aoc2015Day14 extends SolutionBase
{
    public const YEAR = 2015;
    public const DAY = 14;
    public const TITLE = 'Reindeer Olympic';
    public const SOLUTIONS = [2696, 1084];
    public const EXAMPLE_SOLUTIONS = [[1120, 689], [0, 0]];

    private const STEPS = 2503;
    private const EXAMPLE_STEPS = 1000;

    /**
     * @param string[] $input
     *
     * @return array{string, string}
     */
    public function solve(array $input): array
    {
        // detect puzzle example as input
        $maxSteps = (count($input) == 2 ? self::EXAMPLE_STEPS : self::STEPS);
        // ---------- Part 1
        $ans1 = max(array_map(fn ($line) => (new Reindeer($line))->getDistanceAt($maxSteps), $input));
        // ---------- Part 2
        $reindeers = [];
        foreach ($input as $line) {
            $reindeers[] = new Reindeer($line);
        }
        for ($second = 1; $second <= $maxSteps; ++$second) {
            $max = max(array_map(fn ($x) => $x->getDistanceAt($second), $reindeers));
            array_walk(
                $reindeers,
                function ($x) use ($second, $max): void {
                    if ($x->getDistanceAt($second) == $max) {
                        ++$x->points;
                    }
                }
            );
        }
        $ans2 = max(array_map(fn ($x) => $x->points, $reindeers));
        return [strval($ans1), strval($ans2)];
    }
}

// --------------------------------------------------------------------
final class Reindeer
{
    public readonly string $name;
    public readonly int $speed;
    public readonly int $flyTime;
    public readonly int $restTime;
    public int $points;

    public function __construct(string $line)
    {
        $a = explode(' ', $line);
        if (
            (count($a) != 15)
            or !is_numeric($a[3])
            or !is_numeric($a[6])
            or !is_numeric($a[13])
            or ($a[1] != 'can')
            or ($a[2] != 'fly')
            or ($a[4] != 'km/s')
            or ($a[5] != 'for')
            or ($a[14] != 'seconds.')
            or !str_contains($line, ' seconds, but then must rest for ')
        ) {
            throw new \Exception('Invalid input');
        }
        $this->name = $a[0];
        $this->speed = intval($a[3]);
        $this->flyTime = intval($a[6]);
        $this->restTime = intval($a[13]);
        $this->points = 0;
    }

    public function getDistanceAt(int $seconds): int
    {
        $cycles = intdiv($seconds, $this->flyTime + $this->restTime);
        $remaining = min($this->flyTime, $seconds % ($this->flyTime + $this->restTime));
        return $this->speed * ($cycles * $this->flyTime + $remaining);
    }
}
