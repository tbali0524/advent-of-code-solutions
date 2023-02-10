<?php

// phpcs:disable PSR1.Classes.ClassDeclaration.MultipleClasses

declare(strict_types=1);

namespace TBali\Aoc2020;

use TBali\Aoc\SolutionBase;

/**
 * AoC 2020 Day 22: Crab Combat.
 *
 * Part 1: Play the small crab in a game of Combat using the two decks you just dealt.
 *         What is the winning player's score?
 * Part 2: Defend your honor as Raft Captain by playing the small crab in a game of Recursive Combat
 *         using the same two decks as before. What is the winning player's score?
 *
 * Topics: game simulation, recursion
 *
 * @see https://adventofcode.com/2020/day/22
 */
final class Aoc2020Day22 extends SolutionBase
{
    public const YEAR = 2020;
    public const DAY = 22;
    public const TITLE = 'Crab Combat';
    public const SOLUTIONS = [34566, 31854];
    public const EXAMPLE_SOLUTIONS = [[306, 291], [105, 105]];

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
        $players = $this->parseInput($input);
        $playersPart2 = [clone $players[0], clone $players[1]];
        // ---------- Part 1
        $game = new SpaceCardGame($players);
        $winner = $game->battle();
        $ans1 = $game->getScore($winner);
        // ---------- Part 2
        $game = new SpaceCardRecursiveGame($playersPart2);
        if ($playersPart2[0]->getCountCards() > 1000) {
            return [strval($ans1), strval(0)];
        }
        $winner = $game->battle();
        $ans2 = $game->getScore($winner);
        return [strval($ans1), strval($ans2)];
    }

    /**
     * @param array<int, string> $input
     *
     * @return array<int, SpaceCardDeck>
     *
     * @phpstan-return array{SpaceCardDeck, SpaceCardDeck}
     */
    private function parseInput(array $input): array
    {
        if (count($input) < 5) {
            throw new \Exception('Invalid input');
        }
        $ans = [];
        $idxLine = 0;
        while ($idxLine < count($input)) {
            $line = $input[$idxLine];
            if (!str_starts_with($line, 'Player ') or ($line[strlen($line) - 1] != ':') or (strlen($line) < 9)) {
                // @codeCoverageIgnoreStart
                throw new \Exception('Invalid input');
                // @codeCoverageIgnoreEnd
            }
            $idxPlayer = intval(substr($line, 7, strlen($line) - 8)) - 1; // 0 or 1
            if (($idxPlayer != 0) and ($idxPlayer != 1)) {
                // @codeCoverageIgnoreStart
                throw new \Exception('Invalid input');
                // @codeCoverageIgnoreEnd
            }
            ++$idxLine;
            $cards = [];
            while (($idxLine < count($input)) and ($input[$idxLine] != '')) {
                $cards[] = intval($input[$idxLine]);
                ++$idxLine;
            }
            $ans[$idxPlayer] = new SpaceCardDeck($idxPlayer, array_reverse($cards));
            while (($idxLine < count($input)) and ($input[$idxLine] == '')) {
                ++$idxLine;
            }
        }
        if (count($ans) != 2) {
            // @codeCoverageIgnoreStart
            throw new \Exception('Invalid input');
            // @codeCoverageIgnoreEnd
        }
        // @phpstan-ignore-next-line
        return $ans;
    }
}

// --------------------------------------------------------------------
final class SpaceCardDeck
{
    /** @param array<int, int> $cards */
    public function __construct(
        private readonly int $id = 0,
        /** cards are stored in bottom-to-top order */
        private array $cards = []
    ) {
    }

    public function getCountCards(): int
    {
        return count($this->cards);
    }

    public function getScore(): int
    {
        $ans = 0;
        foreach ($this->cards as $idx => $value) {
            $ans += ($idx + 1) * $value;
        }
        return $ans;
    }

    public function getHash(): string
    {
        return $this->id . ':' . implode(',', $this->cards);
        // return md5($this->id . json_encode($this->cards));
    }

    public function drawFromTop(): int
    {
        if (count($this->cards) == 0) {
            throw new \UnderflowException();
        }
        return array_pop($this->cards);
    }

    /** @param array<int, int> $cards */
    public function addToBottom(array $cards): void
    {
        array_unshift($this->cards, ...$cards);
    }

    public function copyDeck(int $countCards): self
    {
        if ($countCards <= 0) {
            throw new \RangeException();
        }
        return new self($this->id, array_slice($this->cards, -$countCards));
    }
}

// --------------------------------------------------------------------
class SpaceCardGame
{
    /** @var array<string, true> */
    private array $memo;

    /**
     * @param array<int, SpaceCardDeck> $players
     *
     * @phpstan-param array{SpaceCardDeck, SpaceCardDeck} $players
     */
    public function __construct(
        protected array $players
    ) {
        $this->memo = [];
    }

    public function getScore(int $idxPlayer): int
    {
        if (($idxPlayer != 0) and ($idxPlayer != 1)) {
            throw new \RangeException();
        }
        return $this->players[$idxPlayer]->getScore();
    }

    /** returns the id of the winner */
    public function battle(): int
    {
        while (true) {
            if ($this->players[0]->getCountCards() == 0) {
                return 1;
            }
            if ($this->players[1]->getCountCards() == 0) {
                return 0;
            }
            $hash = $this->players[0]->getHash() . '-' . $this->players[1]->getHash();
            if (isset($this->memo[$hash])) {
                return 0;
            }
            $this->memo[$hash] = true;
            $drawnCards = [
                $this->players[0]->drawFromTop(),
                $this->players[1]->drawFromTop(),
            ];
            $winner = $this->getTurnResult($drawnCards);
            if ($winner < 0) {
                continue;
            }
            $this->players[$winner]->addToBottom([$drawnCards[1 - $winner], $drawnCards[$winner]]);
        }
    }

    /**
     * @param array<int, int> $drawnCards
     *
     * @phpstan-param array{int, int} $drawnCards
     */
    protected function getTurnResult(array $drawnCards): int
    {
        if ($drawnCards[0] > $drawnCards[1]) {
            return 0;
        }
        if ($drawnCards[0] < $drawnCards[1]) {
            return 1;
        }
        return -1;
    }
}

// --------------------------------------------------------------------
class SpaceCardRecursiveGame extends SpaceCardGame
{
    /**
     * @param array<int, int> $drawnCards
     *
     * @phpstan-param array{int, int} $drawnCards
     */
    public function getTurnResult(array $drawnCards): int
    {
        [$p0, $p1] = $this->players;
        $countCards0 = $this->players[0]->getCountCards();
        $countCards1 = $this->players[1]->getCountCards();
        if (($drawnCards[0] <= $countCards0) and ($drawnCards[1] <= $countCards1)) {
            $game = new self([
                $this->players[0]->copyDeck($drawnCards[0]),
                $this->players[1]->copyDeck($drawnCards[1]),
            ]);
            return $game->battle();
        }
        if ($drawnCards[0] > $drawnCards[1]) {
            return 0;
        }
        if ($drawnCards[0] < $drawnCards[1]) {
            return 1;
        }
        return -1;
    }
}
