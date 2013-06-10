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

namespace caUser\View\Helper;

use Zend\View\Helper\Identity,
    Zend\Session\Container as SessionContainer,
    //Application\Entity\User,
    Zend\Form\Element;
use Zend\View\Model\ViewModel;
use Zend\View\Renderer\PhpRenderer;


class LoginHelper extends Identity
{

    protected $sesscontainer;

    public function __construct()
    {
        $this->getSessContainer();
    }

    public function __invoke()
    {
// parent::__invoke();

        $this->userInfo();
        $form = new \caUser\Form\LoginForm();
        return $this->getView()->partial('/ca-user/user/login', array('form' => $form));
    }


    protected function getSessContainer()
    {
        if (!$this->sesscontainer) {
            $this->sesscontainer = new SessionContainer('user');
        }
        return $this->sesscontainer;
    }


    protected function userInfo()
    {

    }
}