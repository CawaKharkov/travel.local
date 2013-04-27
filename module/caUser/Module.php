<?php
namespace caUser;
use Zend\ModuleManager\Feature\ServiceProviderInterface;
use Zend\Authentication\AuthenticationService;

class Module implements ServiceProviderInterface
{
    /**
     * Expected to return \Zend\ServiceManager\Config object or array to
     * seed such an object.
     *
     * @return array|\Zend\ServiceManager\Config
     */
    public function getServiceConfig()
    {
        return array(
            'factories' => array(
                'Zend\Authentication\AuthenticationService' => function($serviceManager) {
                    // If you are using DoctrineORMModule:
                    return $serviceManager->get('doctrine.authenticationservice.orm_default');
                }
            )
        );
    }

    public function getConfig()
    {
        $module = require __DIR__ . '/config/module.config.php';
        //$config = array_merge_recursive($LexUserConfig,$module);
        return $module;
    }

    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }

}
