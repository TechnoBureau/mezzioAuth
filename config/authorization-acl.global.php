<?php

declare(strict_types=1);

return [
    'roles'     => [
        'guest' => [],
        'user'  => ['guest'],
        'admin' => ['user'],
    ],
    'resources' => [
        'api.ping.view',
        'home.view',
        'admin.view',
        'login.form',
        'logout.access',
    ],
    'allow'     => [
        'guest' => [
            'login.form',
            'api.ping.view',
        ],
        'user'  => [
            'logout.access',
            'home.view',
        ],
        'admin' => [
            'admin.view',
        ],
    ],
];
