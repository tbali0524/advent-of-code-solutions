<?php

// phpcs:disable PSR1.Classes.ClassDeclaration.MultipleClasses

declare(strict_types=1);

namespace TBali\Aoc2022;

use TBali\Aoc\SolutionBase;

/**
 * AoC 2022 Day 11: Monkey in the Middle.
 *
 * Part 1: What is the level of monkey business after 20 rounds of stuff-slinging simian shenanigans?
 * Part 2: Starting again from the initial state in your puzzle input, what is the level of monkey business
 *         after 10000 rounds?
 *
 * Topics: game simulation
 *
 * @see https://adventofcode.com/2022/day/11
 */
final class Aoc2022Day11 extends SolutionBase
{
    public const YEAR = 2022;
    public const DAY = 11;
    public const TITLE = 'Monkey in the Middle';
    public const SOLUTIONS = [121450, 28244037010];
    public const EXAMPLE_SOLUTIONS = [[10605, 2713310158]];
    public const LARGE_SOLUTIONS = [[2683200, 865971689472]];
    // large input #2 takes ~2 mins, so skipped
    // public const LARGE_SOLUTIONS = [[2683200, 865971689472], [1299238165, 8550016450757301]];

    private const MAX_TURNS_PART1 = 20;
    private const MAX_TURNS_PART2 = 10_000;

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
        // ---------- Part 1 + 2
        $startMonkeys = $this->parseInput($input);
        $ans1 = $this->simulate($startMonkeys, self::MAX_TURNS_PART1, 3);
        $ans2 = $this->simulate($startMonkeys, self::MAX_TURNS_PART2, 1);
        return [strval($ans1), strval($ans2)];
    }

    /**
     * @param array<int, Monkey> $startMonkeys
     */
    private function simulate(array $startMonkeys, int $countTurns, int $worryDivide = 3): int
    {
        $monkeys = array_map(
            static fn (Monkey $m): Monkey => clone $m,
            $startMonkeys
        );
        /** @var array<int, int> */
        $testOperands = array_map(
            static fn (Monkey $m): int => $m->testOperand,
            $startMonkeys
        );
        $worryModulo = $testOperands[0];
        for ($i = 1; $i < count($testOperands); ++$i) {
            $worryModulo = self::lcm($worryModulo, $testOperands[$i]);
        }
        for ($i = 0; $i < $countTurns; ++$i) {
            foreach ($monkeys as $monkey) {
                $monkey->countInspections += count($monkey->items);
                foreach ($monkey->items as $item) {
                    $item = match ($monkey->operator) {
                        '+' => $item + $monkey->operand,
                        '*' => intval($item * $monkey->operand),
                        '^' => intval($item ** $monkey->operand),
                        default => $item,
                    };
                    $item = intdiv($item, $worryDivide) % $worryModulo;
                    if ($item % $monkey->testOperand == 0) {
                        $monkeys[$monkey->trueTarget]->items[] = $item;
                    } else {
                        $monkeys[$monkey->falseTarget]->items[] = $item;
                    }
                }
                $monkey->items = [];
            }
        }
        $monkeyBusinesses = array_map(
            static fn (Monkey $m): int => $m->countInspections,
            $monkeys
        );
        rsort($monkeyBusinesses);
        return ($monkeyBusinesses[0] ?? 0) * ($monkeyBusinesses[1] ?? 1);
    }

    /**
     * @param array<int, string> $input The lines of the input, without LF
     *
     * @return array<int, Monkey>
     */
    private function parseInput(array $input): array
    {
        $monkeys = [];
        $countMonkeys = intdiv(count($input) + 1, 7);
        if (count($input) != $countMonkeys * 7 - 1) {
            throw new \Exception('Invalid input');
        }
        for ($i = 0; $i < $countMonkeys; ++$i) {
            if (
                !str_starts_with($input[$i * 7], 'Monkey ')
                or !str_starts_with($input[$i * 7 + 1], '  Starting items: ')
                or !str_starts_with($input[$i * 7 + 2], '  Operation: new = old ')
                or !str_starts_with($input[$i * 7 + 3], '  Test: divisible by ')
                or !str_starts_with($input[$i * 7 + 4], '    If true: throw to monkey ')
                or !str_starts_with($input[$i * 7 + 5], '    If false: throw to monkey ')
                or (($i != $countMonkeys - 1) and ($input[$i * 7 + 6] != ''))
            ) {
                // @codeCoverageIgnoreStart
                throw new \Exception('Invalid input');
                // @codeCoverageIgnoreEnd
            }
            $m = new Monkey();
            $m->id = intval(substr($input[$i * 7], 7, -1));
            $m->items = array_map(intval(...), explode(', ', substr($input[$i * 7 + 1], 18)));
            if (substr($input[$i * 7 + 2], 25) == 'old') {
                $m->operator = '^';
                $m->operand = 2;
            } else {
                $m->operator = $input[$i * 7 + 2][23];
                $m->operand = intval(substr($input[$i * 7 + 2], 25));
            }
            $m->testOperand = intval(substr($input[$i * 7 + 3], 21));
            $m->trueTarget = intval(substr($input[$i * 7 + 4], 29));
            $m->falseTarget = intval(substr($input[$i * 7 + 5], 30));
            if (
                ($m->id != $i)
                or !str_contains('+*^', $m->operator)
                or ($m->testOperand == 0)
                or ($m->trueTarget < 0)
                or ($m->trueTarget >= $countMonkeys)
                or ($m->falseTarget < 0)
                or ($m->falseTarget >= $countMonkeys)
            ) {
                // @codeCoverageIgnoreStart
                throw new \Exception('Invalid input');
                // @codeCoverageIgnoreEnd
            }
            $monkeys[] = $m;
        }
        return $monkeys;
    }

    /**
     * Greatest common divisor.
     *
     * @see https://en.wikipedia.org/wiki/Greatest_common_divisor
     */
    private static function gcd(int $a, int $b): int
    {
        $a1 = max($a, $b);
        $b1 = min($a, $b);
        while ($b1 != 0) {
            $t = $b1;
            $b1 = $a1 % $b1;
            $a1 = $t;
        }
        return $a1;
    }

    /**
     * Least common multiple.
     *
     * @see https://en.wikipedia.org/wiki/Least_common_multiple
     */
    private static function lcm(int $a, int $b): int
    {
        return abs($a) * intdiv(abs($b), self::gcd($a, $b));
    }
}

// --------------------------------------------------------------------
final class Monkey
{
    public int $id;
    /** @var array<int, int> */
    public array $items;
    public string $operator;
    public int $operand;
    public int $testOperand;
    public int $trueTarget;
    public int $falseTarget;
    public int $countInspections = 0;
}
