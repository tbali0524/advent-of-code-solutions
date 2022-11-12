# Advent of Code solutions in PHP by TBali

![php-version-81](https://shields.io/badge/php->=8.1-blue)

* [AoC website](https://adventofcode.com/)
* My AoC username: `tbali0524`

## Batch solution runner

Run solutions from the project base directory with:

```sh
php src/aoc.php [LANGUAGE] [YEAR] [DAY]
```

| Argument                       | Effect                                              |
|:-------------------------------|:----------------------------------------------------|
| `LANGUAGE` given               | invoke interpreter with standalone solution scripts |
| `LANGUAGE`=`all` given         | invoke standalone solution scripts in all languages |
| `LANGUAGE` not given           | invoke class-based PHP solutions                    |
| none of `YEAR` and `DAY` given | run all solutions                                   |
| only `YEAR` given              | run all solutions for that season only              |
| both `YEAR` and `DAY` given    | run a specific solution                             |

On Windows, the shortcut `.\aoc.bat [LANGUAGE] [YEAR] [DAY]` also works.

Possible values for `LANGUAGE`: _dart, f#, go, groovy, java, javascript, lua, perl, php, python, ruby, scala_.

_Note: Before first run, use `composer install` to setup the class autoloader. There are __NO__ 3rd-party package depencdencies._

## Class-based PHP solutions

* Directory pattern: `src/AocYYYY/`
* Filename pattern: `AocYYYYDayDD.php`, with the day id padded to 2 digits.
* For a new solution use the template in `src/Aoc/Aoc2022Day00.php`.
* Solution should implement class `AocYYYYDayDD`, extending `BaseSolution`.
* It should implement `solve()` method and override constants in `Solution` interface.
* The `solve()` method must be callable repeatedly with different inputs.
* After successful submit, the puzzle answers shall be recorded in the `SOLUTIONS` class constant (for future test runs).

## Puzzle inputs

* Directory pattern: `input/YYYY/`
* Filename pattern: `aocYY_DD.txt`
* Optional additional example inputs are in `aocYY_DDex1.txt` and `aocYY_DDex2.txt`
* Otherwise Single input can be given as the `STRING_INPUT` constant in the solution class.

## Standalone script-based solutions

* Directory pattern: `src/other/AocYYYY/`
* Filename pattern: `AocYYYYDayDD.ext`, with the day id padded to 4 digits.
    * (For `PHP` only: the pattern is `AocYYYYDayDDscr.php` to avoid having the same name as the class-based solution.)
* The script shall read the input file (if needed), print the problem ID and the solution.
