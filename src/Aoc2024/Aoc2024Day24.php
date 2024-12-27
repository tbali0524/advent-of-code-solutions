<?php

// phpcs:disable PSR1.Classes.ClassDeclaration.MultipleClasses

declare(strict_types=1);

namespace TBali\Aoc2024;

use TBali\Aoc\SolutionBase;

/**
 * AoC 2024 Day 24: Crossed Wires.
 *
 * @see https://adventofcode.com/2024/day/24
 */
final class Aoc2024Day24 extends SolutionBase
{
    public const YEAR = 2024;
    public const DAY = 24;
    public const TITLE = 'Crossed Wires';
    public const SOLUTIONS = [51107420031718, 'cpm,ghp,gpr,krs,nks,z10,z21,z33'];
    public const EXAMPLE_SOLUTIONS = [[4, 0], [2024, 0]];

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
        $gates = [];
        $i = 0;
        while (($i < count($input)) and ($input[$i] != '')) {
            if ((strlen($input[$i]) != 6) or ($input[$i][3] != ':') or ($input[$i][4] != ' ')) {
                throw new \Exception('input definitions must be 3 letters, followed by `: ` and 0 or 1');
            }
            $name = substr($input[$i], 0, 3);
            $gate = new Gate($name);
            $gate->output = match ($input[$i][5]) {
                '0' => 0,
                '1' => 1,
                default => throw new \Exception('input values must be 0 or 1'),
            };
            $gates[$name] = $gate;
            ++$i;
        }
        if ($i == count($input)) {
            throw new \Exception('input and gate definitions must be separated by an empty line');
        }
        $count_bits = intdiv($i, 2);
        ++$i;
        while ($i < count($input)) {
            $words = explode(' ', $input[$i]);
            if (count($words) != 5) {
                throw new \Exception('gate definitions must be 5 words');
            }
            if ($words[3] != '->') {
                throw new \Exception('gate definition 4th word must be `->`');
            }
            $name = $words[4];
            $gate = new Gate($name);
            $gate->inputs[0] = $words[0];
            $gate->inputs[1] = $words[2];
            $gate->operator = match ($words[1]) {
                'AND' => Operator::OpAnd,
                'OR' => Operator::OpOr,
                'XOR' => Operator::OpXor,
                default => throw new \Exception('gate operator must be AND, OR, XOR'),
            };
            if (isset($gates[$name])) {
                throw new \Exception('duplicate gate definition');
            }
            $gates[$name] = $gate;
            ++$i;
        }
        // ---------- Part 1
        $ans1 = 0;
        for ($i = 0; $i < 64; ++$i) {
            $name = 'z' . str_pad(strval($i), 2, '0', STR_PAD_LEFT);
            if (!isset($gates[$name])) {
                break;
            }
            $bit = self::evaluate($gates, $name);
            $ans1 |= $bit << $i;
        }
        // ---------- Part 2
        if (count($input) < 50) {
            return [strval($ans1), '0'];
        }
        $result = [];
        // Part 2 was originally solved manually in Excel:
        //    result = ['cpm', 'ghp', 'gpr', 'krs', 'nks', 'z10', 'z21', 'z33'];
        // What follows is finding the problematic gates, it works for my input, but most likely not for every inputs.
        $highest_bit = 'z' . str_pad(strval($count_bits), 2, '0', STR_PAD_LEFT);
        foreach ($gates as $name => $gate) {
            if ($gate->operator == Operator::Input) {
                continue;
            }
            if ($gate->operator == Operator::OpAnd) {
                if ($name[0] == 'z') {
                    $result[] = $name;
                    continue;
                }
                if (($gate->inputs[0] == 'x00') or ($gate->inputs[0] == 'y00')) {
                    continue;
                }
                if (($gate->inputs[0][0] == 'x') or ($gate->inputs[0][0] == 'y')) {
                    foreach ($gates as $gate2) {
                        if (($name != $gate2->inputs[0]) and ($name != $gate2->inputs[1])) {
                            continue;
                        }
                        if ($gate2->operator != Operator::OpOr) {
                            $result[] = $name;
                            break;
                        }
                    }
                }
            } elseif ($gate->operator == Operator::OpOr) {
                if (($name[0] == 'z') and ($name != $highest_bit)) {
                    $result[] = $name;
                    continue;
                }
                continue;
            } elseif ($gate->operator == Operator::OpXor) {
                if ($name[0] == 'z') {
                    if ($name != $highest_bit) {
                        continue;
                    }
                    // @codeCoverageIgnoreStart
                    $result[] = $name;
                    continue;
                    // @codeCoverageIgnoreEnd
                }
                if (($gate->inputs[0][0] == 'x') or ($gate->inputs[0][0] == 'y')) {
                    foreach ($gates as $gate2) {
                        if (($name != $gate2->inputs[0]) and ($name != $gate2->inputs[1])) {
                            continue;
                        }
                        if ($gate2->operator == Operator::OpOr) {
                            $result[] = $name;
                            break;
                        }
                    }
                    continue;
                }
                $result[] = $name;
            }
        }
        sort($result);
        $ans2 = implode(',', $result);
        return [strval($ans1), strval($ans2)];
    }

    /**
     * @param array<string, Gate> $gates
     */
    private function evaluate(array &$gates, string $name): int
    {
        $gate = $gates[$name] ?? throw new \Exception('invalid gate name');
        if ($gate->output >= 0) {
            return $gate->output;
        }
        $operand1_name = $gate->inputs[0];
        $operand2_name = $gate->inputs[1];
        $operator = $gate->operator;
        $operand1 = self::evaluate($gates, $operand1_name);
        $operand2 = self::evaluate($gates, $operand2_name);
        $output = match ($operator) {
            Operator::OpAnd => $operand1 & $operand2,
            Operator::OpOr => $operand1 | $operand2,
            Operator::OpXor => $operand1 ^ $operand2,
            default => throw new \Exception('impossible'),
        };
        $gate->output = $output;
        return $output;
    }
}

enum Operator
{
    case OpAnd;
    case OpOr;
    case OpXor;
    case Input;
}

class Gate
{
    public Operator $operator = Operator::Input;

    /**
     * @var array<int, string>
     */
    public array $inputs = ['', ''];

    public int $output = -1;

    public function __construct(public string $name)
    {
    }
}
