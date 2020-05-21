<?php

use eflima\core\components\oauth2\Factory;
use eflima\core\Core;
use yii\debug\Module as DebugModule;
use yii\gii\Module as GiiModule;

$modules = [
    'core' => [
        'class' => Core::class,
        'components' => [
            'oauth2' => [
                'class' => Factory::class,
            ],
        ],
    ],
];

if (YII_ENV_DEV) {
    $modules['debug'] = [
        'class' => DebugModule::class,
        'traceLine' => '<a href="phpstorm://open?url={file}&line={line}">{file}:{line}</a>',
    ];
    $modules['gii'] = [
        'class' => GiiModule::class,
        'generators' => [
            'model' => [
                'class' => 'yii\gii\generators\model\Generator',
                'templates' => [
                    'Eflima Model' => '@eflima/core/gii-templates',
                ],
            ],
        ],
    ];
}

return $modules;
