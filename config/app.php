<?php

return [
    'name' => 'pframework-app',
    'host' => '127.0.0.1',
    'port' => 8080,
    'providers' => [
        pframework\web\WebApplicationProvider::class,
    ],
    'db' => [
        'single' => [
            'host' => '127.0.0.1',
            'port' => 3306,
            'db' => 'test',
            'username' => 'root',
            'password' => 'root',
        ],
        'mutiply' => [
            'tables' => [
                'order' => [
                    'shard' => 10,
                    'strategy' => pframework\db\strategy\Crc32Strategy::class
                ],
                'user' => [
                    'shard' => 20,
                    'strategy' => pframework\db\strategy\ModStrategy::class
                ]
            ],
            'strategy' => pframework\db\strategy\ModStrategy::class,
            'connections' => [
                [
                    'host' => '127.0.0.1',
                    'port' => 3306,
                    'db' => 'test',
                    'username' => 'root',
                    'password' => 'root',
                ],
                [
                    'host' => '127.0.0.1',
                    'port' => 3306,
                    'db' => 'test1',
                    'username' => 'root',
                    'password' => 'root',
                ],
            ],
        ]
    ],
];
