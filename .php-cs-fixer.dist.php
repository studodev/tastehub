<?php

use PhpCsFixer\Config;
use PhpCsFixer\Finder;
use PhpCsFixer\Runner\Parallel\ParallelConfigFactory;

$finder = (new Finder())
    ->in(__DIR__)
    ->exclude('var')
;

$config = new Config();
$config
    ->setCacheFile('var/cache/.php-cs-fixer.cache')
    ->setParallelConfig(ParallelConfigFactory::detect())
    ->setRules([
        '@Symfony' => true,
        'concat_space' => [
            'spacing' => 'one',
        ],
        'global_namespace_import' => [
            'import_classes' => true,
        ],
        'increment_style' => [
            'style' => 'post',
        ],
        'phpdoc_align' => [
            'align' => 'left',
        ],
    ])
    ->setFinder($finder)
;

return $config;
