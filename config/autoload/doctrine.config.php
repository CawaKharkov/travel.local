<?php
return array(
    'doctrine' => array(
        'connection' => array(
            'orm_default' => array(
                'driverClass' => 'Doctrine\DBAL\Driver\PDOMySql\Driver',
                'params' => array(
                    'host'     => 'localhost',
                    'port'     => '3306',
                    'user'     => 'root',
                    'password' => 'cawa123azs',
                    'dbname'   => 'travel',
                    'driverOptions' => array(
                        1002 => 'SET NAMES utf8',
                    ),
                )
            )
        ),
        'authentication' => array(
            'orm_default' => array(
                'object_manager' => 'Doctrine\ORM\EntityManager',
                'identity_class' => 'caUser\Entity\User',
                'identity_property' => 'email',
                'credential_property' => 'password',
                'credentialCallable' => function(\caUser\Framework\EntityDefault $user, $passwordGiven){
                    return \caUser\Service\UserService::checkCredencial($passwordGiven, $user->getPassword());
                },
            ),
        ),
    ),
);