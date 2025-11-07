<?php

// phpcs:disable PSR1.Classes.ClassDeclaration.MultipleClasses

declare(strict_types=1);

namespace TBali\Aoc2019;

use TBali\Aoc\SolutionBase;

/**
 * AoC 2019 Day 22: Slam Shuffle.
 *
 * Part 1: After shuffling your factory order deck of 10007 cards, what is the position of card 2019?
 * Part 2: After shuffling your new, giant, factory order deck that many times,
 *         what number is on the card that ends up in position 2020?
 *
 * Topics: card deck simulation, modular arithmetics, LCF (linear congruential function)
 *
 * Note: Part 2 solution is based on https://codeforces.com/blog/entry/72593
 *
 * @see https://adventofcode.com/2019/day/22
 */
final class Aoc2019Day22 extends SolutionBase
{
    public const YEAR = 2019;
    public const DAY = 22;
    public const TITLE = 'Slam Shuffle';
    public const SOLUTIONS = [8502, 41685581334351];
    public const EXAMPLE_SOLUTIONS = [[369258147, 0], [3074185296, 0], [6307418529, 0], [9258147036, 0]];

    public const MAX_CARDS_EXAMPLES = 10;
    public const MAX_CARDS_PART1 = 10_007;
    public const MAX_CARDS_PART2 = 119315717514047;
    public const MAX_SHUFFLES_PART2 = 101741582076661;
    public const CARD_TO_SEARCH_PART1 = 2019;
    public const CARD_POSITION_PART2 = 2020;

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
        $ans1 = 0;
        $isExample = count($input) <= 10;
        $maxCards = $isExample ? self::MAX_CARDS_EXAMPLES : self::MAX_CARDS_PART1;
        $deck = new Deck($maxCards);
        foreach ($input as $line) {
            $deck->shuffle($line);
        }
        if ($isExample) {
            $ans1 = intval(implode('', $deck->cards));
        } else {
            $ans1 = intval(array_search(self::CARD_TO_SEARCH_PART1, $deck->cards, true));
        }
        if ($isExample) {
            return [strval($ans1), '0'];
        }
        // ---------- Part 2
        $lcfs = [];
        foreach ($input as $line) {
            $lcfs[] = LCF::fromInput($line, self::MAX_CARDS_PART2);
        }
        $f = $lcfs[0];
        for ($i = 1; $i < count($lcfs); ++$i) {
            $f = $lcfs[$i]->compose($f);
        }
        $powA = Modulo::power($f->a, self::MAX_SHUFFLES_PART2, self::MAX_CARDS_PART2);
        $powBnom = Modulo::multiply($f->b, Modulo::subtract(1, $powA, self::MAX_CARDS_PART2), self::MAX_CARDS_PART2);
        $powBden = Modulo::subtract(1, $f->a, self::MAX_CARDS_PART2);
        $powB = Modulo::divide($powBnom, $powBden, self::MAX_CARDS_PART2);
        $fPower = new LCF($powA, $powB, self::MAX_CARDS_PART2);
        $fPowerInv = new LCF(
            Modulo::divide(1, $fPower->a, self::MAX_CARDS_PART2),
            Modulo::divide(-$fPower->b, $fPower->a, self::MAX_CARDS_PART2),
            self::MAX_CARDS_PART2,
        );
        $ans2 = $fPowerInv->apply(self::CARD_POSITION_PART2);
        return [strval($ans1), strval($ans2)];
    }
}

// --------------------------------------------------------------------
final class Deck
{
    /** @var array<int, int> */
    public array $cards;

    public function __construct(
        public readonly int $maxCards,
    ) {
        $this->cards = range(0, $this->maxCards - 1);
    }

    public function dealIntoNew(): void
    {
        $this->cards = array_reverse($this->cards);
    }

    public function cut(int $n): void
    {
        // works also for negative $n
        $this->cards = array_merge(array_slice($this->cards, $n), array_slice($this->cards, 0, $n));
    }

    public function dealWithIncrement(int $n): void
    {
        $newCards = array_fill(0, $this->maxCards, 0);
        $pos = 0;
        for ($i = 0; $i < $this->maxCards; ++$i) {
            $newCards[$pos] = $this->cards[$i];
            $pos = ($pos + $n) % $this->maxCards;
        }
        $this->cards = $newCards;
    }

    public function shuffle(string $command): void
    {
        if ($command == 'deal into new stack') {
            $this->dealIntoNew();
            return;
        }
        if (str_starts_with($command, 'deal with increment ')) {
            $n = intval(substr($command, 20));
            $this->dealWithIncrement($n);
            return;
        }
        if (str_starts_with($command, 'cut ')) {
            $n = intval(substr($command, 4));
            $this->cut($n);
            return;
        }
        throw new \Exception('Invalid input');
    }

    /**
     * @codeCoverageIgnore
     */
    public function printDeck(): void
    {
        echo implode(' ', $this->cards), PHP_EOL;
    }
}

// --------------------------------------------------------------------
/**
 * Modular arithmethic functions.
 *
 * returning result in range: 0 <= result < modulus, trying to avoid overflow even with inputs near 2^64
 */
class Modulo
{
    /**
     * @codeCoverageIgnore
     */
    public static function limit(int $a, int $modulus): int
    {
        return $a < 0 ? $a % $modulus + $modulus : ($a < $modulus ? $a : $a % $modulus);
    }

    public static function add(int $a, int $b, int $modulus): int
    {
        $a = $a < 0 ? $a % $modulus + $modulus : ($a < $modulus ? $a : $a % $modulus);
        $b = $b < 0 ? $b % $modulus + $modulus : ($b < $modulus ? $b : $b % $modulus);
        $ans = $a + $b;
        return $ans < $modulus ? $ans : $ans - $modulus;
    }

    public static function subtract(int $a, int $b, int $modulus): int
    {
        $a = $a < 0 ? $a % $modulus + $modulus : ($a < $modulus ? $a : $a % $modulus);
        $b = $b < 0 ? $b % $modulus + $modulus : ($b < $modulus ? $b : $b % $modulus);
        $ans = $a - $b;
        return $ans >= 0 ? $ans : $ans + $modulus;
    }

    public static function multiply(int $a, int $b, int $modulus): int
    {
        $a = $a < 0 ? $a % $modulus + $modulus : ($a < $modulus ? $a : $a % $modulus);
        $b = $b < 0 ? $b % $modulus + $modulus : ($b < $modulus ? $b : $b % $modulus);
        $ans = 0;
        for ($i = 0; $i < 63; ++$i) {
            if ((($b >> $i) & 1) != 0) {
                $ans = ($ans + $a) % $modulus;
            }
            $a = ($a + $a) % $modulus;
        }
        return $ans;
    }

    public static function divide(int $a, int $b, int $modulus): int
    {
        $a = $a < 0 ? $a % $modulus + $modulus : ($a < $modulus ? $a : $a % $modulus);
        $inv = self::inverse($b, $modulus);
        if ($inv == -1) {
            // @codeCoverageIgnoreStart
            throw new \ArithmeticError('ERROR: Division undefined');
            // @codeCoverageIgnoreEnd
        }
        return self::multiply($inv, $a, $modulus);
    }

    public static function inverse(int $a, int $modulus): int
    {
        $a = $a < 0 ? $a % $modulus + $modulus : ($a < $modulus ? $a : $a % $modulus);
        $x = 0;
        $y = 0;
        $g = self::gcdExtended($a, $modulus, $x, $y);
        if ($g != 1) {
            // @codeCoverageIgnoreStart
            return -1;
            // @codeCoverageIgnoreEnd
        }
        return $x < 0 ? $x % $modulus + $modulus : ($x < $modulus ? $x : $x % $modulus);
    }

    // Extended Euclidean Algorithm - to find modular inverse
    public static function gcdExtended(int $a, int $b, int &$x, int &$y): int
    {
        if ($a == 0) {
            $x = 0;
            $y = 1;
            return $b;
        }
        $x1 = 0;
        $y1 = 0;
        $gcd = self::gcdExtended($b % $a, $a, $x1, $y1);
        $x = $y1 - intdiv($b, $a) * $x1;
        $y = $x1;
        return $gcd;
    }

    public static function power(int $a, int $b, int $modulus): int
    {
        if ($modulus == 1) {
            // @codeCoverageIgnoreStart
            return 0;
            // @codeCoverageIgnoreEnd
        }
        $ans = 1;
        $a = $a < 0 ? $a % $modulus + $modulus : ($a < $modulus ? $a : $a % $modulus);
        while ($b != 0) {
            if (($b & 1) != 0) {
                $ans = self::multiply($ans, $a, $modulus);
            }
            $b >>= 1;
            $a = self::multiply($a, $a, $modulus);
        }
        return $ans;
    }
}

// --------------------------------------------------------------------
/**
 * Linear congruential function.
 *
 * f(x)=ax+b mod m
 */
class LCF
{
    final public function __construct(
        public readonly int $a,
        public readonly int $b,
        public readonly int $modulus,
    ) {
    }

    public function compose(self $inner): static
    {
        if ($this->modulus != $inner->modulus) {
            // @codeCoverageIgnoreStart
            throw new \Exception('Composing LCFs must have same modulus');
            // @codeCoverageIgnoreEnd
        }
        return new static(
            Modulo::multiply($inner->a, $this->a, $this->modulus),
            Modulo::add(Modulo::multiply($inner->b, $this->a, $this->modulus), $this->b, $this->modulus),
            $this->modulus,
        );
    }

    public function apply(int $x): int
    {
        return Modulo::add(Modulo::multiply($this->a, $x, $this->modulus), $this->b, $this->modulus);
    }

    public static function fromInput(string $command, int $modulus): static
    {
        if ($command == 'deal into new stack') {
            return new static(-1, -1, $modulus);
        }
        if (str_starts_with($command, 'deal with increment ')) {
            $n = intval(substr($command, 20));
            return new static($n, 0, $modulus);
        }
        if (str_starts_with($command, 'cut ')) {
            $n = intval(substr($command, 4));
            return new static(1, $modulus - $n, $modulus);
        }
        // @codeCoverageIgnoreStart
        throw new \Exception('Invalid input');
        // @codeCoverageIgnoreEnd
    }
}
