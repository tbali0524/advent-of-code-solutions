<?php

// phpcs:disable PSR1.Classes.ClassDeclaration.MultipleClasses

declare(strict_types=1);

namespace TBali\Aoc2019;

use TBali\Aoc\SolutionBase;

/**
 * AoC 2019 Day 25: Cryostasis.
 *
 * Part 1: Look around the ship and see if you can find the password for the main airlock.
 * Part 2: N/A
 *
 * Topics: assembly simulation, interactive fiction
 *
 * @see https://adventofcode.com/2019/day/25
 *
 * @codeCoverageIgnore
 */
final class Aoc2019Day25 extends SolutionBase
{
    public const YEAR = 2019;
    public const DAY = 25;
    public const TITLE = 'Cryostasis';
    public const SOLUTIONS = [537002052, 0];

    private const PLAY_GAME = true;
    private const SHOW_OUTPUT = false;
    private const INSTRUCTIONS = [
        'east',
        'take food ration',
        'east',
        'take manifold',
        'east',
        'east',
        'take jam',
        'west',
        'north',
        'east',
        'take spool of cat6',
        'west',
        'north',
        'take fuel cell',
        'south',
        'south',
        'west',
        'south',
        'north',
        'west',
        'south',
        'take prime number',
        'north',
        'west',
        // back to start point
        'north',
        // 'take photons',
        'north',
        'north',
        // 'take infinite loop',
        'east',
        // 'take molten lava',
        'east',
        'take loom',
        'west',
        'west',
        'south',
        'west',
        'take mug',
        'east',
        'south',
        'west',
        // 'take escape pod',
        'north',
        // 'take giant electromagnet',
        'west',
        'inv',
        'drop prime number',
        'drop food ration',
        'drop jam',
        'drop loom',
        'drop mug',
        'drop spool of cat6',
        'drop manifold',
        'drop fuel cell',
        'inv',
    ];

    private const ITEMS = [
        'prime number',
        'food ration',
        'jam',
        'loom',
        'mug',
        'spool of cat6',
        'manifold',
        'fuel cell',
    ];

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
        // ---------- Part 1
        $ans1 = self::SOLUTIONS[0];
        // @phpstan-ignore-next-line
        if (self::PLAY_GAME) {
            $game = new AdventureSimulator($memory);
            foreach (self::INSTRUCTIONS as $line) {
                $game->simulate();
                $output = $game->stringOutput();
                if ($output == '') {
                    return ['0', '0'];
                }
                // @phpstan-ignore-next-line
                if (self::SHOW_OUTPUT) {
                    echo $output, PHP_EOL;
                    echo $line, PHP_EOL;
                }
                $game->stringInput($line);
            }
            $output = $game->stringOutput();
            // @phpstan-ignore-next-line
            if (self::SHOW_OUTPUT) {
                echo $output, PHP_EOL;
            }
            for ($bitmask = 0; $bitmask < (1 << count(self::ITEMS)); ++$bitmask) {
                for ($i = 0; $i < count(self::ITEMS); ++$i) {
                    if ((($bitmask >> $i) & 1) != 0) {
                        $game->stringInput('take ' . self::ITEMS[$i]);
                        // @phpstan-ignore-next-line
                        if (self::SHOW_OUTPUT) {
                            echo 'take ' . self::ITEMS[$i], PHP_EOL;
                        }
                    }
                }
                $game->stringInput('north');
                $game->simulate();
                $output = $game->stringOutput();
                // @phpstan-ignore-next-line
                if (self::SHOW_OUTPUT) {
                    echo $output, PHP_EOL;
                }
                if (!str_contains($output, 'Alert!')) {
                    $pos = strpos($output, 'You should be able to get in by typing ');
                    if ($pos !== false) {
                        $ans1 = substr($output, $pos + 39, 9);
                    }
                    break;
                }
                for ($i = 0; $i < count(self::ITEMS); ++$i) {
                    if ((($bitmask >> $i) & 1) != 0) {
                        $game->stringInput('drop ' . self::ITEMS[$i]);
                        // @phpstan-ignore-next-line
                        if (self::SHOW_OUTPUT) {
                            echo 'drop ' . self::ITEMS[$i], PHP_EOL;
                        }
                    }
                }
            }
        }
        return [strval($ans1), '0'];
    }
}

// --------------------------------------------------------------------
/**
 * @codeCoverageIgnore
 */
final class AdventureSimulator
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

    public function stringOutput(): string
    {
        if (($this->idxOutput < 0) or ($this->idxOutput >= count($this->outputs))) {
            return '';
        }
        $message = '';
        for ($i = $this->idxOutput; $i < count($this->outputs); ++$i) {
            $message .= chr($this->outputs[$i]);
        }
        $this->idxOutput = count($this->outputs);
        return $message;
    }
}
