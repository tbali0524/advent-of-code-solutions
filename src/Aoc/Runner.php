<?php

/**
 * Advent of Code - solution runner class.
 */

declare(strict_types=1);

namespace TBali\Aoc;

class Runner
{
    public int $year;
    public int $day;
    public bool $isOk;

    public const MIN_YEAR = 2015;
    public const MAX_YEAR = 2022;
    public const MIN_DAYS = 1;
    public const MAX_DAYS = 25;

    public const TO_SKIP = [
        2015 => [20, 24],
    ];

    private const ANSI_RED = "\e[1;37;41m";
    private const ANSI_GREEN = "\e[1;37;42m";
    private const ANSI_RESET = "\e[0m";
    private const ERROR_TAG = self::ANSI_RED . '[ERROR]' . self::ANSI_RESET . ' ';

    /** @param string[] $args (the PHP $argv of the script) */
    final public function __construct(array $args)
    {
        echo 'AoC v1.0 - batch PHP solution runner for Advent of Code, (c) 2022 by TBali' . PHP_EOL . PHP_EOL;
        [$this->year, $this->day] = $this->processArgs($args);
        $this->isOk = true;
    }

    /**
     * @param string[] $args (the PHP $argv of the script)
     *
     * @return array{int, int} year and day, -1 if not provided
     */
    final public function processArgs(array $args): array
    {
        $errorMsg = self::ERROR_TAG . 'Invalid command line arguments' . PHP_EOL
            . 'Usage:  php src/aoc.php [year] [day]' . PHP_EOL;
        if (count($args) > 3) {
            echo $errorMsg;
            exit(1);
        }
        if (count($args) == 3) {
            $day = intval(strtolower($args[2]));
            if (($day < self::MIN_DAYS) or ($day > self::MAX_DAYS)) {
                echo $errorMsg;
                exit(1);
            }
        } else {
            $day = -1;
        }
        if (count($args) >= 2) {
            $year = intval(strtolower($args[1]));
            if (($year < self::MIN_YEAR) or ($year > self::MAX_YEAR)) {
                echo $errorMsg;
                exit(1);
            }
        } else {
            $year = -1;
        }
        return [$year, $day];
    }

    final public function runSingle(int $year, int $day): void
    {
        $className = 'Aoc' . $year . 'Day' . str_pad(strval($day), 2, '0', STR_PAD_LEFT);
        $srcFileName = 'src/Aoc' . $year . '/' . $className . '.php';
        if (!file_exists($srcFileName)) {
            echo self::ERROR_TAG . 'Cannot find solution source file: ' . $srcFileName . PHP_EOL;
            $this->isOk = false;
            return;
        }
        $fullClassName = 'TBali\\Aoc' . $year . '\\' . $className;
        /** @var Solution */
        $solution = new $fullClassName();
        $success = $solution->run();
        if (!$success) {
            $this->isOk = false;
        }
    }

    final public function run(): void
    {
        $startTime = hrtime(true);
        if (($this->year >= 0) and ($this->day >= 0)) {
            $this->runSingle($this->year, $this->day);
            return;
        }
        $countRuns = 0;
        for ($year = self::MIN_YEAR; $year <= self::MAX_YEAR; ++$year) {
            if (($this->year >= 0) and ($year != $this->year)) {
                continue;
            }
            echo '======= ' . $year . ' ===========================' . PHP_EOL;
            for ($day = 1; $day <= self::MAX_DAYS; ++$day) {
                if (in_array($day, self::TO_SKIP[$year] ?? [])) {
                    continue;
                }
                $className = 'Aoc' . $year . 'Day' . str_pad(strval($day), 2, '0', STR_PAD_LEFT);
                $srcFileName = 'src/Aoc' . $year . '/' . $className . '.php';
                if (!file_exists($srcFileName)) {
                    continue;
                }
                $fullClassName = 'TBali\\Aoc' . $year . '\\' . $className;
                /** @var Solution */
                $solution = new $fullClassName();
                $success = $solution->run();
                if ($success) {
                    ++$countRuns;
                } else {
                    $this->isOk = false;
                }
            }
        }
        $spentTime = number_format((hrtime(true) - $startTime) / 1000_000_000, 4, '.', '');
        if ($countRuns > 1) {
            echo '======= Total: ' . $countRuns . ' solutions [time: ' . $spentTime . ' sec]' . PHP_EOL;
        }
        if ($this->isOk) {
            echo PHP_EOL . self::ANSI_GREEN . '[ OK ] All tests passed.' . self::ANSI_RESET . PHP_EOL;
        } else {
            echo PHP_EOL . self::ANSI_RED . '[ERROR] There were some unsuccessful tests. ' . self::ANSI_RESET . PHP_EOL;
        }
    }
}
