<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 
 */

/**
 * Description of LoginHelper
 * display information about user that has been logged in
 */

namespace caUser\View\Helper;
 
use Zend\View\Helper\Identity,
    Zend\Session\Container as SessionContainer,
    caUser\Entity\User,
    Zend\View\Helper\AbstractHelper,
    Zend\Form\Element;

class UserInfoHelper extends AbstractHelper
{
    protected $sesscontainer;
 
    public function __construct()
    {
        $this->getSessContainer();
    }
    protected function getSessContainer()
    {
        if (!$this->sesscontainer) {
            $this->sesscontainer = new SessionContainer('user');
        }
        return $this->sesscontainer;
    }

    public function __invoke()
    {
        if($this->sesscontainer->username)
            $this->userInfo();
        else
            $this->loginForm();
    }
    
    protected function loginForm()
    {
        
     echo '<form method="post" action=\'\' name="login_form">
            <p><input type="text" class="span3" name="eid" id="email" placeholder="Email"></p>
            <p><input type="password" class="span3" name="passwd" placeholder="Password"></p>
            <p><button type="submit" class="btn btn-primary">Sign in</button>
                <a href="#">Forgot Password?</a>
            </p>
        </form>';
                  
    }
    
    protected function userInfo()
    {
        //$aUser = $service->getCurrentUser();        
        //$aUser = $this->getEntityManager()->getRepository('\caUser\Entity\User')->find($this->sesscontainer->id);
        //$aUser = $objectManager->find('caUser\Entity\User', 1);

        $objectManager = $this
            ->getServiceLocator()
            ->get('Doctrine\ORM\EntityManager');
        
        var_dump($aUser);

        echo "User info".$this->sesscontainer->id;                        
    }
}
