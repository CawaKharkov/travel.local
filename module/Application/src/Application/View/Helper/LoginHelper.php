<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of LoginHelper
 *
 * @author Cawa
 */

namespace Application\View\Helper;
 
use Zend\View\Helper\Identity,
    Zend\Session\Container as SessionContainer,
    //Application\Entity\User,
    Zend\Form\Element;
 
 
class LoginHelper extends Identity
{
    
    protected $sesscontainer;
 
    public function __construct()
    {
        $this->getSessContainer();
    }
 
    public function __invoke()
    {
//        parent::__invoke();

        $this->userInfo();
        $this->loginForm();
    }
    
    
    protected function getSessContainer()
    {
        if (!$this->sesscontainer) {
            $this->sesscontainer = new SessionContainer('user');
        }
        return $this->sesscontainer;
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
        
    }
}
