<?php

/*
https://adventofcode.com/2015/day/7
Part 1: What signal is ultimately provided to wire a?
Part 2: What new signal is ultimately provided to wire a?
*/

// phpcs:disable PSR1.Classes.ClassDeclaration

declare(strict_types=1);

namespace TBali\Aoc2015;

use TBali\Aoc\SolutionBase;

final class Aoc2015Day07 extends SolutionBase
{
    public const YEAR = 2015;
    public const DAY = 7;
    public const TITLE = 'Some Assembly Required';
    public const SOLUTIONS = [956, 40149];
    public const EXAMPLE_SOLUTIONS = [[72, 0], [0, 0]];

    /**
     * @param string[] $input
     *
     * @return array{string, string}
     */
    public function solve(array $input): array
    {
        // ---------- Part 1
        $circuit = new Circuit();
        foreach ($input as $line) {
            $gate = new Gate($line);
            $circuit->gates[$gate->id] = $gate;
        }
        $ans1 = $circuit->evaluate('a');
        // ---------- Part 2
        $circuit = new Circuit();
        foreach ($input as $line) {
            $gate = new Gate($line);
            $circuit->gates[$gate->id] = $gate;
        }
        $circuit->gates['b'] = new Gate('956 -> b');
        $ans2 = $circuit->evaluate('a');
        return [strval($ans1), strval($ans2)];
    }
}

// --------------------------------------------------------------------
final class Gate
{
    public string $id = '';
    public string $operator = '';
    public string $input1 = '';
    public string $input2 = '';
    public int $operand1 = 0;
    public int $operand2 = 0;
    public bool $isEvaluated = false;
    public int $value = 0;

    public function __construct(string $s)
    {
        $a = explode(' -> ', $s);
        if (count($a) != 2) {
            throw new \Exception('Invalid input');
        }
        $this->id = $a[1];
        $b = explode(' ', $a[0]);
        if (count($b) == 1) {
            $this->operator = 'ASSIGN';
            if (is_numeric($b[0])) {
                $this->operand1 = intval($b[0]);
            } else {
                $this->input1 = $b[0];
            }
            return;
        }
        if (count($b) == 2) {
            if ($b[0] != 'NOT') {
                throw new \Exception('Invalid input');
            }
            $this->operator = $b[0];
            if (is_numeric($b[1])) {
                $this->operand1 = intval($b[1]);
            } else {
                $this->input1 = $b[1];
            }
            return;
        }
        if (count($b) != 3) {
            throw new \Exception('Invalid input');
        }
        $this->operator = $b[1];
        if (is_numeric($b[0])) {
            $this->operand1 = intval($b[0]);
        } else {
            $this->input1 = $b[0];
        }
        if (is_numeric($b[2])) {
            $this->operand2 = intval($b[2]);
        } else {
            $this->input2 = $b[2];
        }
    }
}

// --------------------------------------------------------------------
final class Circuit
{
    /** @var array<string, Gate> */
    public array $gates = [];

    public function evaluate(string $id): int
    {
        if (!isset($this->gates[$id])) {
            throw new \Exception('Invalid wire id');
        }
        $gate = $this->gates[$id];
        if ($gate->isEvaluated) {
            return $gate->value;
        }
        $a = $gate->input1 == '' ? $gate->operand1 : $this->evaluate($gate->input1);
        if ($gate->operator == 'ASSIGN') {
            $gate->value = $a;
        } elseif ($gate->operator == 'NOT') {
            $gate->value = ~$a;
        } else {
            $b = $gate->input2 == '' ? $gate->operand2 : $this->evaluate($gate->input2);
            $gate->value = match ($gate->operator) {
                'AND' => $a & $b,
                'OR' => $a | $b,
                'LSHIFT' => $a << $b,
                'RSHIFT' => $a >> $b,
                default => throw new \Exception('Invalid operator')
            };
        }
        $gate->isEvaluated = true;
        return $gate->value;
    }
}
