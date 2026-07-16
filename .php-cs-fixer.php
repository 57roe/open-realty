<?php

$finder = PhpCsFixer\Finder::create()
    ->exclude('include/language')
    ->exclude('install/language')
    ->exclude('vendor')
    ->exclude('node_modules')
    ->exclude('template')
    ->exclude('addons')
    ->exclude('tests/_support/_generated/')
    ->in('src')
;

$config = new PhpCsFixer\Config();
return $config->setRules([
        '@PSR2' => true,
        //'@PHP74Migration' => true,
        //'strict_param' => true,
        //'array_syntax' => ['syntax' => 'short'],
    ])
    ->setFinder($finder)
;
