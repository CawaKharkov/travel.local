<?php
/**
 * Description of TestController
 *
 * @author Cawa
 */

namespace Application\Controller;

use Zend\View\Model\ViewModel;

class TestController extends AbstractController
{
    
    
    public function indexAction()
    {
        $this->acl();
        return new ViewModel();
    }
	
}
