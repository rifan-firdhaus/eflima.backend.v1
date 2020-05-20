<?php

use eflima\core\Core;
use yii\debug\Module as DebugModule;
use yii\gii\Module as GiiModule;

$modules = [
    'core' => Core::class,
];

if (YII_ENV_DEV) {
    $modules['debug'] = [
        'class' => DebugModule::class,
        'traceLine' => '<a href="phpstorm://open?url={file}&line={line}">{file}:{line}</a>',
    ];
    $modules['gii'] = [
        'class' => GiiModule::class,
    ];
}

return $modules;
