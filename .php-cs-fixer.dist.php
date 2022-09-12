<?php

$finder = PhpCsFixer\Finder::create()
    ->exclude([
        '.idea',
        'coverage',
        'storage',
        'bootstrap/cache',
        'node_modules',
    ])
    ->in(__DIR__);

$config = new PhpCsFixer\Config();

return $config->setRules([
    '@PSR12' => true,
    'no_unused_imports' => true,
    'array_syntax' => ['syntax' => 'short'],
])->setFinder($finder);
