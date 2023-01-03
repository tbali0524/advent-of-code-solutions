<?php

// phpcs:disable PSR1.Classes.ClassDeclaration.MultipleClasses

declare(strict_types=1);

namespace TBali\Aoc2017;

use TBali\Aoc\SolutionBase;

/**
 * AoC 2017 Day 20: Particle Swarm.
 *
 * Part 1: Which particle will stay closest to position <0,0,0> in the long term?
 * Part 2: How many particles are left after all collisions are resolved?
 *
 * Topics: simulation
 *
 * @see https://adventofcode.com/2017/day/20
 */
final class Aoc2017Day20 extends SolutionBase
{
    public const YEAR = 2017;
    public const DAY = 20;
    public const TITLE = 'Particle Swarm';
    public const SOLUTIONS = ['p243', 648];
    public const EXAMPLE_SOLUTIONS = [['p0', 2], ['p2', 1]];

    private const DEBUG = false;

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
        /** @var array<int, Particle> */
        $particles = array_map(
            fn (int $id, string $line): Particle => Particle::fromString($id, $line),
            range(0, count($input) - 1),
            $input
        );
        // ---------- Part 1
        usort($particles, function (Particle $particle1, Particle $particle2): int {
            $ans = $particle1->a->manhattan() <=> $particle2->a->manhattan();
            if ($ans != 0) {
                return $ans;
            }
            $ans = $particle1->v->manhattan() <=> $particle2->v->manhattan();
            if ($ans != 0) {
                return $ans;
            }
            return $particle1->p->manhattan() <=> $particle2->p->manhattan();
        });
        $ans1 = $particles[0]->id;
        // ---------- Part 2
        $ans2 = count($particles);
        $lastColTurn = 0;
        usort($particles, fn (Particle $particle1, Particle $particle2): int => $particle1->id <=> $particle2->id);
        $t = 0;
        while (true) {
            foreach ($particles as $particle) {
                $particle->tick();
            }
            ++$t;
            $collisions = [];
            $visited = [];
            foreach ($particles as $particle) {
                $hash = strval($particle->p->x) . ' ' . strval($particle->p->y) . ' ' . strval($particle->p->z);
                if (!isset($visited[$hash])) {
                    $visited[$hash] = $particle->id;
                    continue;
                }
                $collisions[$visited[$hash]] = true;
                $collisions[$particle->id] = true;
            }
            if (count($collisions) > 0) {
                // @phpstan-ignore-next-line
                if (self::DEBUG) {
                    // @codeCoverageIgnoreStart
                    echo '-- T = ' . $t . ':  remaining particles = ' . count($particles) . PHP_EOL;
                    // echo implode('', array_map(fn (Particle $p): string => $p->toString(), $particles));
                    echo ' collisions: #' . implode(', #', array_keys($collisions)) . PHP_EOL;
                    // @codeCoverageIgnoreEnd
                }
                $ans2 -= count($collisions);
                foreach (array_keys($collisions) as $idx) {
                    unset($particles[$idx]);
                }
                $lastColTurn = $t;
            }
            if (($t - $lastColTurn > 50) or (count($particles) < 2)) {
                break;
            }
        }
        // extra p prefix added, because example 1 part 1 solution is 0.
        return ['p' . strval($ans1), strval($ans2)];
    }
}

// --------------------------------------------------------------------
final class Vector3D
{
    public function __construct(
        public int $x,
        public int $y,
        public int $z,
    ) {
    }

    public function manhattan(): int
    {
        return abs($this->x) + abs($this->y) + abs($this->z);
    }
}

// --------------------------------------------------------------------
final class Particle
{
    public function __construct(
        public readonly int $id,
        public Vector3D $p,
        public Vector3D $v,
        public Vector3D $a,
    ) {
    }

    public function tick(): void
    {
        $this->v->x += $this->a->x;
        $this->v->y += $this->a->y;
        $this->v->z += $this->a->z;
        $this->p->x += $this->v->x;
        $this->p->y += $this->v->y;
        $this->p->z += $this->v->z;
    }

    /**
     * @codeCoverageIgnore
     */
    public function toString(): string
    {
        return '#' . $this->id
            . ': p=<' . $this->p->x
            . ',' . $this->p->y
            . ',' . $this->p->z
            . '>, v=<' . $this->v->x
            . ',' . $this->v->y
            . ',' . $this->v->z
            . '>, a=<' . $this->a->x
            . ',' . $this->a->y
            . ',' . $this->a->z . '>' . PHP_EOL;
    }

    public static function fromString(int $id, string $s): self
    {
        $count = sscanf($s, 'p=<%d,%d,%d>, v=<%d,%d,%d>, a=<%d,%d,%d>', $px, $py, $pz, $vx, $vy, $vz, $ax, $ay, $az);
        if ($count != 9) {
            throw new \Exception('Invalid input');
        }
        return new self(
            $id,
            new Vector3D(intval($px), intval($py), intval($pz)),
            new Vector3D(intval($vx), intval($vy), intval($vz)),
            new Vector3D(intval($ax), intval($ay), intval($az)),
        );
    }
}
