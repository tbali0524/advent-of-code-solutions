<?php

// phpcs:disable PSR1.Classes.ClassDeclaration.MultipleClasses

declare(strict_types=1);

namespace TBali\Aoc2023;

use TBali\Aoc\SolutionBase;

/**
 * AoC 2023 Day 20: Pulse Propagation.
 *
 * Part 1: What do you get if you multiply the total number of low pulses sent by the total number of high pulses sent?
 * Part 2: What is the fewest number of button presses required to deliver a single low pulse to the module named rx?
 *
 * Topics: simulation, cycle detection, priority queue
 *
 * @see https://adventofcode.com/2023/day/20
 */
final class Aoc2023Day20 extends SolutionBase
{
    public const YEAR = 2023;
    public const DAY = 20;
    public const TITLE = 'Pulse Propagation';
    public const SOLUTIONS = [919383692, 247702167614647];
    public const EXAMPLE_SOLUTIONS = [[32000000, 0], [11687500, 0]];

    private const MAX_STEPS_PART1 = 1000;

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
        $circuit = Circuit::fromInput($input);
        $circuit->simSteps(self::MAX_STEPS_PART1);
        $ans1 = $circuit->countLow * $circuit->countHigh;
        $circuit->init();
        $ans2 = $circuit->minButtonsToRx();
        return [strval($ans1), strval($ans2)];
    }
}

// --------------------------------------------------------------------
enum Pulse
{
    case OFF;
    case LOW;
    case HIGH;
}

// --------------------------------------------------------------------
/** @phpstan-consistent-constructor */
abstract class Module
{
    public string $name;
    /** @var array<string, bool> */
    public array $inputs = [];
    /** @var array<int, string> */
    public array $outputs = [];

    abstract public function hash(): string;

    abstract public function receive(string $input, Pulse $pulse): Pulse;

    /**
     * This gets called after $inputs is filled out.
     */
    public function init(): void
    {
    }

    public static function fromString(string $s): static
    {
        $a = explode(' -> ', $s);
        if (count($a) != 2) {
            throw new \Exception('Invalid input');
        }
        // @phpstan-ignore new.static
        $m = new static();
        $m->name = $a[0];
        $m->outputs = explode(', ', $a[1]);
        return $m;
    }
}

// --------------------------------------------------------------------
class FlipFlop extends Module
{
    public bool $state = false;

    #[\Override]
    public function init(): void
    {
        $this->state = false;
    }

    #[\Override]
    public function hash(): string
    {
        return $this->state ? '1' : '0';
    }

    #[\Override]
    public function receive(string $input, Pulse $pulse): Pulse
    {
        if ($pulse != Pulse::LOW) {
            return Pulse::OFF;
        }
        $this->state = !$this->state;
        return $this->state ? Pulse::HIGH : Pulse::LOW;
    }
}

// --------------------------------------------------------------------
class Conjunction extends Module
{
    /** @var array<string, Pulse> */
    public array $states = [];

    #[\Override]
    public function init(): void
    {
        $this->states = [];
        foreach (array_keys($this->inputs) as $input) {
            $this->states[$input] = Pulse::LOW;
        }
    }

    #[\Override]
    public function hash(): string
    {
        return implode(' ', array_map(
            static fn (Pulse $p): string => $p == Pulse::HIGH ? '1' : '0',
            $this->states,
        ));
    }

    #[\Override]
    public function receive(string $input, Pulse $pulse): Pulse
    {
        $this->states[$input] = $pulse;
        $countHigh = count(array_filter(
            $this->states,
            static fn (Pulse $p): bool => $p == Pulse::HIGH,
        ));
        return $countHigh == count($this->inputs) ? Pulse::LOW : Pulse::HIGH;
    }
}

// --------------------------------------------------------------------
class Broadcast extends Module
{
    #[\Override]
    public function hash(): string
    {
        return '0';
    }

    #[\Override]
    public function receive(string $input, Pulse $pulse): Pulse
    {
        return $pulse;
    }
}

// --------------------------------------------------------------------
final class Circuit
{
    public const BUTTON = 'button';
    public const BROADCASTER = 'broadcaster';
    public const RECEIVER = 'rx';

    /** @var array<string, Module> */
    public array $modules = [];
    public int $countLow = 0;
    public int $countHigh = 0;
    public string $finalModulePart2 = '';

    public function init(): void
    {
        foreach ($this->modules as $m) {
            $m->init();
        }
        $this->countLow = 0;
        $this->countHigh = 0;
    }

    public function hash(): string
    {
        return implode('|', array_map(
            static fn (Module $m): string => $m->name . ':' . $m->hash(),
            $this->modules,
        ));
    }

    public function simSteps(int $maxSteps): void
    {
        $visited = [];
        for ($step = 1; $step <= $maxSteps; ++$step) {
            $turn = 0;
            $pq = new MinPriorityQueueDay20();
            $pq->setExtractFlags(\SplPriorityQueue::EXTR_BOTH);
            $pq->insert([self::BUTTON, self::BROADCASTER, Pulse::LOW], $turn);
            while (!$pq->isEmpty()) {
                $item = $pq->extract();
                /** @phpstan-var array{priority: int, data: array{string, string, Pulse}} $item */
                [$from, $to, $pulse] = $item['data'];
                $turn = $item['priority'];
                if ($pulse == Pulse::LOW) {
                    ++$this->countLow;
                } elseif ($pulse == Pulse::HIGH) {
                    ++$this->countHigh;
                }
                if (!isset($this->modules[$to])) {
                    continue;
                }
                $nextPulse = $this->modules[$to]->receive($from, $pulse);
                if ($nextPulse == Pulse::OFF) {
                    continue;
                }
                foreach ($this->modules[$to]->outputs as $output) {
                    $pq->insert([$to, $output, $nextPulse], $turn + 1);
                }
            }
            $hash = $this->hash();
            if (!isset($visited[$hash])) {
                $visited[$hash] = [$step, $this->countLow, $this->countHigh];
                continue;
            }
            [$prevStep, $prevCountLow, $prevCountHigh] = $visited[$hash];
            $cycleLen = $step - $prevStep;
            $cycleCount = intdiv($maxSteps - $step, $cycleLen);
            $step += $cycleCount * $cycleLen;
            $this->countLow += $cycleCount * ($this->countLow - $prevCountLow);
            $this->countHigh += $cycleCount * ($this->countHigh - $prevCountHigh);
        }
    }

    /**
     * @codeCoverageIgnore
     */
    public function minButtonsToRx(): int
    {
        if ($this->finalModulePart2 == '') {
            return 0;
        }
        $ans = 0;
        $counters = [];
        foreach (array_keys($this->modules[$this->finalModulePart2]->inputs) as $name) {
            $counters[$name] = 0;
        }
        $step = 0;
        while (true) {
            ++$step;
            $turn = 0;
            $pq = new MinPriorityQueueDay20();
            $pq->setExtractFlags(\SplPriorityQueue::EXTR_BOTH);
            $pq->insert([self::BUTTON, self::BROADCASTER, Pulse::LOW], $turn);
            while (!$pq->isEmpty()) {
                $item = $pq->extract();
                /** @phpstan-var array{priority: int, data: array{string, string, Pulse}} $item */
                [$from, $to, $pulse] = $item['data'];
                $turn = $item['priority'];
                if (($to == self::RECEIVER) and ($pulse == Pulse::LOW)) {
                    // @codeCoverageIgnoreStart
                    return $step;
                    // @codeCoverageIgnoreEnd
                }
                if (!isset($this->modules[$to])) {
                    continue;
                }
                $nextPulse = $this->modules[$to]->receive($from, $pulse);
                if ($nextPulse == Pulse::OFF) {
                    continue;
                }
                if ($nextPulse == Pulse::HIGH) {
                    foreach (array_keys($counters) as $name) {
                        if (($counters[$name] == 0) and ($to == $name)) {
                            $counters[$name] = $step;
                        }
                    }
                }
                foreach ($this->modules[$to]->outputs as $output) {
                    $pq->insert([$to, $output, $nextPulse], $turn + 1);
                }
            }
            if (count(array_filter($counters, static fn ($x): bool => $x == 0)) == 0) {
                break;
            }
        }
        $ans = 1;
        foreach ($counters as $cycleLength) {
            $ans = self::lcm($ans, $cycleLength);
        }
        return $ans;
    }

    /**
     * @param array<int, string> $input The lines of the input, without LF
     */
    public static function fromInput(array $input): self
    {
        $circuit = new self();
        foreach ($input as $line) {
            if ($line[0] == '%') {
                $m = FlipFlop::fromString(substr($line, 1));
            } elseif ($line[0] == '&') {
                $m = Conjunction::fromString(substr($line, 1));
            } elseif (str_starts_with($line, self::BROADCASTER)) {
                $m = Broadcast::fromString($line);
            } else {
                throw new \Exception('Invalid input');
            }
            $circuit->modules[$m->name] = $m;
        }
        foreach ($circuit->modules as $m) {
            foreach ($m->outputs as $output) {
                if ($output == self::RECEIVER) {
                    // @codeCoverageIgnoreStart
                    $circuit->finalModulePart2 = $m->name;
                    // @codeCoverageIgnoreEnd
                }
                if (isset($circuit->modules[$output])) {
                    $circuit->modules[$output]->inputs[$m->name] = true;
                }
            }
        }
        $circuit->init();
        return $circuit;
    }

    /**
     * Greatest common divisor.
     *
     * @see https://en.wikipedia.org/wiki/Greatest_common_divisor
     *
     * @codeCoverageIgnore
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
     *
     * @codeCoverageIgnore
     */
    private static function lcm(int $a, int $b): int
    {
        return abs($a) * intdiv(abs($b), self::gcd($a, $b));
    }
}

// --------------------------------------------------------------------
/**
 * @phpstan-extends \SplPriorityQueue<int, array{string, string, Pulse}>
 */
final class MinPriorityQueueDay20 extends \SplPriorityQueue
{
    /**
     * @param int $a
     * @param int $b
     */
    public function compare($a, $b): int
    {
        return parent::compare($b, $a); // invert the order
    }
}
