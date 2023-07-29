<?php

// phpcs:disable PSR1.Classes.ClassDeclaration.MultipleClasses

declare(strict_types=1);

namespace TBali\Aoc2019;

use TBali\Aoc\SolutionBase;

/**
 * AoC 2019 Day 17: Set and Forget.
 *
 * Part 1: What is the sum of the alignment parameters for the scaffold intersections?
 * Part 2: After visiting every part of the scaffold at least once,
 *         how much dust does the vacuum robot report it has collected?
 *
 * @see https://adventofcode.com/2019/day/17
 *
 * @todo complete part 2
 *
 * @codeCoverageIgnore
 */
final class Aoc2019Day17 extends SolutionBase
{
    public const YEAR = 2019;
    public const DAY = 17;
    public const TITLE = 'Set and Forget';
    public const SOLUTIONS = [5724, 0];

    private const SHOW_GRID = false;
    private const DIRS = '^>v<';
    private const SCAFFOLD = '#';
    private const DELTA_XY = [0 => [0, -1], 1 => [1, 0], 2 => [0, 1], 3 => [-1, 0]];
    private const COMMANDS = [0 => 'F', -1 => 'L', 1 => 'R'];
    private const LF = 10;

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
        /** @var array<int, int> */
        $memory = array_map(intval(...), explode(',', $input[0]));
        // ---------- Get camera view
        $ascii = new AsciiSimulator($memory);
        $ascii->simulate();
        $grid = [];
        $x = 0;
        $y = 0;
        $robotX = 0;
        $robotY = 0;
        $robotDir = 0;
        foreach ($ascii->outputs as $c) {
            if ($c == self::LF) {
                $x = 0;
                ++$y;
                continue;
            }
            if ($x == 0) {
                $grid[$y] = '';
            }
            $pos = strpos(self::DIRS, chr($c));
            if ($pos !== false) {
                $robotX = $x;
                $robotY = $y;
                $robotDir = $pos;
                $grid[$y] .= self::SCAFFOLD;
            } else {
                $grid[$y] .= chr($c);
            }
            ++$x;
        }
        $maxX = strlen($grid[0]);
        $maxY = count($grid);
        // @phpstan-ignore-next-line
        if (self::SHOW_GRID) {
            // @codeCoverageIgnoreStart
            foreach ($grid as $line) {
                echo $line, PHP_EOL;
            }
            echo 'vacuum: ' . $robotX . ', ' . $robotY . ',' . self::DIRS[$robotDir], PHP_EOL;
            // @codeCoverageIgnoreEnd
        }
        // ---------- Part 1
        $ans1 = 0;
        for ($y = 0; $y < $maxY; ++$y) {
            for ($x = 0; $x < $maxX; ++$x) {
                if (
                    ($x > 0) and ($x < $maxX - 1) and ($y > 0) and ($y < $maxY - 1)
                    and ($grid[$y][$x] . $grid[$y][$x - 1] . $grid[$y][$x + 1] . $grid[$y - 1][$x] . $grid[$y + 1][$x]
                        == str_repeat(self::SCAFFOLD, 5))
                ) {
                    $ans1 += $x * $y;
                }
            }
        }
        // ---------- Part 2
        $ans2 = 0;
        // assumption: start position of vacuum robot one of the end of the scaffolding
        $commands = [];
        $x = $robotX;
        $y = $robotY;
        $dir = $robotDir;
        // travel scaffolding, generate command sequence without function usage
        while (true) {
            $isOk = false;
            $x1 = $x;
            $y1 = $y;
            foreach (self::COMMANDS as $ddir => $command) {
                $dir1 = ($dir + $ddir + 4) % 4;
                [$dx, $dy] = self::DELTA_XY[$dir1];
                $x1 = $x + $dx;
                $y1 = $y + $dy;
                if (
                    ($x1 < 0) or ($x1 >= $maxX) or ($y1 < 0) or ($y1 >= $maxY)
                    or ($grid[$y1][$x1] != self::SCAFFOLD)
                ) {
                    continue;
                }
                $isOk = true;
                if ($ddir != 0) {
                    $commands[] = $command;
                    $x1 = $x;
                    $y1 = $y;
                    $dir = $dir1;
                    break;
                }
                // straight move
                if (
                    (count($commands) == 0)
                    or ($commands[count($commands) - 1] == 'L')
                    or ($commands[count($commands) - 1] == 'R')
                ) {
                    // $commands[] = '1';
                    $commands[] = 'F';
                } else {
                    // $commands[count($commands) - 1] = strval(intval($commands[count($commands) - 1]) + 1);
                    $commands[] = 'F';
                }
                $x = $x1;
                $y = $y1;
                break;
            }
            if (!$isOk) {
                break;
            }
        }
        $commandStr = implode(',', $commands);
        // @phpstan-ignore-next-line
        if (self::SHOW_GRID) {
            // @codeCoverageIgnoreStart
            echo $commandStr, PHP_EOL;
            // @codeCoverageIgnoreEnd
        }
        // find optimal functions
        $selectedFunctions = [];
        // $bestFunction = 'L,F,F,F,F,F,F,F,F,F,F,F,F,L,F,F,F,F,F,F,F,F,F,F,F,F,R,F,F,F,F';
        // $selectedFunctions[] = $bestFunction;
        // $commandStr = str_replace($bestFunction, chr(ord('A')), $commandStr);
        // $bestFunction = 'R,F,F,F,F';
        // $selectedFunctions[] = $bestFunction;
        // $commandStr = str_replace($bestFunction, chr(ord('A') + 1), $commandStr);
        // $bestFunction = 'F,F';
        // $selectedFunctions[] = $bestFunction;
        // $commandStr = str_replace($bestFunction, chr(ord('A') + 2), $commandStr);
        for ($j = 0; $j < 3; ++$j) {
            $functionSavings = [];
            for ($from = 0; $from < count($commands); ++$from) {
                for ($to = $from; $to < count($commands); ++$to) {
                    $function = implode(',', array_slice($commands, $from, $to - $from + 1));
                    if (strlen($function) > 200) {
                        continue;
                    }
                    $count = substr_count($commandStr, $function);
                    if ($count <= 1) {
                        continue;
                    }
                    $saving = $count * (strlen($function) - 1);
                    if (($functionSavings[$function] ?? 0) >= $saving) {
                        continue;
                    }
                    $functionSavings[$function] = $saving;
                }
            }
            arsort($functionSavings);
            $bestFunction = strval(array_key_first($functionSavings) ?: '0');
            $selectedFunctions[] = $bestFunction;
            $commandStr = str_replace($bestFunction, chr(ord('A') + $j), $commandStr);
        }
        // A,B,C,C,C,B,C,B,B,A,B,C,A,C,C,C,B,C,B,B,A,B,C,C,C,B,C,B,B,B,C,A,C,A,C,C,C,B,C,B,B
        for ($j = 0; $j < 3; ++$j) {
            $selectedFunctions[$j] = str_replace('F,F,F,F,F,F,F,F,F,F,F,F', '12', $selectedFunctions[$j]);
            $selectedFunctions[$j] = str_replace('F,F,F,F,F,F,F,F,F,F', '10', $selectedFunctions[$j]);
            $selectedFunctions[$j] = str_replace('F,F,F,F,F,F,F,F', '8', $selectedFunctions[$j]);
            $selectedFunctions[$j] = str_replace('F,F,F,F,F,F', '6', $selectedFunctions[$j]);
            $selectedFunctions[$j] = str_replace('F,F,F,F', '4', $selectedFunctions[$j]);
            $selectedFunctions[$j] = str_replace('F,F', '2', $selectedFunctions[$j]);
        }
        // @phpstan-ignore-next-line
        if (self::SHOW_GRID) {
            // @codeCoverageIgnoreStart
            foreach ($selectedFunctions as $line) {
                echo '  ' . $line, PHP_EOL;
            }
            echo $commandStr, PHP_EOL;
            // @codeCoverageIgnoreEnd
        }
        // echo $commandStr, PHP_EOL;
        $memory[0] = 2;
        $vacuum = new AsciiSimulator($memory);
        $vacuum->stringInput($commandStr);
        for ($j = 0; $j < 3; ++$j) {
            $vacuum->stringInput($selectedFunctions[$j]);
        }
        $vacuum->stringInput('n'); // no debug camera feed
        $vacuum->simulate();
        $ans2 = $vacuum->nextOutputOrDebug();
        return [strval($ans1), strval($ans2)];
    }
}

// L,12,L,12,R,4,R,10,R,6,R,4,R,4,L,12,L,12,R,4,R,6,L,12,L,12,R,10,R,6,R,4,R,4,L,12,L,12,R,4,R,10,R,6,R,4,R,4,R,6,
// L,12,L,12,R,6,L,12,L,12,R,10,R,6,R,4,R,4
// L,12,L,12,                     L,12,L,12,        L,12,L,12,                 L,12,L,12,
// L,12,L,12,    L,12,L,12,
//               R,10,R,6,R,4,R,4                             R,10,R,6,R,4,R,4               R,10,R,6,R,4,R,4
//                        R,10,R,6,R,4,R,4
//           R,4                            R,4,R,6                                      R,4                  R,6
//           R,6

// --------------------------------------------------------------------
/**
 * @codeCoverageIgnore
 */
final class AsciiSimulator
{
    private const INSTRUCTION_LENGTHS =
        [1 => 4, 2 => 4, 3 => 2, 4 => 2, 5 => 3, 6 => 3, 7 => 4, 8 => 4, 9 => 2, 99 => 1];
    private const LF = 10;

    /** @var array<int, int> */
    public array $inputs = [];
    /** @var array<int, int> */
    public array $outputs = [];
    public bool $halted = false;

    private int $ic = 0;
    private int $idxInput = 0;
    private int $idxOutput = 0;
    private int $relBase = 0;

    /**
     * @param array<int, int> $memory
     */
    public function __construct(
        private array $memory,
    ) {
    }

    public function simulate(): void
    {
        while (true) {
            if ($this->ic >= count($this->memory)) {
                throw new \Exception('Invalid input');
            }
            $opcode = $this->memory[$this->ic] % 100;
            if ($opcode == 99) {
                $this->halted = true;
                return;
            }
            $len = self::INSTRUCTION_LENGTHS[$opcode] ?? throw new \Exception('Invalid input');
            if ($this->ic > count($this->memory) - $len) {
                throw new \Exception('Invalid input');
            }
            $addresses = [];
            $params = [];
            for ($i = 1; $i < $len; ++$i) {
                $mode = intdiv($this->memory[$this->ic], 10 ** ($i + 1)) % 10;
                $addresses[$i] = match ($mode) {
                    0 => $this->memory[$this->ic + $i],
                    1 => $this->ic + $i,
                    2 => $this->memory[$this->ic + $i] + $this->relBase,
                    default => throw new \Exception('Invalid input'),
                };
                $params[$i] = $this->memory[$addresses[$i]] ?? 0;
            }
            if (($opcode == 3) and ($this->idxInput >= count($this->inputs))) {
                return;
            }
            $oldIc = $this->ic;
            match ($opcode) {
                1 => $this->memory[$addresses[3]] = $params[1] + $params[2],
                2 => $this->memory[$addresses[3]] = $params[1] * $params[2],
                3 => $this->memory[$addresses[1]] = $this->inputs[$this->idxInput++],
                4 => $this->outputs[] = $params[1],
                5 => $this->ic = $params[1] != 0 ? $params[2] : $this->ic,
                6 => $this->ic = $params[1] == 0 ? $params[2] : $this->ic,
                7 => $this->memory[$addresses[3]] = $params[1] < $params[2] ? 1 : 0,
                8 => $this->memory[$addresses[3]] = $params[1] == $params[2] ? 1 : 0,
                9 => $this->relBase += $params[1],
                default => throw new \Exception('Invalid input'),
            };
            if ($this->ic == $oldIc) {
                $this->ic += $len;
            }
        }
    }

    public function stringInput(string $line): void
    {
        for ($i = 0; $i < strlen($line); ++$i) {
            $this->inputs[] = ord($line[$i]);
        }
        $this->inputs[] = self::LF;
    }

    public function nextOutputOrDebug(): int
    {
        if (($this->idxOutput < 0) or ($this->idxOutput >= count($this->outputs))) {
            // @codeCoverageIgnoreStart
            throw new \Exception('Output unavailable');
            // @codeCoverageIgnoreEnd
        }
        $message = '';
        for ($i = $this->idxOutput; $i < count($this->outputs); ++$i) {
            $message .= chr($this->outputs[$i]);
        }
        $this->idxOutput = count($this->outputs);
        $ans = $this->outputs[$this->idxOutput - 1];
        if (($ans >= 0) and ($ans <= 255)) {
            // echo $message;
        }
        return $ans;
    }
}
