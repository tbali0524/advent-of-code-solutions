<?php

// phpcs:disable PSR1.Classes.ClassDeclaration.MultipleClasses

declare(strict_types=1);

namespace TBali\Aoc2024;

use TBali\Aoc\SolutionBase;

/**
 * AoC 2024 Day 13: CODE SKELETON FOR SOLUTION.
 *
 * @see https://adventofcode.com/2024/day/13
 */
final class Aoc2024Day13 extends SolutionBase
{
    public const YEAR = 2024;
    public const DAY = 13;
    public const TITLE = 'Claw Contraption';
    public const SOLUTIONS = [26599, 106228669504887];
    public const EXAMPLE_SOLUTIONS = [[480, 0]];

    public const P_BASE_PART2 = 10000000000000;

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
        $machines = [];
        $i = 0;
        while ($i + 2 < count($input)) {
            $machines[] = new ClawMachine($input, $i);
            if (($i + 3 < count($input)) and ($input[$i + 3] != '')) {
                throw new \Exception('claw machine definitions must be separated by an empty line');
            }
            $i += 4;
        }
        // ---------- Part 1 + 2
        $ans1 = 0;
        $ans2 = 0;
        foreach ($machines as $machine) {
            $ans1 += $machine->cost();
            $ans2 += $machine->cost(self::P_BASE_PART2);
        }
        return [strval($ans1), strval($ans2)];
    }
}

// --------------------------------------------------------------------
final readonly class ClawMachine
{
    public const COST_A = 3;
    public const COST_B = 1;
    public int $ax;
    public int $ay;
    public int $bx;
    public int $by;
    public int $px;
    public int $py;

    /**
     * @param array<int, string> $input The lines of the input, without LF
     */
    public function __construct(array $input, int $from = 0)
    {
        // ---------- Parse input
        if ($from + 2 >= count($input)) {
            // @codeCoverageIgnoreStart
            throw new \Exception('missing line in claw machine definition');
            // @codeCoverageIgnoreEnd
        }
        if (
            !str_starts_with($input[$from], 'Button A: X+')
            || !str_starts_with($input[$from + 1], 'Button B: X+')
            || !str_starts_with($input[$from + 2], 'Prize: X=')
        ) {
            throw new \Exception('invalid claw machine definition');
        }
        $axy = array_map(intval(...), explode(', Y+', substr($input[$from], 12)));
        $bxy = array_map(intval(...), explode(', Y+', substr($input[$from + 1], 12)));
        $pxy = array_map(intval(...), explode(', Y=', substr($input[$from + 2], 9)));
        if ((count($axy) != 2) or (count($bxy) != 2) or (count($pxy) != 2)) {
            throw new \Exception('invalid claw machine definition');
        }
        $this->ax = $axy[0];
        $this->ay = $axy[1];
        $this->bx = $bxy[0];
        $this->by = $bxy[1];
        $this->px = $pxy[0];
        $this->py = $pxy[1];
    }

    public function cost(int $pbase = 0): int
    {
        $nom_a = ($pbase + $this->px) * $this->by - ($pbase + $this->py) * $this->bx;
        $den_a = $this->ax * $this->by - $this->ay * $this->bx;
        if (($den_a == 0) or ($nom_a % $den_a != 0)) {
            return 0;
        }
        $a = intdiv($nom_a, $den_a);
        $b = intdiv($pbase + $this->px - $a * $this->ax, $this->bx);
        if (
            ($a * $this->ax + $b * $this->bx != $pbase + $this->px)
                or ($a * $this->ay + $b * $this->by != $pbase + $this->py)
        ) {
            return 0;
        }
        return $a * self::COST_A + $b * self::COST_B;
    }
}
