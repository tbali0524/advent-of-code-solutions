# Advent Of Code solutions in PHP by TBali

* [AoC website](https://adventofcode.com/)
* My username: tbali0524

## Runner

Run solutions with :

```sh
php src/aoc.php [YEAR] [DAY]
```

or

```sh
./aoc.bat [YEAR] [DAY]
```

* No arguments: run all solutions
* Only YEAR given: run all solution for that season only
* YEAR and DAY given: run a specific solution

## Structure

* Puzzle inputs:
    * in `input/YYYY/` directory
    * named `aocYY_DD.txt`
    * optional additional example inputs are in `aocYY_DDex1.txt` and `aocYY_DDex2.txt`
* Solutions source:
    * in `src/AocYYYY/` directory
    * named `AocYYYYDayDD.php`
    * use template in `src/Aoc/Aoc2022Day00.php`
    * should implement class `AocYYYYDayDD`, extending `BaseSolution`
    * should implement `solve()` method and override constants in `Solution` interface
    * `solve()` must be callable repeatedly with different inputs
    * after successful submit, the puzzle answers shall be recorded in the `SOLUTIONS` class constant (for future test runs.)
