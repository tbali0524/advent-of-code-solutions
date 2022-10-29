<?php

/*
https://adventofcode.com/2015/day/7
Part 1: What signal is ultimately provided to wire a?
Part 2: What new signal is ultimately provided to wire a?
*/

// phpcs:disable PSR1.Files.SideEffects, PSR1.Classes.ClassDeclaration

declare(strict_types=1);

namespace TBali\Aoc15_07;

// --------------------------------------------------------------------
const YEAR = 2015;
const DAY = '07';
const TITLE = 'Some Assembly Required';
const SOLUTION1 = 956;
const SOLUTION2 = 40149;
$startTime = hrtime(true);
// ----------
$handle = fopen('input/' . YEAR . '/aoc15_07.txt', 'r');
if ($handle === false) {
    throw new \Exception('Cannot load input file');
}
$input = [];
while (true) {
    $line = fgets($handle);
    if ($line === false) {
        break;
    }
    if (trim($line) == '') {
        continue;
    }
    $input[] = trim($line);
}
fclose($handle);
// --------------------------------------------------------------------
// Part 1
$circuit = new Circuit();
foreach ($input as $line) {
    $gate = new Gate($line);
    $circuit->gates[$gate->id] = $gate;
}
$ans1 = $circuit->evaluate('a');
// --------------------------------------------------------------------
// Part 2
$circuit = new Circuit();
foreach ($input as $line) {
    $gate = new Gate($line);
    $circuit->gates[$gate->id] = $gate;
}
$circuit->gates['b'] = new Gate('956 -> b');
$ans2 = $circuit->evaluate('a');
// ----------
$spentTime = number_format((hrtime(true) - $startTime) / 1000_000_000, 4, '.', '');
$maxMemory = strval(ceil(memory_get_peak_usage(true) / 1000_000));
echo '=== AoC ' . YEAR . ' Day ' . DAY . ' [time: ' . $spentTime . ' sec, memory: ' . $maxMemory . ' MB]: ' . TITLE
    . PHP_EOL;
echo $ans1, PHP_EOL;
if ($ans1 != SOLUTION1) {
    echo '*** WRONG ***', PHP_EOL;
}
echo $ans2, PHP_EOL;
if ($ans2 != SOLUTION2) {
    echo '*** WRONG ***', PHP_EOL;
}

// --------------------------------------------------------------------
class Gate
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
class Circuit
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
