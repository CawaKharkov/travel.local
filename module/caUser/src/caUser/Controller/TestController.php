<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of testController
 *  controller for testing some functionality, can accesss by route /test
 * @author Cawa
 */
namespace caUser\Controller;


use Zend\View\Model\ViewModel;

class TestController extends AbstractController
{
    
    
    public function indexAction()
    {
        
        $this->vkLogin();
        die('1');
    }
}
