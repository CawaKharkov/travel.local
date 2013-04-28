<?php
/**
 * Zend Framework [http://framework.zend.com/]
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright [c] 2005-2012 Zend Technologies USA Inc. [http://www.zend.com]
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */
namespace caUser;

return [
    'router' => [
        'routes' => [
            'Cabinet' => [
                'type' => 'Segment',
                'options' => [
                    'route'    => '/cabinet[/:id]',
                    'defaults' => [
                        'controller' => 'UserController',
                        'action'     => 'cabinet',
                    ],
                ],
            ],
            'cuUser' => [
                'type' => 'Segment',
                'options' => [
                    'route'    => '/causer[/:action]',
                    'defaults' => [
                        'controller' => 'UserController',
                        'action'     => 'login',
                    ],
                ],
            ],
        ],
    ],
    'controllers' => [
        'invokables' => [
            'UserController' => 'caUser\Controller\UserController',
        ],
    ],
    'view_manager' => [
        'template_path_stack' => [
            'causer' => __DIR__ . '/../view',
        ],
        'strategies' => [
            'ViewJsonStrategy',
        ],
    ],
];