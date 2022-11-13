<?php

// phpcs:disable PSR1.Classes.ClassDeclaration.MultipleClasses

declare(strict_types=1);

namespace TBali\Aoc2016;

use TBali\Aoc\SolutionBase;

/**
 * AoC 2016 Day 10: Balance Bot.
 *
 * Part 1: What is the number of the bot that is responsible for comparing
 *         value-61 microchips with value-17 microchips?
 * Part 2: What do you get if you multiply together the values of one chip in each of outputs 0, 1, and 2?
 *
 * Topics: bot simulation
 *
 * @see https://adventofcode.com/2016/day/10
 */
final class Aoc2016Day10 extends SolutionBase
{
    public const YEAR = 2016;
    public const DAY = 10;
    public const TITLE = 'Balance Bot';
    public const SOLUTIONS = [181, 12567];
    public const EXAMPLE_SOLUTIONS = [[2, 30], [0, 0]];

    /** @var array<int, Bot> */
    private array $bots;
    /** @var array<int, array<int, int>> */
    private array $outputs;

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
        $this->parseInput($input);
        // ---------- Part 1 + 2
        $ans1 = 0;
        while (true) {
            $activeBots = array_filter($this->bots, fn (Bot $bot): bool => count($bot->values) == 2);
            if (count($activeBots) == 0) {
                break;
            }
            $bot = current($activeBots);
            $low = intval(min($bot->values));
            $high = intval(max($bot->values));
            // detect example input
            if ((count($input) == 6) and ($low == 2) and ($high == 5)) {
                $ans1 = $bot->id;
            }
            if (($low == 17) and ($high == 61)) {
                $ans1 = $bot->id;
            }
            if ($bot->lowToOutput) {
                $this->outputs[$bot->lowTarget][] = $low;
            } else {
                $this->bots[$bot->lowTarget]->values[] = $low;
            }
            if ($bot->highToOutput) {
                $this->outputs[$bot->highTarget][] = $high;
            } else {
                $this->bots[$bot->highTarget]->values[] = $high;
            }
            $bot->values = [];
        }
        // ---------- Part 2
        $ans2 = array_product($this->outputs[0] ?? [])
            * array_product($this->outputs[1] ?? [])
            * array_product($this->outputs[2] ?? []);
        return [strval($ans1), strval($ans2)];
    }

    /**
     * @param array<int, string> $input
     */
    private function parseInput(array $input): void
    {
        $this->bots = [];
        $this->outputs = [];
        foreach ($input as $line) {
            $a = explode(' ', $line);
            if ($a[0] == 'value') {
                if ((count($a) != 6) or !str_contains($line, ' goes to bot ')) {
                    throw new \Exception('Invalid input');
                }
                $bot = $this->addOrGetBot(intval($a[5]));
                $bot->values[] = intval($a[1]);
                continue;
            }
            if ($a[0] == 'bot') {
                if (
                    (count($a) != 12)
                    or !str_contains($line, ' gives low to ')
                    or !str_contains($line, ' and high to ')
                ) {
                    throw new \Exception('Invalid input');
                }
                $bot = $this->addOrGetBot(intval($a[1]));
                $bot->lowTarget = intval($a[6]);
                $bot->highTarget = intval($a[11]);
                $bot->lowToOutput = ($a[5] == 'output');
                $bot->highToOutput = ($a[10] == 'output');
                if ($bot->lowToOutput) {
                    $this->outputs[$bot->lowTarget] = [];
                }
                if ($bot->highToOutput) {
                    $this->outputs[$bot->highTarget] = [];
                }
                continue;
            }
            throw new \Exception('Invalid input');
        }
    }

    private function addOrGetBot(int $id): Bot
    {
        $this->bots[$id] ??= new Bot($id);
        return $this->bots[$id];
    }
}

// --------------------------------------------------------------------
final class Bot
{
    public int $id;
    /** @var array<int, int> */
    public array $values = [];
    public int $lowTarget = 0;
    public int $highTarget = 0;
    public bool $lowToOutput = false;
    public bool $highToOutput = false;

    public function __construct(int $id)
    {
        $this->id = $id;
    }
}
