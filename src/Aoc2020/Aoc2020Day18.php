<?php

/*
https://adventofcode.com/2020/day/18
Part 1: Evaluate the expression on each line of the homework; what is the sum of the resulting values?
Part 2: What do you get if you add up the results of evaluating the homework problems using these new rules?
Topics: math expression evaluation (non-negative integers only, but with parentheses and precedence)
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
    public const SOLUTIONS = [12956356593940, 94240043727614];
    public const EXAMPLE_SOLUTIONS = [[71, 231], [13632, 23340]];
    public const EXAMPLE_STRING_INPUTS = [
        '1 + 2 * 3 + 4 * 5 + 6',
        '((2 + 4 * 9) * (6 + 9 * 8 + 6) + 6) + 2 + 4 * 2',
    ];

    private const PRECEDENCES_PART1 = [
        '+' => 0,
        '*' => 0,
    ];
    private const PRECEDENCES_PART2 = [
        '+' => 1,
        '*' => 0,
    ];

    /**
     * @param string[] $input
     *
     * @return array{string, string}
     */
    public function solve(array $input): array
    {
        // ---------- Part 1 + 2
        $ans1 = array_sum(array_map(fn ($x) => (new Expression($x, self::PRECEDENCES_PART1))->evaluate(), $input));
        $ans2 = array_sum(array_map(fn ($x) => (new Expression($x, self::PRECEDENCES_PART2))->evaluate(), $input));
        return [strval($ans1), strval($ans2)];
    }
}

// --------------------------------------------------------------------
final class Expression
{
    public string $expr;
    /** @var array<string, int> */
    private array $precedences;
    /** @var string[] */
    private array $operators = [];
    /** @var int [] */
    private array $operands = [];

    /** @param array<string, int> $precedences */
    public function __construct(string $expr, array $precedences)
    {
        $this->expr = trim($expr);
        $this->precedences = $precedences;
    }

    public function evaluate(): int
    {
        if ($this->expr == '') {
            throw new \Exception('Invalid formula');
        }
        $start = 0;
        while (true) {
            $start = $this->skipSpace($start);
            if ($start == strlen($this->expr)) {
                break;
            }
            if ($this->expr[$start] == '(') {
                $end = $this->getCloseParPos($start);
                $parString = substr($this->expr, $start + 1, $end - $start - 1);
                $parExpression = new Expression($parString, $this->precedences);
                $this->operands[] = $parExpression->evaluate();
                ++$end;
            } elseif (ctype_digit($this->expr[$start])) {
                $end = $start + 1;
                while (($end < strlen($this->expr)) and ctype_digit($this->expr[$end])) {
                    ++$end;
                }
                $this->operands[] = intval(substr($this->expr, $start, $end - $start));
            } else {
                throw new \Exception('Invalid formula');
            }
            $start = $this->skipSpace($end);
            if ($start == strlen($this->expr)) {
                break;
            }
            $operator = $this->expr[$start];
            while (
                (count($this->operators) > 0)
                && ($this->precedences[$operator] <= $this->precedences[$this->operators[count($this->operators) - 1]])
            ) {
                $this->simplifyStep();
            }
            $this->operators[] = $operator;
            ++$start;
        }
        while (count($this->operators) > 0) {
            $this->simplifyStep();
        }
        if (count($this->operands) != 1) {
            throw new \Exception('Invalid formula');
        }
        return intval(array_pop($this->operands));
    }

    private function skipSpace(int $from): int
    {
        while (($from < strlen($this->expr)) and ($this->expr[$from] == ' ')) {
            ++$from;
        }
        return $from;
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

    private function simplifyStep(): void
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
}
