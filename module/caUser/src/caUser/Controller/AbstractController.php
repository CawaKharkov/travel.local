<?php
/*
 * @author Cawa
 * 
 */
namespace caUser\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\Session\Container;

class AbstractController extends AbstractActionController
{
   
    protected $session;
    

    public function vkLogin()
    {
        $serviceLocator = $this->getServiceLocator();
        $vkResponse = $this->vkAuthPlugin()->auth($serviceLocator,  $this->getRequest());;
        $this->session = new Container('user');    
        var_dump($this->session->user_id);
        var_dump($vkResponse);
        
    }
   
}
