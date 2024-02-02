#!/usr/bin/env php
<?php

/**
 * Advent of Code - CLI solution runner.
 */

declare(strict_types=1);

namespace TBali;

use TBali\Aoc\AocRunner;

require __DIR__ . '/../vendor/autoload.php';

$runner = new AocRunner($argv);
$runner->run();
exit($runner->isOk ? 0 : 1);
