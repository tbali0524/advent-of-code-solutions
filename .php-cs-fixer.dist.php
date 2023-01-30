<?php

// php-cs-fixer configuration
//   rulesets: https://cs.symfony.com/doc/ruleSets/index.html

declare(strict_types=1);

$finder = PhpCsFixer\Finder::create()
    ->in(__DIR__)
    ->name('*.php')
    ->ignoreVCSIgnored(true)
    ->exclude('.git/')
    ->exclude('.tools/')
    ->exclude('vendor/')
;

return (new PhpCsFixer\Config())
    ->setRules([
        '@PHP82Migration' => true,
        '@PHP80Migration:risky' => true,    // this also needs: ->setRiskyAllowed(true)
        '@PhpCsFixer' => true,              // includes @Symfony, @PER, @PSR12, @PSR2, @PSR1
        // override some @Symfony rules
        'blank_line_before_statement' => false,
        'concat_space' => ['spacing' => 'one'],
        'phpdoc_to_comment' => false,
        'yoda_style' => false,
    ])
    ->setRiskyAllowed(true)
    ->setCacheFile(__DIR__ . '/.tools/.php-cs-fixer.cache')
    ->setIndent("    ")
    ->setLineEnding("\n")
    ->setFinder($finder)
;
