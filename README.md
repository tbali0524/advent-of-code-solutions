# Advent Of Code solutions in PHP by TBali

![php-version-81](https://shields.io/badge/php->=8.1-blue)

* [AoC website](https://adventofcode.com/)
* My AoC username: `tbali0524`

## Batch solution runner

Run solutions from the project base directory with:

```sh
php src/aoc.php [YEAR] [DAY]
```

|Argument|Effect|
|:--|:--|
|none|run all solutions|
|only `YEAR` given|run all solution for that season only|
|both `YEAR` and `DAY` given|run a specific solution|

On Windows the shortcut `.\aoc.bat [YEAR] [DAY]` also works.

_Note: Before first run, use `composer install` to setup the class autoloader. There are __NO__ 3rd-party package depencdencies._

## Puzzle inputs

* directory pattern: `input/YYYY/`
* filename pattern: `aocYY_DD.txt`
* optional additional example inputs are in `aocYY_DDex1.txt` and `aocYY_DDex2.txt`

## Solutions source

* directory pattern:  `src/AocYYYY/`
* filename pattern: `AocYYYYDayDD.php`
* for new solution use the template in `src/Aoc/Aoc2022Day00.php`
* solution should implement class `AocYYYYDayDD`, extending `BaseSolution`
* should implement `solve()` method and override constants in `Solution` interface
* the `solve()` method must be callable repeatedly with different inputs
* after successful submit, the puzzle answers shall be recorded in the `SOLUTIONS` class constant (for future test runs.)

## Script runner

Running solutions in standalone scripts is also possible with:

```sh
php src/aoc_script.php [YEAR] [DAY]
```

* By default, this runs `Python` scripts, edit the above script for a different interpreter.
* Sourcefile naming pattern: `src/AocYYYY/Aoc2022Day00.py`
