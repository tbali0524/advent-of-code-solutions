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
        '@PhpCsFixer' => true,              // includes @Symfony, @PSR12, @PSR2, @PSR1
        // override some @Symfony rules
        'blank_line_before_statement' => false,
        'concat_space' => ['spacing' => 'one'],
        'yoda_style' => false,
        // override some @PhpCsFixer rules
        'binary_operator_spaces' => false,
        'explicit_string_variable' => false,
        'ordered_class_elements' => false,
    ])
    ->setCacheFile(__DIR__ . '/.tools/.php-cs-fixer.cache')
    ->setIndent("    ")
    ->setLineEnding("\n")
    ->setFinder($finder)
;
