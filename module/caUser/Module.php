<?php

namespace caUser;

use Zend\ModuleManager\Feature\ServiceProviderInterface;
use Zend\Mvc\ModuleRouteListener;
use caUser\Auth\SocialAuth\SocialAuthService;
use Zend\Authentication\AuthenticationService,
    Zend\Mvc\MvcEvent;

class Module implements ServiceProviderInterface
{
    
    
    public function onBootstrap(MvcEvent $e)
    {
        $e->getApplication()->getServiceManager()->get('translator');
        $eventManager        = $e->getApplication()->getEventManager();
        $moduleRouteListener = new ModuleRouteListener();
        $moduleRouteListener->attach($eventManager);
        //$eventManager->attach('dispatch', array($this, 'checkAcl'));
    }
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
                },
            ),
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
 
    
    public function getViewHelperConfig()
    {
        return array(
            'invokables' => array(
                'loginHelper' => 'caUser\View\Helper\LoginHelper'
            ),
        );
    }
    
    public function checkAcl(MvcEvent $e)
    {
        
        $application = $e->getApplication();
        $sm = $application->getServiceManager();
        $router = $sm->get('router');
        $request = $sm->get('request');
        $aclService = new Auth\Acl\AclService();
        
        if(!$aclService->canAccess($router, $request)){
            
            $url = $router->assemble(array(), array('name' => 'error', ['action' => 'access'],));
            $response = $e->getResponse();
            $response->setHeaders($response->getHeaders()->addHeaderLine('Location', $url));
            $response->setStatusCode(302);
            $response->sendHeaders();
            exit();
        }
    }
}
