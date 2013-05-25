<?php
return [
    'router' => [
        'routes' => [
            'cabinet' => [
                'type' => 'Segment',
                'options' => [
                    'route' => '/cabinet[/:id]',
                    'defaults' => [
                        'controller' => 'UserController',
                        'action' => 'cabinet',
                    ],
                ],
            ],
            'causer' => [
                'type' => 'Segment',
                'options' => [
                    'route' => '/user[/:action]',
                    'defaults' => [
                        'controller' => 'UserController',
                        'action' => 'login',
                    ],
                ],
            ],
            'test' => [
                'type' => 'Literal',
                'options' => array(
                    'route' => '/test',
                    'defaults' => array(
                        'controller' => 'TestController',
                        'action' => 'index',
                    ),
                ),]
        ],
    ],
];