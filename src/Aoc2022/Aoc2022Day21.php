<?php

// phpcs:disable PSR1.Classes.ClassDeclaration.MultipleClasses

declare(strict_types=1);

namespace TBali\Aoc2022;

use TBali\Aoc\SolutionBase;

/**
 * AoC 2022 Day 21: Monkey Math.
 *
 * Part 1: What number will the monkey named root yell?
 * Part 2: What number do you yell to pass root's equality test?
 *
 * Topics: tree graph, math expression evaluation
 *
 * @see https://adventofcode.com/2022/day/21
 */
final class Aoc2022Day21 extends SolutionBase
{
    public const YEAR = 2022;
    public const DAY = 21;
    public const TITLE = 'Monkey Math';
    public const SOLUTIONS = [78342931359552, 3296135418820];
    public const EXAMPLE_SOLUTIONS = [[152, 301]];

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
        // ---------- Part 1
        $mb = new \TBali\Aoc2022\MonkeyBusiness();
        $mb->parseInput($input);
        $ans1 = $mb->eval(MathMonkey::ROOT);
        // ---------- Part 2
        $mb = new \TBali\Aoc2022\MonkeyBusiness();
        $mb->parseInput($input);
        $ans2 = $mb->solvePart2();
        return [strval($ans1), strval($ans2)];
    }
}

// --------------------------------------------------------------------
final class MathMonkey
{
    public const ROOT = 'root';
    public const HUMAN = 'humn';

    public string $name = '';
    public bool $isKnown = false;
    public int $value = 0;
    public string $operator = '';
    public string $operand1 = '';
    public string $operand2 = '';
    public bool $humanInvolved = false;

    public static function fromString(string $s): self
    {
        $m = new self();
        $m->name = substr($s, 0, 4);
        if (strlen($s) == 17) {
            if (($s[4] . $s[5] . $s[10] . $s[12]) != ':   ') {
                // @codeCoverageIgnoreStart
                throw new \Exception('Invalid input');
                // @codeCoverageIgnoreEnd
            }
            $m->operand1 = substr($s, 6, 4);
            $m->operand2 = substr($s, 13, 4);
            $m->operator = $s[11];
        } elseif (strlen($s) > 6) {
            if (($s[4] . $s[5]) != ': ') {
                // @codeCoverageIgnoreStart
                throw new \Exception('Invalid input');
                // @codeCoverageIgnoreEnd
            }
            $m->value = intval(substr($s, 6));
            $m->isKnown = true;
        } else {
            throw new \Exception('Invalid input');
        }
        return $m;
    }
}

// --------------------------------------------------------------------
final class MonkeyBusiness
{
    /** @var array<string, MathMonkey> */
    public array $monkeys = [];

    /**
     * Parse input, sets startStacks and instructions.
     *
     * @param array<int, string> $input The lines of the input, without LF
     */
    public function parseInput(array $input): void
    {
        $this->monkeys = [];
        foreach ($input as $line) {
            $m = MathMonkey::fromString($line);
            $this->monkeys[$m->name] = $m;
        }
    }

    public function eval(string $name): int
    {
        $m = $this->monkeys[$name] ?? throw new \Exception('Invalid input');
        if ($m->isKnown) {
            return $m->value;
        }
        $op1 = $this->eval($m->operand1);
        $op2 = $this->eval($m->operand2);
        $m->value = match ($m->operator) {
            '+' => $op1 + $op2,
            '-' => $op1 - $op2,
            '*' => $op1 * $op2,
            '/' => $op2 != 0 ? intdiv($op1, $op2) : throw new \Exception('Invalid input'),
            default => throw new \Exception('Invalid input'),
        };
        $m->isKnown = true;
        return $m->value;
    }

    public function evalCheckHuman(string $name): int
    {
        $m = $this->monkeys[$name] ?? throw new \Exception('Invalid input');
        if ($m->name == MathMonkey::HUMAN) {
            $m->humanInvolved = true;
            return 0;
        }
        if ($m->isKnown) {
            return $m->value;
        }
        $op1m = $this->monkeys[$m->operand1] ?? throw new \Exception('Invalid input');
        $op2m = $this->monkeys[$m->operand2] ?? throw new \Exception('Invalid input');
        $op1 = $this->evalCheckHuman($m->operand1);
        $op2 = $this->evalCheckHuman($m->operand2);
        if ($op1m->humanInvolved or $op2m->humanInvolved) {
            $m->humanInvolved = true;
            return 0;
        }
        $m->value = match ($m->operator) {
            '+' => $op1 + $op2,
            '-' => $op1 - $op2,
            '*' => $op1 * $op2,
            '/' => $op2 != 0 ? intdiv($op1, $op2) : throw new \Exception('Invalid input'),
            default => throw new \Exception('Invalid input'),
        };
        $m->isKnown = true;
        return $m->value;
    }

    public function solveHuman(string $name, int $goal): int
    {
        if ($name == MathMonkey::HUMAN) {
            return $goal;
        }
        $m = $this->monkeys[$name] ?? throw new \Exception('Invalid input');
        $op1m = $this->monkeys[$m->operand1] ?? throw new \Exception('Invalid input');
        $op2m = $this->monkeys[$m->operand2] ?? throw new \Exception('Invalid input');
        if ($op1m->humanInvolved and !$op2m->humanInvolved) {
            return match ($m->operator) {
                '+' => $this->solveHuman($m->operand1, $goal - $op2m->value),
                '-' => $this->solveHuman($m->operand1, $goal + $op2m->value),
                '*' => $this->solveHuman($m->operand1, intdiv($goal, $op2m->value)),
                '/' => (
                    $op2m->value != 0
                    ? $this->solveHuman($m->operand1, $goal * $op2m->value)
                    : throw new \Exception('Invalid input')
                ),
                default => throw new \Exception('Invalid input'),
            };
        } elseif (!$op1m->humanInvolved and $op2m->humanInvolved) {
            return match ($m->operator) {
                '+' => $this->solveHuman($m->operand2, $goal - $op1m->value),
                '-' => $this->solveHuman($m->operand2, $op1m->value - $goal),
                '*' => $this->solveHuman($m->operand2, intdiv($goal, $op1m->value)),
                '/' => (
                    $goal != 0
                    ? $this->solveHuman($m->operand2, intdiv($op1m->value, $goal))
                    : throw new \Exception('Invalid input')
                ),
                default => throw new \Exception('Invalid input'),
            };
        } else {
            throw new \Exception('Invalid input');
        }
    }

    public function solvePart2(): int
    {
        $this->evalCheckHuman(MathMonkey::ROOT);
        $root = $this->monkeys[MathMonkey::ROOT] ?? throw new \Exception('Invalid input');
        $op1m = $this->monkeys[$root->operand1] ?? throw new \Exception('Invalid input');
        $op2m = $this->monkeys[$root->operand2] ?? throw new \Exception('Invalid input');
        if ($op1m->humanInvolved and !$op2m->humanInvolved) {
            return $this->solveHuman($op1m->name, $op2m->value);
        }
        if (!$op1m->humanInvolved and $op2m->humanInvolved) {
            return $this->solveHuman($op2m->name, $op1m->value);
        }
        throw new \Exception('Invalid input');
    }
}
