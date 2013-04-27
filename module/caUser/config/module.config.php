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
            'Login' => [
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => [
                    'route'    => '/login',
                    'defaults' => [
                         '__NAMESPACE__' => 'caUser\Controller',
                        'controller' => 'UserController',
                        'action'     => 'login',
                    ],
                ],
            ],
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
//    'doctrine' => array(
//        'authentication' => array(
//            'orm_default' => array(
//                'object_manager' => 'Doctrine\ORM\EntityManager',
//                'identity_class' => 'caUser\Entity\User',
//                'identity_property' => 'email',
//                'credential_property' => 'password',
//                'credentialCallable' => function(\caUser\Framework\EntityDefault $user, $passwordGiven){
//                    return \caUser\Service\UserService::checkCredencial($passwordGiven, $user->getPassword());
//                },
//            ),
//        ),
//        'driver' => array(
//            'caUser_Driver' => array(
//                'class' => 'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
//                'cache' => 'array',
//                'paths' => array(
//                    __DIR__ . '/../src/' .__NAMESPACE__. '/Entity'
//                )
//            ),
//            'orm_default' => array(
//                'drivers' => array(
//                    __NAMESPACE__ . '\Entity' => 'caUser_Driver'
//                )
//            ),
//        ),
//    ),
];