<?php

declare(strict_types=1);

namespace TBali\Aoc;

/**
 * Advent of Code solutions batch runner CLI.
 *
 * @author Bálint Tóth
 *
 * @codeCoverageIgnore
 */
final class AocRunner
{
    /** @var int */
    public const MIN_YEAR = 2015;
    /** @var int */
    public const MAX_YEAR = 2022;
    /** @var int */
    public const MIN_DAYS = 1;
    /** @var int */
    public const MAX_DAYS = 25;

    /**
     * What puzzles to skip, even if source file exists. [year => [day]].
     *
     * These solutions are quite slow, over 10s.
     *
     * @var array<int, array<int, int>>
     */
    public const TO_SKIP = [
        2016 => [5, 11, 14],
        2018 => [23],
        2019 => [18, 19, 20, 21, 22, 23, 24, 25],
        2021 => [11, 18, 19, 22, 23],
        2022 => [19, 24],
    ];

    /**
     * Available script interpreters. [id => [commandline, extension]].
     *
     * @phpstan-var array<string, array{string, string}>
     */
    public const LANGUAGES = [
        'dart' => ['dart', 'dart'],
        'f#' => ['dotnet fsi', 'fsx'],
        'go' => ['go run', 'go'],
        'groovy' => ['groovy', 'groovy'],
        'java' => ['java', 'java'],
        'javascript' => ['node', 'js'],
        'lua' => ['lua', 'lua'],
        'perl' => ['perl', 'pl'],
        'php' => ['php', 'php'],
        'python' => ['python', 'py'],
        'ruby' => ['ruby', 'rb'],
        'scala' => ['scala', 'scala'],
    ];

    /** @var string */
    private const ERROR_TAG = Tags::ANSI_RED . '[ERROR]' . Tags::ANSI_RESET . ' ';

    public int $year = -1;
    public int $day = -1;
    public bool $runAsScripts = false;
    public bool $runAllLanguages = false;
    public string $language = '';
    public bool $isOk = true;

    /**
     * @param array<int, string> $args The PHP $argv of the invoking script (CLI args are from index 1)
     */
    public function __construct(array $args)
    {
        echo 'Advent of Code - batch solution runner, (c) 2023 by TBali' . PHP_EOL . PHP_EOL;
        $this->processArgs($args);
        $this->isOk = true;
    }

    /**
     * Runs all matching solutions based on $this->year, $this->day (-1 meaning 'all').
     */
    public function run(): void
    {
        $startTime = hrtime(true);
        $maxMemory = 0;
        if (($this->year >= 0) and ($this->day >= 0) and !$this->runAllLanguages) {
            if ($this->runAsScripts) {
                $this->runSingleAsScript($this->year, $this->day);
            } else {
                $this->runSingleAsClass($this->year, $this->day);
            }
            echo PHP_EOL;
            return;
        }
        if ($this->runAllLanguages) {
            $languages = array_keys(self::LANGUAGES);
        } else {
            $languages = [$this->language];
        }
        $countTotal = 0;
        $countFails = 0;
        $countSkipped = 0;
        $lastLanguage = '';
        foreach ($languages as $language) {
            $this->language = $language;
            $lastYear = -1;
            for ($year = self::MIN_YEAR; $year <= self::MAX_YEAR; ++$year) {
                if (($this->year >= 0) and ($year != $this->year)) {
                    continue;
                }
                for ($day = 1; $day <= self::MAX_DAYS; ++$day) {
                    $srcFileName = $this->getSourceName($year, $day);
                    if (!file_exists($srcFileName)) {
                        continue;
                    }
                    ++$countTotal;
                    if ($this->runAllLanguages and ($language != $lastLanguage)) {
                        echo '-------------- ' . $language . ' solutions ' . str_repeat('-', 36 - strlen($language))
                            . PHP_EOL;
                        $lastLanguage = $language;
                    }
                    if ($year != $lastYear) {
                        echo '======= ' . $year . ' ' . str_repeat('=', 45) . PHP_EOL;
                        $lastYear = $year;
                    }
                    // @ phpstan-ignore-next-line
                    if (isset(self::TO_SKIP[$year]) and in_array($day, self::TO_SKIP[$year])) {
                        echo '=== AoC ' . $year . ' Day ' . str_pad(strval($day), 2, '0', STR_PAD_LEFT) . PHP_EOL;
                        echo Tags::WARN_TAG . 'Skipped.' . PHP_EOL;
                        ++$countSkipped;
                        continue;
                    }
                    if ($this->runAsScripts) {
                        $result = $this->runSingleAsScript($year, $day);
                    } else {
                        $result = $this->runSingleAsClass($year, $day);
                        $maxMemory = max($maxMemory, ceil(memory_get_peak_usage() / 1024 / 1024));
                    }
                    if (!$result) {
                        ++$countFails;
                    }
                }
            }
        }
        $spentTime = number_format((hrtime(true) - $startTime) / 1_000_000_000, 3, '.', '');
        $totalMsg = $countTotal . ' solution' . ($countTotal > 1 ? 's' : '');
        $messages = [];
        if ($countFails > 0) {
            $messages[] = $countFails . ' failed';
        }
        // @ phpstan-ignore-next-line
        if ($countSkipped > 0) {
            $messages[] = $countSkipped . ' skipped';
        }
        // @ phpstan-ignore-next-line
        if (($countFails > 0) or ($countSkipped > 0)) {
            $failSkipMsg = ' (' . implode(', ', $messages) . ')';
        } else {
            $failSkipMsg = '';
        }
        $maxMemMsg = ($this->runAsScripts ? '' : '; max memory: ' . $maxMemory . ' MB');
        echo '======= Total: ' . $totalMsg . $failSkipMsg . ' [time: ' . $spentTime . ' sec'
            . $maxMemMsg . ']' . PHP_EOL;
        if ($countTotal > 0) {
            if ($countFails == 0) {
                echo PHP_EOL . Tags::ANSI_GREEN . '[ OK ] All tests passed. ' . Tags::ANSI_RESET . PHP_EOL;
            } else {
                echo PHP_EOL . Tags::ANSI_RED . '[ERROR] There were some unsuccessful tests. ' . Tags::ANSI_RESET
                    . PHP_EOL;
            }
        } else {
            echo PHP_EOL . Tags::WARN_TAG . 'There was nothing to run. ' . PHP_EOL;
        }
        echo PHP_EOL;
    }

    /**
     * Runs a single solution class.
     */
    public function runSingleAsClass(int $year, int $day): bool
    {
        if ($this->runAsScripts) {
            return false;
        }
        $srcFileName = $this->getSourceName($year, $day);
        if (!$this->checkFileExists($srcFileName)) {
            return false;
        }
        $className = $this->getClassName($year, $day);
        $fullClassName = 'TBali\\Aoc' . $year . '\\' . $className;
        /** @var Solution */
        $solution = new $fullClassName();
        $success = $solution->run();
        if (!$success) {
            $this->isOk = false;
        }
        return $success;
    }

    /**
     * Runs a single solution script.
     */
    public function runSingleAsScript(int $year, int $day): bool
    {
        if (!$this->runAsScripts) {
            return false;
        }
        $srcFileName = $this->getSourceName($year, $day);
        if (!$this->checkFileExists($srcFileName)) {
            return false;
        }
        $runCommand = (self::LANGUAGES[$this->language][0] ?? 'php') . ' ' . $srcFileName;
        if (PHP_OS_FAMILY == 'Windows') {
            $runCommand = str_replace('/', '\\', $runCommand);
        }
        $execResultCode = 0;
        $execResult = system($runCommand, $execResultCode);
        if (($execResult === false) or ($execResultCode != 0)) {
            $this->isOk = false;
            echo self::ERROR_TAG . 'Execution failed for ' . $srcFileName . PHP_EOL;
            return false;
        }
        return true;
    }

    /**
     * @param array<int, string> $args The PHP $argv of the script (CLI args are from index 1)
     */
    private function processArgs(array $args): void
    {
        $errorMsg = self::ERROR_TAG . 'Invalid command line arguments' . PHP_EOL . PHP_EOL
            . 'Usage:  php src/aoc.php [language] [year] [day]' . PHP_EOL
            . PHP_EOL
            . '+----------------------------+-----------------------------------------------------+' . PHP_EOL
            . '| Argument                   | Effect                                              |' . PHP_EOL
            . '+----------------------------+-----------------------------------------------------+' . PHP_EOL
            . '| LANGUAGE given             | invoke interpreter with standalone solution scripts |' . PHP_EOL
            . '| \'all\' given as LANGUAGE    | invoke standalone solution scripts in all languages |' . PHP_EOL
            . '| LANGUAGE not given         | invoke class-based PHP solutions                    |' . PHP_EOL
            . '| none of YEAR and DAY given | run all solutions                                   |' . PHP_EOL
            . '| only YEAR given            | run all solutions for that season only              |' . PHP_EOL
            . '| both YEAR and DAY given    | run a specific solution                             |' . PHP_EOL
            . '+----------------------------+-----------------------------------------------------+' . PHP_EOL
            . PHP_EOL
            . 'Possible values for [language]:' . PHP_EOL
                . '  all, ' . implode(', ', array_keys(self::LANGUAGES)) . PHP_EOL
            . PHP_EOL;
        if (count($args) > 4) {
            echo $errorMsg;
            exit(1);
        }
        $this->year = -1;
        $this->day = -1;
        $this->runAsScripts = false;
        $this->language = '';
        if (count($args) == 1) {
            return;
        }
        $idxYear = 1;
        if (strtolower($args[1]) == 'all') {
            $this->runAsScripts = true;
            $this->runAllLanguages = true;
            $idxYear = 2;
        } elseif (isset(self::LANGUAGES[strtolower($args[1])])) {
            $this->runAsScripts = true;
            $this->language = strtolower($args[1]);
            $idxYear = 2;
        }
        if (count($args) == $idxYear + 2) {
            $this->day = intval($args[$idxYear + 1]);
            if (($this->day < self::MIN_DAYS) or ($this->day > self::MAX_DAYS)) {
                echo $errorMsg;
                exit(1);
            }
        }
        if (count($args) >= $idxYear + 1) {
            $this->year = intval(strtolower($args[$idxYear]));
            if (($this->year < self::MIN_YEAR) or ($this->year > self::MAX_YEAR)) {
                echo $errorMsg;
                exit(1);
            }
        }
    }

    private function getClassName(int $year, int $day): string
    {
        return 'Aoc' . $year . 'Day' . str_pad(strval($day), 2, '0', STR_PAD_LEFT);
    }

    private function getSourceName(int $year, int $day): string
    {
        return 'src/'
        . ($this->runAsScripts ? 'other/' : '')
        . 'Aoc' . $year . '/' . $this->getClassName($year, $day)
        . (($this->runAsScripts && ($this->language == 'php')) ? 'scr' : '')
        . '.' . ($this->runAsScripts ? self::LANGUAGES[$this->language][1] ?? '' : 'php');
    }

    private function checkFileExists(string $srcFileName): bool
    {
        if (!file_exists($srcFileName)) {
            echo self::ERROR_TAG . 'Cannot find solution source file: ' . $srcFileName . PHP_EOL;
            $this->isOk = false;
            return false;
        }
        return true;
    }
}
