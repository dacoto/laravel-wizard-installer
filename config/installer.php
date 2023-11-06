<?php

return [
    'icon' => '/images/icon.png',

    'background' => '/images/background.jpeg',

    'support_url' => 'https://dacoto.com/contact',

    'server' => [
        'php' => [
            'name' => 'PHP Version',
            'version' => '>= 8.1.0',
            'check' => [
                'type' => 'php',
                'value' => 80100
            ]
        ],
        'pdo' => [
            'name' => 'PDO',
            'check' => [
                'type' => 'extension',
                'value' => 'pdo_mysql'
            ]
        ],
        'mbstring' => [
            'name' => 'Mbstring extension',
            'check' => [
                'type' => 'extension',
                'value' => 'mbstring'
            ]
        ],
        'fileinfo' => [
            'name' => 'Fileinfo extension',
            'check' => [
                'type' => 'extension',
                'value' => 'fileinfo'
            ]
        ],
        'openssl' => [
            'name' => 'OpenSSL extension',
            'check' => [
                'type' => 'extension',
                'value' => 'openssl'
            ]
        ],
        'tokenizer' => [
            'name' => 'Tokenizer extension',
            'check' => [
                'type' => 'extension',
                'value' => 'tokenizer'
            ]
        ],
        'json' => [
            'name' => 'Json extension',
            'check' => [
                'type' => 'extension',
                'value' => 'json'
            ]
        ],
        'curl' => [
            'name' => 'Curl extension',
            'check' => [
                'type' => 'extension',
                'value' => 'curl'
            ]
        ]
    ],

    'folders' => [
        'storage.framework' => [
            'name' => '/storage/framework',
            'check' => [
                'type' => 'directory',
                'value' => '../storage/framework'
            ]
        ],
        'storage.logs' => [
            'name' => '/storage/logs',
            'check' => [
                'type' => 'directory',
                'value' => '../storage/logs'
            ],
        ],
        'storage.cache' => [
            'name' => '/bootstrap/cache',
            'check' => [
                'type' => 'directory',
                'value' => '../bootstrap/cache'
            ]
        ],
    ],

    'database' => [
        'seeders' => false
    ],

    'commands' => [
        'install:users'
    ],

    'admin_area' => [
        'user' => [
            'email' => 'admin@example.com',
            'password' => 'password'
        ]
    ],

    'login' => '/login'
];
