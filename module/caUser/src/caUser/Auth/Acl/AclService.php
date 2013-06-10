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
namespace caUser\Auth\Acl;

use Zend\Mvc\Router\RouteStackInterface,
    Zend\Http\Request,
    Zend\Session\Container as SessionContainer,
    Zend\Permissions\Acl\Acl as Acl,
    Zend\Permissions\Acl\Role\GenericRole as Role;

class AclService  extends Acl
{
  
    public $canAcces;
    protected $sesscontainer;


    public function __construct() 
    {
        
      
        $this->deny();
        $this->addRole(new Role('anonymous'));
        $this->addRole(new Role('user'), 'anonymous');
        $this->addRole(new Role('admin'), 'user');

        $this->addResource('application'); // Application module
        $this->addResource('causer'); // Application module
        
        
        $this->allow('anonymous', 'causer', null);
        $this->allow('anonymous', 'application', null);
    }
    
    public function canAccess(RouteStackInterface $router, Request $request)
    { 
        $routeMatch = $router->match($request);
       
         // set ACL
        

        $moduleName = $routeMatch->getParam('__NAMESPACE__', 'application');
        $moduleName = explode('\\', $moduleName);
        $moduleName = strtolower(array_shift($moduleName));
        
        $role = (!$this->getSessContainer()->role ) ? 'anonymous' : $this->getSessContainer()->role;
        $actionName = strtolower($routeMatch->getParam('action', 'not-found')); // get the action name 
        $controllerName = strtolower($routeMatch->getParam('controller', 'not-found'));     // get the controller name     
        
        /*var_dump($moduleName);
        var_dump($controllerName);
        var_dump($actionName);
        var_dump($this->isAllowed($role,$moduleName,$controllerName.':'.$actionName));die();*/
        if ($this->isAllowed($role,$moduleName,$controllerName.':'.$actionName))
        {
            $this->canAcces = true;
       }else {
            $this->canAcces = false;
       }
       return $this->canAcces;
    }

    
    private function getSessContainer()
    {
        if (!$this->sesscontainer) {
            $this->sesscontainer = new SessionContainer('user');
        }
        return $this->sesscontainer;
    }

}
