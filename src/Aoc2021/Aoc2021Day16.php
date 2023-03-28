<?php

// phpcs:disable PSR1.Classes.ClassDeclaration.MultipleClasses

declare(strict_types=1);

namespace TBali\Aoc2021;

use TBali\Aoc\SolutionBase;

/**
 * AoC 2021 Day 16: Packet Decoder.
 *
 * Part 1: What do you get if you add up the version numbers in all packets?
 * Part 2: What do you get if you evaluate the expression represented by your hexadecimal-encoded BITS transmission?
 *
 * Topics: Parsing
 *
 * @see https://adventofcode.com/2021/day/16
 */
final class Aoc2021Day16 extends SolutionBase
{
    public const YEAR = 2021;
    public const DAY = 16;
    public const TITLE = 'Packet Decoder';
    public const SOLUTIONS = [953, 246225449979];
    public const EXAMPLE_SOLUTIONS = [
        [6, 0],
        [9, 0],
        [14, 0],
        [16, 0],
        [12, 0],
        [23, 0],
        [31, 0],
        [0, 3],
        [0, 54],
        [0, 7],
        [0, 9],
        [0, 1],
        [0, 1],
    ];

    private string $bits = '';
    private Packet $root;

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
        $this->bits = '';
        for ($i = 0; $i < strlen($input[0]); ++$i) {
            if (!str_contains('0123456789ABCDEF', strtoupper($input[0][$i]))) {
                throw new \Exception('Invalid input');
            }
            $bin = base_convert($input[0][$i], 16, 2);
            $this->bits .= str_pad($bin, 4, '0', STR_PAD_LEFT);
        }
        // ---------- Part 1 + 2
        [$this->root, $pos] = $this->parsePacket();
        $remaining = substr($this->bits, $pos);
        if (($remaining != 0) and ($remaining != str_repeat('0', strlen($remaining)))) {
            throw new \Exception('Invalid input');
        }
        $ans1 = $this->root->sumVersion();
        $ans2 = $this->root->evaluate();
        return [strval($ans1), strval($ans2)];
    }

    /**
     * @phpstan-return array{Packet, int}
     */
    public function parsePacket(int $pos = 0): array
    {
        $p = new Packet();
        if ($pos + Packet::MIN_PACKET_LEN > strlen($this->bits)) {
            throw new \Exception('Invalid input');
        }
        $p->version = intval(bindec(substr($this->bits, $pos, Packet::VERSION_BITS)));
        $pos += Packet::VERSION_BITS;
        $p->typeId = intval(bindec(substr($this->bits, $pos, Packet::TYPE_ID_BITS)));
        $pos += Packet::TYPE_ID_BITS;
        if ($p->typeId == Packet::TYPE_ID_LITERAL) {
            $bin = '';
            while (true) {
                if ($pos + Packet::DIGIT_BITS + 1 > strlen($this->bits)) {
                    throw new \Exception('Invalid input');
                }
                $bin .= substr($this->bits, $pos + 1, Packet::DIGIT_BITS);
                $pos += Packet::DIGIT_BITS + 1;
                if ($this->bits[$pos - Packet::DIGIT_BITS - 1] == '0') {
                    break;
                }
            }
            $p->value = intval(bindec($bin));
            return [$p, $pos];
        }
        $p->lengthTypeId = intval(bindec(substr($this->bits, $pos, Packet::LENGTH_TYPE_ID_BITS)));
        $pos += Packet::LENGTH_TYPE_ID_BITS;
        if ($p->lengthTypeId == 0) {
            if ($pos + Packet::SUB_LENGTH_BITS > strlen($this->bits)) {
                throw new \Exception('Invalid input');
            }
            $p->subLength = intval(bindec(substr($this->bits, $pos, Packet::SUB_LENGTH_BITS)));
            $pos += Packet::SUB_LENGTH_BITS;
            $end = $pos + $p->subLength;
            if ($end > strlen($this->bits)) {
                throw new \Exception('Invalid input');
            }
            while ($pos + Packet::MIN_PACKET_LEN <= $end) {
                [$subPacket, $pos] = $this->parsePacket($pos);
                $p->subPackets[] = $subPacket;
            }
            if (count($p->subPackets) == 0) {
                throw new \Exception('Invalid input');
            }
            return [$p, $pos];
        }
        if ($p->lengthTypeId == 1) {
            if ($pos + Packet::SUB_COUNT_BITS > strlen($this->bits)) {
                throw new \Exception('Invalid input');
            }
            $p->subCount = intval(bindec(substr($this->bits, $pos, Packet::SUB_COUNT_BITS)));
            $pos += Packet::SUB_COUNT_BITS;
            for ($i = 0; $i < $p->subCount; ++$i) {
                [$subPacket, $pos] = $this->parsePacket($pos);
                $p->subPackets[] = $subPacket;
            }
            if (count($p->subPackets) == 0) {
                throw new \Exception('Invalid input');
            }
            return [$p, $pos];
        }
        throw new \Exception('Invalid input');
    }
}

// --------------------------------------------------------------------
final class Packet
{
    public const VERSION_BITS = 3;
    public const TYPE_ID_BITS = 3;
    public const TYPE_ID_LITERAL = 4;
    public const DIGIT_BITS = 4;
    public const LENGTH_TYPE_ID_BITS = 1;
    public const SUB_LENGTH_BITS = 15;
    public const SUB_COUNT_BITS = 11;
    public const MIN_PACKET_LEN = self::VERSION_BITS + self::TYPE_ID_BITS + self::DIGIT_BITS + 1;

    public int $version = 0;
    public int $typeId = 0;
    public int $value = 0;
    public int $lengthTypeId = 0;
    public int $subLength = 0;
    public int $subCount = 0;
    /** @var array<int, Packet> */
    public array $subPackets = [];

    public function sumVersion(): int
    {
        $ans = $this->version;
        foreach ($this->subPackets as $p) {
            $ans += $p->sumVersion();
        }
        return $ans;
    }

    public function evaluate(): int
    {
        $values = array_map(fn (Packet $p) => $p->evaluate(), $this->subPackets);
        return match ($this->typeId) {
            0 => intval(array_sum($values)),
            1 => intval(array_product($values)),
            2 => intval(min($values)),
            3 => intval(max($values)),
            self::TYPE_ID_LITERAL => $this->value,
            5 => count($this->subPackets) == 2
                    ? ($values[0] > $values[1] ? 1 : 0)
                    : throw new \Exception('Invalid input'),
            6 => count($this->subPackets) == 2
                    ? ($values[0] < $values[1] ? 1 : 0)
                    : throw new \Exception('Invalid input'),
            7 => count($this->subPackets) == 2
                    ? ($values[0] == $values[1] ? 1 : 0)
                    : throw new \Exception('Invalid input'),
            default => throw new \Exception('Invalid input'),
        };
    }
}
