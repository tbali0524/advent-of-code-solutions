#!/usr/bin/env php
<?php

/**
 * Advent of Code - Example script to run a class-based solution without using AocRunner.
 *
 * Instead of this, use aoc.php
 */

declare(strict_types=1);

namespace TBali;

use TBali\Aoc2017\Aoc2017Day01;

require __DIR__ . '/../vendor/autoload.php';

echo '=== AoC 2017 Day 1 : Inverse Captcha' . PHP_EOL;
$solver = new Aoc2017Day01();
// $input = [strval($solver::STRING_INPUT)];
$input = $solver->readInput('input/2017/Aoc2017Day01.txt');
[$ans1, $ans2] = $solver->solve($input);
echo $ans1 . PHP_EOL . $ans2 . PHP_EOL;
