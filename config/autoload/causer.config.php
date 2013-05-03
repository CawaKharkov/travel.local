<?php
return [
    'causer' => [
        'password_restore' => [
            'mail' => [
                ## Configuration for login auth
                'smtp' => [
                    'name'              => 'localhost',
                    'host'              => 'localhost',
                    'port'              => 25,
                    'connection_class'  => 'login',
                    'connection_config' => [
                        'username' => '',
                        'password' => '',
                    ],
                ],
                ## Configuration for plain auth
    //            'smtp' => [
    //                'name'              => 'localhost',
    //                'host'              => 'localhost',
    //                'port'              => 25,
    //                'connection_class'  => 'plain',
    //                'connection_config' => [
    //                    'username' => '',
    //                    'password' => '',
    //                ],
    //            ],
                ## Basic configuration
    //            'smtp' => [
    //                'name'              => 'localhost',
    //                'host'              => 'localhost',
    //                'port'              => 25,
    //            ],
                'options' => [
                    'sender' => 'robot@travelclub.ru',
                    'subject' => 'welcome! I\'m a test message! well done?'
                ]

            ],
            'password_length' => 6,
        ],
        'options' => [
            ##redirect options after login, registration
            'redirect' => [
                ## Route name
                'route' => 'Cabinet',
            ]
        ]
    ]
];
