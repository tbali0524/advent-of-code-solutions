<?php

/**
 * Advent of Code - CLI solution runner.
 */

declare(strict_types=1);

require __DIR__ . '/../vendor/autoload.php';

use TBali\Aoc\Runner;

$runner = new Runner($argv);
$runner->run();
exit($runner->isOk ? 0 : 1);
