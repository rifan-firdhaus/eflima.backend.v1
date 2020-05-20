<?php
$bootstraps = [
    'core',
];

if (YII_ENV_DEV) {
    $bootstraps[] = 'debug';
    $bootstraps[] = 'gii';
}


return $bootstraps;
