<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of AclService
 *
 * @author Cawa
 */
namespace Application\Auth\Acl;

use Zend\Mvc\Router\RouteStackInterface,
    Zend\Http\Request,
    Zend\Session\Container as SessionContainer,
    Zend\Permissions\Acl\Acl,
    Zend\Permissions\Acl\Role\GenericRole as Role,
    Zend\Permissions\Acl\Resource\GenericResource as Resource;

class AclService  extends Acl
{
  
    public $canAcces;
    protected $sesscontainer;


    public function __construct(RouteStackInterface $router, Request $request) 
    {
        $routeMatch = $router->match($request);
       
        $this->canAccess($routeMatch);
    }
    
    protected function canAccess($routeMatch)
    { 
         // set ACL
         $this->canAcces = false;
        $this->deny();
        $this->addRole(new Role('anonymous'));
        $this->addRole(new Role('user'), 'anonymous');
        $this->addRole(new Role('admin'), 'user');

        $this->addResource('application'); // Application module

        $this->allow('anonymous', 'application', 'index:index');
        $this->allow('anonymous', 'application', 'error:index');
        $this->deny('anonymous', 'application', 'test:index');


        $moduleName = $routeMatch->getParam('__NAMESPACE__', 'application');
        $moduleName = strtolower(array_shift(explode('\\', $moduleName)));
        
        $role = (!$this->getSessContainer()->role ) ? 'anonymous' : $this->getSessContainer()->role;
        $actionName = strtolower($routeMatch->getParam('action', 'not-found')); // get the action name 
        $controllerName = strtolower($routeMatch->getParam('controller', 'not-found'));     // get the controller name     
        
        
        if ($this->isAllowed($role,$moduleName,$controllerName.':'.$actionName))
        {
            $this->canAcces = true;
       }
    }

    
    private function getSessContainer()
    {
        if (!$this->sesscontainer) {
            $this->sesscontainer = new SessionContainer('user');
        }
        return $this->sesscontainer;
    }

}
