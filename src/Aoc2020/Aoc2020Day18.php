<?php

/*
https://adventofcode.com/2020/day/18
Part 1: Evaluate the expression on each line of the homework; what is the sum of the resulting values?
Part 2: What do you get if you add up the results of evaluating the homework problems using these new rules?
*/

// phpcs:disable PSR1.Classes.ClassDeclaration

declare(strict_types=1);

namespace TBali\Aoc2020;

use TBali\Aoc\SolutionBase;

final class Aoc2020Day18 extends SolutionBase
{
    public const YEAR = 2020;
    public const DAY = 18;
    public const TITLE = 'Operation Order';
    public const SOLUTIONS = [12956356593940, 0];
    public const EXAMPLE_SOLUTIONS = [[71, 231], [13632, 23340]];
    public const EXAMPLE_STRING_INPUTS = [
        '1 + 2 * 3 + 4 * 5 + 6',
        '((2 + 4 * 9) * (6 + 9 * 8 + 6) + 6) + 2 + 4 * 2'
    ];

    private const PRECEDENCES_PART1 = [
        '+' => 0,
        '*' => 0,
    ];
    private const PRECEDENCES_PART2 = [
        '+' => 0,
        '*' => 1,
    ];

    /**
     * @param string[] $input
     *
     * @return array{string, string}
     */
    public function solve(array $input): array
    {
        // ---------- Part 1 + 2
        $ans1 = array_sum(array_map(fn ($x) => $this->evaluate($x, self::PRECEDENCES_PART1), $input));
        $ans2 = array_sum(array_map(fn ($x) => $this->evaluate($x, self::PRECEDENCES_PART2), $input));
        return [strval($ans1), strval($ans2)];
    }
}

final class Expression
{
    public string $expr;
    /** @var array<string, int> */
    private array $precedences;
    /** string[] */
    private array $operators = [];
    /** int [] */
    private array $operands = [];

    /** @param array<string, int> $precedences */
    public function __construct(string $expr, array $precedences)
    {
        $this->expr = $expr;
        $this->precedences = $precedences;
    }

    private function getCloseParPos(int $from): int
    {
        $depth = 0;
        $end = $from;
        while ($end < strlen($this->expr)) {
            if ($this->expr[$end] == '(') {
                ++$depth;
            } elseif ($this->expr[$end] == ')') {
                --$depth;
                if ($depth < 0) {
                    throw new \Exception('Invalid formula');
                }
                if ($depth == 0) {
                    return $end;
                }
            }
            ++$end;
        }
        throw new \Exception('Invalid formula');
    }

    public function simplify(): void
    {
        if ((count($this->operands) < 2) or (count($this->operators) < 1)) {
            throw new \Exception('Invalid formula');
        }
        $operand2 = array_pop($this->operands);
        $operand1 = array_pop($this->operands);
        $oldOperator = array_pop($this->operators);
        $newOperand = match ($oldOperator) {
            '+' => $operand1 + $operand2,
            '*' => $operand1 * $operand2,
            default => throw new \Exception('Invalid formula'),
        };
        $this->operands[] = $newOperand;
    }

    /** @param array<string, int> $precedences */
    private function evaluate(string $s, array $precedences = self::PRECEDENCES_PART1): int
    {
        $s = trim($s);
        if ($s == '') {
            throw new \Exception('Invalid formula');
        }
        $start = 0;
        $stackOperands = [];
        $stackOperators = [];
        while ($start < strlen($s)) {
            while (($start < strlen($s)) and ($s[$start] == ' ')) {
                ++$start;
            }
            $end = $start + 1;
            if ($s[$start] == '(') {
                $end = $this->getCloseParPos($s, $start);
                $stackOperands[] = $this->evaluate(substr($s, $start + 1, $end - $start - 1), $precedences);
                ++$end;
            } elseif (ctype_digit($s[$start])) {
                $end = $start;
                while (($end < strlen($s)) and ctype_digit($s[$end])) {
                    ++$end;
                }
                $stackOperands[] = intval(substr($s, $start, $end - $start));
            } else {
                throw new \Exception('Invalid formula');
            }
            while (($end < strlen($s)) and ($s[$end] == ' ')) {
                ++$end;
            }
            $start = $end;
            while (count($stackOperators) > 0) {
                $precedences[]

            }
            while (true) {
                if (count($stackOperands) == 2) {
                    if (count($stackOperators) == 0) {
                        throw new \Exception('Invalid formula');
                    }
                    $operand2 = array_pop($stackOperands);
                    $operand1 = array_pop($stackOperands);
                    $oldOperator = array_pop($stackOperators);
                    $newOperand = match ($oldOperator) {
                        '+' => $operand1 + $operand2,
                        '*' => $operand1 * $operand2,
                        default => throw new \Exception('Invalid formula'),
                    };
                    $stackOperands[] = $newOperand;
                }
            }
            if ($end == strlen($s)) {
                break;
            }
            $newOperator = $s[$end];
            $stackOperators[] = $newOperator;
            ++$start;
        }
        if ((count($stackOperands) != 1) or (count($stackOperators) != 0)) {
            throw new \Exception('Invalid formula');
        }
        return array_pop($stackOperands);
    }
}
