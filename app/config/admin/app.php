<?php
require_once __DIR__ . '/init.php';

return [
    'name' => 'Eflima',
    'sourceLanguage' => 'en-US',
    'id' => 'eflima.angular.backend.v0.0.1',
    'vendorPath' => '@vendor',
    'basePath' => '@app',
    'components' => require_once __DIR__ . '/components.php',
    'modules' => require_once __DIR__ . '/modules.php',
    'bootstrap' => require_once __DIR__.'/bootstraps.php',
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm' => '@vendor/npm-asset',
    ],
];
